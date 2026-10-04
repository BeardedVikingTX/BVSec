/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Sales Quote Tool Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_sales_tool.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    const $  = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    // ──────────────────────────────────────────────────────────────
    //  LOAD EMBEDDED DATA
    // ──────────────────────────────────────────────────────────────
    const readJSON = (id) => {
        try {
            const el = document.getElementById(id);
            return el ? JSON.parse(el.textContent) : {};
        } catch (e) {
            console.error(`[BVSec:st] failed to parse #${id}`, e);
            return {};
        }
    };

    const PACKAGES = readJSON('st-packages-data');
    const PLANS    = readJSON('st-plans-data');

    // ──────────────────────────────────────────────────────────────
    //  STATE
    // ──────────────────────────────────────────────────────────────
    const state = {
        agent: '',
        services: { web: false, android: false, ios: false, pentest: false },
        recommendation: {}, // { web: 'greenfield', ... }
        recommendedTotal: 0,
        finalPrice: 0,
        overrideActive: false,
        overrideReason: '',
        paymentPlan: 'half',
    };

    const STORAGE_KEY = 'bvsec_sales_quote_v1';

    // ──────────────────────────────────────────────────────────────
    //  UTILS
    // ──────────────────────────────────────────────────────────────
    const formatMoney = (n) =>
        new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            maximumFractionDigits: 0,
        }).format(Math.max(0, Math.round(n)));

    const debounce = (fn, wait = 200) => {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...args), wait);
        };
    };

    // ──────────────────────────────────────────────────────────────
    //  RECOMMENDATION ENGINE
    //  Each service produces a score; score maps to a package tier.
    // ──────────────────────────────────────────────────────────────
    const engine = {

        // ── Website scoring ─────────────────────────────────────
        scoreWeb(formData) {
            let score = 0;

            const pages = formData.get('web_pages') || '';
            const pageScore = {
                '1-3': 1, '4-6': 3, '7-12': 6, '13-25': 9, '25+': 12,
            }[pages] ?? 0;
            score += pageScore;

            const articles = parseInt(formData.get('web_article_count') || '0', 10);
            if (articles > 100) score += 3;
            else if (articles > 30) score += 2;
            else if (articles > 0) score += 1;

            const featureWeights = {
                api: 2, payment: 3, admin: 2, auth: 4, ecommerce: 4,
                cms: 2, multilang: 2, realtime: 3, custom: 3, integration: 2,
            };
            const features = formData.getAll('web_features[]');
            for (const f of features) score += featureWeights[f] || 0;

            const buildType = formData.get('web_build_type');
            if (buildType === 'rescue')   return { tier: 'rescue',     score };
            if (buildType === 'redesign') score += 2;

            let tier;
            if (score <= 2)       tier = 'starter';
            else if (score <= 7)  tier = 'small';
            else if (score <= 14) tier = 'greenfield';
            else                  tier = 'enterprise';

            return { tier, score };
        },

        // ── Mobile scoring (Android or iOS) ─────────────────────
        scoreMobile(formData, platform) {
            let score = 0;

            const screens = formData.get(`${platform}_screens`) || '';
            const screenScore = {
                '1-5': 1, '6-10': 3, '11-20': 6, '20+': 9,
            }[screens] ?? 0;
            score += screenScore;

            const featureWeights = {
                auth: 3, backend: 2, push: 1, payments: 4, offline: 2,
                camera: 2, gps: 2, hardware: 3, realtime: 3, biometric: 2,
            };
            const features = formData.getAll(`${platform}_features[]`);
            for (const f of features) score += featureWeights[f] || 0;

            let tier;
            if (score <= 3)       tier = 'mvp';
            else if (score <= 10) tier = 'native';
            else                  tier = 'enterprise';

            return { tier, score };
        },

        // ── Pentest scoring ─────────────────────────────────────
        scorePentest(formData) {
            const type = formData.get('pentest_type');
            if (type === 'retainer') return { tier: 'retainer', score: 99 };

            let score = 0;
            const scopeWeights = { web: 2, api: 3, mobile: 4, infrastructure: 5, cloud: 3, social: 2 };
            for (const s of formData.getAll('pentest_scope[]')) {
                score += scopeWeights[s] || 0;
            }

            const complianceWeights = { gdpr: 2, ccpa: 1, hipaa: 3, pci: 4, soc2: 3, iso: 3 };
            for (const c of formData.getAll('pentest_compliance[]')) {
                score += complianceWeights[c] || 0;
            }

            let tier;
            if (score <= 3)      tier = 'basic';
            else if (score <= 8) tier = 'standard';
            else                 tier = 'enterprise';

            return { tier, score };
        },

        // ── Compute all recommendations ─────────────────────────
        recompute(formData) {
            const rec = {};
            let total = 0;
            let totalDays = 0;

            if (state.services.web) {
                const r = this.scoreWeb(formData);
                rec.web = { ...r, package: PACKAGES.web[r.tier] };
                total += PACKAGES.web[r.tier].base;
                totalDays = Math.max(totalDays, PACKAGES.web[r.tier].days);
            }
            if (state.services.android) {
                const r = this.scoreMobile(formData, 'android');
                rec.android = { ...r, package: PACKAGES.android[r.tier] };
                total += PACKAGES.android[r.tier].base;
                totalDays = Math.max(totalDays, PACKAGES.android[r.tier].days);
            }
            if (state.services.ios) {
                const r = this.scoreMobile(formData, 'ios');
                rec.ios = { ...r, package: PACKAGES.ios[r.tier] };
                total += PACKAGES.ios[r.tier].base;
                totalDays = Math.max(totalDays, PACKAGES.ios[r.tier].days);
            }
            if (state.services.pentest) {
                const r = this.scorePentest(formData);
                rec.pentest = { ...r, package: PACKAGES.pentest[r.tier] };
                total += PACKAGES.pentest[r.tier].base;
                totalDays = Math.max(totalDays, PACKAGES.pentest[r.tier].days);
            }

            // Dual platform discount — if both Android + iOS selected
            if (state.services.android && state.services.ios) {
                const androidBase = PACKAGES.android[rec.android.tier].base;
                const iosBase     = PACKAGES.ios[rec.ios.tier].base;
                const dualSavings = Math.round((androidBase + iosBase) * 0.10);
                total -= dualSavings;
                rec.dualPlatformDiscount = dualSavings;
            }

            return { rec, total, totalDays };
        },
    };

    // ──────────────────────────────────────────────────────────────
    //  RENDER — Recommendation panel
    // ──────────────────────────────────────────────────────────────
    const renderSummary = (formData) => {
        const { rec, total, totalDays } = engine.recompute(formData);
        state.recommendation = rec;
        state.recommendedTotal = total;

        // Recommended packages list
        const pkgEl = $('#st-summary-packages');
        const entries = Object.entries(rec).filter(([k]) => k !== 'dualPlatformDiscount');

        if (entries.length === 0) {
            pkgEl.innerHTML = `
                <div class="bv-st-summary__empty">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <p>Select services to see recommendations</p>
                </div>`;
        } else {
            let html = '';
            for (const [key, data] of entries) {
                const icon = {
                    web: '<i class="fa-solid fa-code"></i>',
                    android: '<i class="fa-brands fa-android"></i>',
                    ios: '<i class="fa-brands fa-apple"></i>',
                    pentest: '<i class="fa-solid fa-shield-halved"></i>',
                }[key];
                html += `
                    <div class="bv-st-recpkg bv-st-recpkg--${key}">
                        <div class="bv-st-recpkg__icon">${icon}</div>
                        <div class="bv-st-recpkg__body">
                            <span class="bv-st-recpkg__label bv-font-sci-label">${key.toUpperCase()}</span>
                            <span class="bv-st-recpkg__name bv-font-viking-heading">${data.package.label}</span>
                            <span class="bv-st-recpkg__meta bv-font-mono">
                                ${data.package.days} days · ${data.package.tag}
                            </span>
                        </div>
                        <div class="bv-st-recpkg__price bv-font-mono">
                            ${formatMoney(data.package.base)}
                        </div>
                    </div>`;
            }
            if (rec.dualPlatformDiscount) {
                html += `
                    <div class="bv-st-recpkg bv-st-recpkg--discount">
                        <div class="bv-st-recpkg__icon"><i class="fa-solid fa-tags"></i></div>
                        <div class="bv-st-recpkg__body">
                            <span class="bv-st-recpkg__label bv-font-sci-label">DUAL PLATFORM</span>
                            <span class="bv-st-recpkg__name bv-font-viking-heading">Bundle Discount</span>
                            <span class="bv-st-recpkg__meta bv-font-mono">10% off Android + iOS</span>
                        </div>
                        <div class="bv-st-recpkg__price bv-st-recpkg__price--discount bv-font-mono">
                            −${formatMoney(rec.dualPlatformDiscount)}
                        </div>
                    </div>`;
            }
            pkgEl.innerHTML = html;
        }

        // Totals
        $('#st-recommended-total').textContent = formatMoney(total);

        // Final price field
        const fp = $('#st-final-price');
        if (!state.overrideActive || !fp.dataset.touched) {
            fp.value = total > 0 ? String(total) : '';
            state.finalPrice = total;
        }

        // Recompute first payment
        computeFirstPayment();

        // Hidden fields
        const firstTier = entries[0];
        $('#st-rec-package-hidden').value = firstTier ? `${firstTier[0]}:${firstTier[1].tier}` : '';
        $('#st-rec-price-hidden').value = String(total);
        $('#st-final-price-hidden').value = String(state.finalPrice);

        // Progress bar
        updateProgress(formData);
    };

    // ──────────────────────────────────────────────────────────────
    //  PAYMENT — first installment calculation
    // ──────────────────────────────────────────────────────────────
    const computeFirstPayment = () => {
        const plan = PLANS[state.paymentPlan];
        if (!plan) return;

        const basePrice = state.finalPrice || state.recommendedTotal;
        const discount = plan.discount || 0;
        const adjusted = basePrice * (1 - discount); // discount positive = cheaper
        const firstPct = plan.split[0];

        // Final price is the price the client sees. Discount applies to first payment only for display.
        const effective = adjusted;
        const firstPayment = effective * (firstPct / 100);

        $('#st-first-payment').textContent = formatMoney(firstPayment);

        let note = `${firstPct}%`;
        if (firstPct === 100) note += ' at kickoff';
        else if (firstPct === 50) note += ' at kickoff, 50% at delivery';
        else note += ' at kickoff, remainder across milestones';
        if (discount > 0) note += ` · Save ${Math.round(discount * 100)}%`;
        if (discount < 0) note += ` · +${Math.round(Math.abs(discount) * 100)}% split fee`;

        $('#st-first-payment-note').textContent = note;
        $('#st-payment-plan-hidden').value = state.paymentPlan;
    };

    // ──────────────────────────────────────────────────────────────
    //  CONDITIONAL SECTIONS
    // ──────────────────────────────────────────────────────────────
    const toggleSection = (key, visible) => {
        const el = document.getElementById(`section-${key}`);
        if (!el) return;
        el.hidden = !visible;
        // Animate height
        el.style.transition = 'opacity 260ms ease';
        el.style.opacity = visible ? '1' : '0';
    };

    // ──────────────────────────────────────────────────────────────
    //  PROGRESS BAR
    // ──────────────────────────────────────────────────────────────
    const updateProgress = (formData) => {
        const checks = [
            formData.get('client_name'),
            formData.get('client_email'),
            formData.get('client_phone'),
            state.services.web || state.services.android || state.services.ios || state.services.pentest,
            formData.get('service_summary'),
            (state.services.web && formData.get('web_description')) || !state.services.web,
            (state.services.android && formData.get('android_description')) || !state.services.android,
            (state.services.ios && formData.get('ios_description')) || !state.services.ios,
            (state.services.pentest && formData.get('pentest_description')) || !state.services.pentest,
            formData.get('budget_type'),
            state.agent,
        ];
        const done = checks.filter(Boolean).length;
        const pct = Math.round((done / checks.length) * 100);
        const bar = $('#st-progress-bar');
        if (bar) bar.style.width = pct + '%';
    };

    // ──────────────────────────────────────────────────────────────
    //  FORM CHANGE HANDLER
    // ──────────────────────────────────────────────────────────────
    const readFormState = () => {
        const form = $('#bv-sales-form');
        const fd = new FormData(form);

        state.agent = $('#agent_name')?.value || '';
        state.services = {
            web:     $('#service_web')?.checked || false,
            android: $('#service_android')?.checked || false,
            ios:     $('#service_ios')?.checked || false,
            pentest: $('#service_pentest')?.checked || false,
        };

        // Toggle conditional sections
        toggleSection('website', state.services.web);
        toggleSection('android', state.services.android);
        toggleSection('ios', state.services.ios);
        toggleSection('pentest', state.services.pentest);

        return fd;
    };

    const onFormChange = debounce(() => {
        const fd = readFormState();
        renderSummary(fd);
        saveDraft();
    }, 150);

    // ──────────────────────────────────────────────────────────────
    //  LOCALSTORAGE DRAFT
    // ──────────────────────────────────────────────────────────────
    const serializeForm = () => {
        const form = $('#bv-sales-form');
        const data = {};
        for (const [key, value] of new FormData(form).entries()) {
            if (key === 'csrf_token') continue;
            if (key.endsWith('[]')) {
                data[key] = data[key] || [];
                data[key].push(value);
            } else {
                data[key] = value;
            }
        }
        return {
            data,
            agent: state.agent,
            paymentPlan: state.paymentPlan,
            finalPrice: state.finalPrice,
            overrideReason: state.overrideReason,
            savedAt: Date.now(),
        };
    };

    const saveDraft = () => {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(serializeForm()));
        } catch (e) {
            // Storage quota or disabled — silently ignore
        }
    };

    const loadDraft = () => {
        try {
            const raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return false;
            const parsed = JSON.parse(raw);
            if (!parsed?.data) return false;

            const form = $('#bv-sales-form');

            // Fields
            for (const [key, value] of Object.entries(parsed.data)) {
                if (key.endsWith('[]')) {
                    $$(`[name="${key}"]`).forEach((el) => {
                        el.checked = value.includes(el.value);
                    });
                } else {
                    const el = form.elements.namedItem(key);
                    if (!el) continue;
                    if (el.type === 'radio') {
                        $$(`[name="${key}"]`).forEach((r) => { r.checked = r.value === value; });
                    } else if (el.type === 'checkbox') {
                        el.checked = !!value;
                    } else {
                        el.value = value;
                    }
                }
            }

            if (parsed.agent) $('#agent_name').value = parsed.agent;
            if (parsed.paymentPlan) {
                state.paymentPlan = parsed.paymentPlan;
                const r = document.querySelector(`[name="payment_plan_radio"][value="${parsed.paymentPlan}"]`);
                if (r) r.checked = true;
            }
            if (typeof parsed.finalPrice === 'number') {
                state.finalPrice = parsed.finalPrice;
                state.overrideActive = true;
                const fp = $('#st-final-price');
                if (fp) { fp.value = parsed.finalPrice; fp.dataset.touched = '1'; }
                $('#st-override-row').hidden = false;
            }
            if (parsed.overrideReason) {
                state.overrideReason = parsed.overrideReason;
                const or = $('#st-override-reason');
                if (or) or.value = parsed.overrideReason;
            }

            return true;
        } catch (e) {
            console.warn('[BVSec:st] draft load failed:', e);
            return false;
        }
    };

    const clearDraft = () => {
        try { localStorage.removeItem(STORAGE_KEY); } catch {}
    };

    // ──────────────────────────────────────────────────────────────
    //  PRICE OVERRIDE
    // ──────────────────────────────────────────────────────────────
    const initPriceOverride = () => {
        const fp = $('#st-final-price');
        const reasonRow = $('#st-override-row');
        const reasonSel = $('#st-override-reason');

        if (!fp) return;

        fp.addEventListener('input', () => {
            fp.dataset.touched = '1';
            const val = parseFloat(fp.value) || 0;
            state.finalPrice = val;
            state.overrideActive = Math.abs(val - state.recommendedTotal) > 0.5;
            reasonRow.hidden = !state.overrideActive;
            $('#st-final-price-hidden').value = String(val);
            computeFirstPayment();
            saveDraft();
        });

        reasonSel?.addEventListener('change', () => {
            state.overrideReason = reasonSel.value;
            saveDraft();
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  PAYMENT PLAN SELECTION
    // ──────────────────────────────────────────────────────────────
    const initPaymentPlans = () => {
        $$('[name="payment_plan_radio"]').forEach((r) => {
            r.addEventListener('change', () => {
                if (!r.checked) return;
                state.paymentPlan = r.value;
                computeFirstPayment();
                saveDraft();
            });
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  PREVIEW EMAIL
    // ──────────────────────────────────────────────────────────────
    const buildPreviewHTML = (forClient = true) => {
        const form = $('#bv-sales-form');
        const fd = new FormData(form);

        const clientName = fd.get('client_name') || 'Client';
        const agentName  = $('#agent_name')?.selectedOptions[0]?.text || 'Agent';
        const finalPrice = state.finalPrice || state.recommendedTotal;
        const plan = PLANS[state.paymentPlan];

        // Services
        const servicesHtml = [];
        for (const [key, data] of Object.entries(state.recommendation)) {
            if (key === 'dualPlatformDiscount') continue;
            servicesHtml.push(`
                <div style="display:flex;justify-content:space-between;padding:10px 14px;background:#0d1117;border:1px solid #30363d;border-radius:6px;margin:6px 0;">
                    <div>
                        <div style="font-family:'Courier New',monospace;font-size:10px;color:#f0883e;letter-spacing:2px;text-transform:uppercase;">${key}</div>
                        <div style="color:#e6edf3;font-size:14px;font-weight:bold;margin-top:2px;">${data.package.label}</div>
                        <div style="color:#8b949e;font-size:11px;margin-top:2px;">${data.package.days} day delivery · ${data.package.tag}</div>
                    </div>
                    <div style="font-family:'Courier New',monospace;color:#f0883e;font-size:15px;font-weight:bold;align-self:center;">
                        ${formatMoney(data.package.base)}
                    </div>
                </div>`);
        }

        let discountRow = '';
        if (state.recommendation.dualPlatformDiscount) {
            discountRow = `
                <div style="display:flex;justify-content:space-between;padding:10px 14px;color:#3fb950;font-family:'Courier New',monospace;font-size:12px;">
                    <span>Dual-platform bundle discount (10%)</span>
                    <span>−${formatMoney(state.recommendation.dualPlatformDiscount)}</span>
                </div>`;
        }

        const firstPct = plan.split[0];
        const firstPayment = (finalPrice) * (firstPct / 100);

        if (forClient) {
            return `
                <div style="background:#0d1117;padding:24px;font-family:-apple-system,sans-serif;color:#e6edf3;">
                    <div style="max-width:600px;margin:0 auto;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">
                        <div style="padding:20px 24px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;">
                            <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;">BVSEC // PROPOSAL PREVIEW</div>
                            <div style="font-family:Georgia,serif;font-size:20px;font-weight:bold;margin-top:6px;">Hi ${clientName},</div>
                        </div>
                        <div style="padding:24px;">
                            <p style="color:#c9d1d9;font-size:14px;line-height:1.7;margin:0 0 16px;">
                                Thank you for your interest. Based on your requirements, here's our proposed engagement:
                            </p>
                            ${servicesHtml.join('')}
                            ${discountRow}
                            <div style="display:flex;justify-content:space-between;padding:16px 14px;margin-top:12px;border-top:2px solid #30363d;font-size:18px;">
                                <span style="font-family:Georgia,serif;font-weight:bold;">Total Investment</span>
                                <span style="font-family:'Courier New',monospace;color:#f0883e;font-weight:bold;">${formatMoney(finalPrice)}</span>
                            </div>
                            <div style="margin-top:20px;padding:14px;background:#0d1117;border:1px solid #30363d;border-left:3px solid #f0883e;border-radius:6px;">
                                <div style="font-family:'Courier New',monospace;font-size:10px;color:#8b949e;letter-spacing:2px;">PAYMENT PLAN</div>
                                <div style="color:#e6edf3;font-size:14px;margin-top:4px;">${plan.label}</div>
                                <div style="color:#f0883e;font-family:'Courier New',monospace;font-size:15px;margin-top:4px;">
                                    First installment: ${formatMoney(firstPayment)}
                                </div>
                            </div>
                            <p style="color:#8b949e;font-size:13px;line-height:1.6;margin-top:20px;">
                                This is a preview. The final quote email will include your reference code and next steps.
                            </p>
                        </div>
                    </div>
                </div>`;
        }

        // Admin view
        return `
            <div style="background:#0d1117;padding:24px;font-family:-apple-system,sans-serif;color:#e6edf3;">
                <div style="max-width:640px;margin:0 auto;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">
                    <div style="padding:20px 24px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;">
                        <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;">BVSEC // INTERNAL QUOTE RECORD</div>
                        <div style="font-family:Georgia,serif;font-size:18px;font-weight:bold;margin-top:6px;">Agent: ${agentName}</div>
                    </div>
                    <div style="padding:24px;">
                        <div style="font-family:'Courier New',monospace;font-size:12px;color:#8b949e;line-height:1.8;margin-bottom:16px;">
                            <div><strong style="color:#e6edf3;">Client:</strong> ${clientName}</div>
                            <div><strong style="color:#e6edf3;">Company:</strong> ${fd.get('client_company') || '—'}</div>
                            <div><strong style="color:#e6edf3;">Email:</strong> ${fd.get('client_email') || '—'}</div>
                            <div><strong style="color:#e6edf3;">Phone:</strong> ${fd.get('client_phone') || '—'}</div>
                        </div>
                        ${servicesHtml.join('')}
                        ${discountRow}
                        <div style="display:flex;justify-content:space-between;padding:16px 14px;margin-top:12px;border-top:2px solid #30363d;">
                            <span style="font-family:Georgia,serif;font-weight:bold;font-size:16px;">Final Price</span>
                            <span style="font-family:'Courier New',monospace;color:#f0883e;font-weight:bold;font-size:16px;">${formatMoney(finalPrice)}</span>
                        </div>
                        ${state.overrideActive ? `<div style="padding:10px 14px;background:#3d1a1a;border:1px solid #f85149;border-radius:6px;color:#f85149;font-size:12px;margin-top:12px;">⚠ Price overridden from ${formatMoney(state.recommendedTotal)} — Reason: ${state.overrideReason || 'unspecified'}</div>` : ''}
                    </div>
                </div>
            </div>`;
    };

    const initPreview = () => {
        const modal = $('#st-modal');
        const body = $('#st-modal-body');
        const recipient = $('#st-modal-recipient');

        $('#st-preview')?.addEventListener('click', () => {
            const email = $('#client_email')?.value || 'client@example.com';
            if (recipient) recipient.textContent = email;
            if (body) body.innerHTML = buildPreviewHTML(true);
            modal.hidden = false;
            requestAnimationFrame(() => modal.classList.add('is-open'));
        });

        $$('[data-st-modal-close]').forEach((el) => {
            el.addEventListener('click', () => {
                modal.classList.remove('is-open');
                setTimeout(() => { modal.hidden = true; }, 260);
            });
        });

        $$('.bv-st-modal__tab').forEach((tab) => {
            tab.addEventListener('click', () => {
                const which = tab.dataset.tab;
                $$('.bv-st-modal__tab').forEach((t) => {
                    t.classList.toggle('is-active', t === tab);
                    t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
                });
                body.innerHTML = buildPreviewHTML(which === 'client');
            });
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  SUBMIT
    // ──────────────────────────────────────────────────────────────
    const initSubmit = () => {
        const btn = $('#st-submit');

        btn?.addEventListener('click', async () => {
            const form = $('#bv-sales-form');
            const fd = new FormData(form);

            // Required-field check
            const required = ['client_name', 'client_email', 'client_phone'];
            const missing = required.filter((f) => !fd.get(f));
            if (missing.length) {
                alert('Please fill all required client fields before submitting.');
                const el = form.elements.namedItem(missing[0]);
                el?.focus();
                el?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            if (!state.agent) {
                alert('Please select the agent name at the top.');
                $('#agent_name')?.focus();
                return;
            }
            if (!Object.values(state.services).some(Boolean)) {
                alert('Please select at least one service.');
                return;
            }

            // Set hidden fields
            $('#st-final-price-hidden').value = String(state.finalPrice || state.recommendedTotal);
            $('#st-payment-plan-hidden').value = state.paymentPlan;

            const origHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i><span>Sending...</span>';

            try {
                const res = await fetch('/tools/sales-quote-handler.php', {
                    method: 'POST',
                    body: fd,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
                const json = await res.json().catch(() => null);

                if (res.ok && json?.success) {
                    showSuccess(json);
                    clearDraft();
                } else {
                    alert(json?.message || 'Submission failed. Please try again.');
                }
            } catch (err) {
                console.error('[BVSec:st] submit failed:', err);
                alert('Network error. Please try again.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHTML;
            }
        });
    };

    const showSuccess = (json) => {
        const overlay = $('#st-success');
        $('#st-success-ref').textContent = json.reference || '—';
        $('#st-success-client').textContent = json.client_email || '—';
        $('#st-success-price').textContent = formatMoney(state.finalPrice || state.recommendedTotal);
        overlay.hidden = false;
        requestAnimationFrame(() => overlay.classList.add('is-open'));

        const close = () => {
            overlay.classList.remove('is-open');
            setTimeout(() => { overlay.hidden = true; }, 300);
        };

        $('#st-success-close')?.addEventListener('click', close, { once: true });
        $('#st-success-new')?.addEventListener('click', () => {
            close();
            window.location.reload();
        }, { once: true });
    };

    // ──────────────────────────────────────────────────────────────
    //  UTILITY ACTIONS (save, print, reset)
    // ──────────────────────────────────────────────────────────────
    const initActions = () => {
        $('#st-save-draft')?.addEventListener('click', () => {
            saveDraft();
            const btn = $('#st-save-draft');
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i><span>Saved</span>';
            setTimeout(() => { btn.innerHTML = orig; }, 1200);
        });

        $('#st-print')?.addEventListener('click', () => {
            window.print();
        });

        $('#st-reset')?.addEventListener('click', () => {
            if (!confirm('Clear the entire form? This cannot be undone.')) return;
            clearDraft();
            window.location.reload();
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  BOOT
    // ──────────────────────────────────────────────────────────────
    const boot = () => {
        const form = $('#bv-sales-form');
        if (!form) return;

        initPriceOverride();
        initPaymentPlans();
        initPreview();
        initSubmit();
        initActions();

        // Restore prior draft
        const restored = loadDraft();

        // React to any form change
        form.addEventListener('input', onFormChange);
        form.addEventListener('change', onFormChange);
        $('#agent_name')?.addEventListener('change', onFormChange);

        // First render
        const fd = readFormState();
        renderSummary(fd);

        if (restored) {
            console.info('[BVSec:st] draft restored from localStorage');
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();