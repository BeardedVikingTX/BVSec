/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Contact Page Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_contact.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Client-side validation with inline errors
 *    - JS-enabled token (proves form was filled by a real browser)
 *    - Live character counter for textarea
 *    - AJAX submission with JSON response handling
 *    - Success overlay with reference code
 *    - Anti-double-submit protection
 *    - CSRF token auto-rotation on failed submission
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    const $  = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    // ══════════════════════════════════════════════════════════════
    //  CONFIG
    // ══════════════════════════════════════════════════════════════
    const CONFIG = Object.freeze({
        endpoint: '/api/contact.php',
        minSubmitDelay: 3000,        // must wait 3s after page load
        maxSubmitDelay: 7200000,     // and no longer than 2 hours
        textareaMinChars: 40,
        textareaMaxChars: 5000,
    });

    // ══════════════════════════════════════════════════════════════
    //  UTILS
    // ══════════════════════════════════════════════════════════════
    const setFieldError = (name, message) => {
        const errEl = document.querySelector(`.bv-ct-error[data-for="${name}"]`);
        if (errEl) errEl.textContent = message || '';

        // Mark every input with this name as invalid / valid
        const inputs = $$(`[name="${name}"], [name="${name}[]"]`);
        inputs.forEach((input) => {
            if (message) input.setAttribute('aria-invalid', 'true');
            else         input.removeAttribute('aria-invalid');
        });
    };

    const clearAllErrors = () => {
        $$('.bv-ct-error').forEach((el) => { el.textContent = ''; });
        $$('[aria-invalid]').forEach((el) => { el.removeAttribute('aria-invalid'); });
    };

    const showAlert = (kind, message) => {
        const alertEl = $('#bv-ct-alert');
        if (!alertEl) return;
        const iconMap = {
            error:   'fa-solid fa-triangle-exclamation',
            success: 'fa-solid fa-circle-check',
            warn:    'fa-solid fa-circle-info',
        };
        alertEl.className = `bv-ct-alert bv-ct-alert--${kind}`;
        alertEl.innerHTML = `<i class="${iconMap[kind] || iconMap.error}" aria-hidden="true"></i><div>${message}</div>`;
        alertEl.hidden = false;
        alertEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    const hideAlert = () => {
        const alertEl = $('#bv-ct-alert');
        if (alertEl) alertEl.hidden = true;
    };

    // ══════════════════════════════════════════════════════════════
    //  1. JS-ENABLED TOKEN
    //     Sets a hidden field to "1" only if JS actually runs.
    //     Backend rejects submissions without this set.
    // ══════════════════════════════════════════════════════════════
    const initJsToken = () => {
        const el = $('#js-enabled');
        if (el) el.value = '1';
    };

    // ══════════════════════════════════════════════════════════════
    //  2. TEXTAREA CHARACTER COUNTER
    // ══════════════════════════════════════════════════════════════
    const initCharCounter = () => {
        const textarea = $('#project_description');
        const counter = $('.bv-ct-charcount[data-for="project_description"]');
        if (!textarea || !counter) return;

        const update = () => {
            const len = textarea.value.length;
            counter.textContent = `${len} / ${CONFIG.textareaMaxChars}`;
            counter.classList.toggle('is-over', len > CONFIG.textareaMaxChars);
        };
        textarea.addEventListener('input', update);
        update();
    };

    // ══════════════════════════════════════════════════════════════
    //  3. DATE SANITY — reject past dates gracefully
    // ══════════════════════════════════════════════════════════════
    const initDateSanity = () => {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        $$('input[type="date"]').forEach((input) => {
            input.addEventListener('change', () => {
                if (!input.value) return;
                const selected = new Date(input.value + 'T00:00:00');
                if (selected < today) {
                    setFieldError(input.name, 'Please select a date in the future.');
                } else {
                    setFieldError(input.name, '');
                }
            });
        });
    };

    // ══════════════════════════════════════════════════════════════
    //  4. CLIENT-SIDE VALIDATION
    // ══════════════════════════════════════════════════════════════
    const validateForm = (form) => {
        clearAllErrors();
        const errors = [];

        const data = new FormData(form);
        const val = (key) => (data.get(key) ?? '').toString().trim();

        // ── Identity ──
        if (val('full_name').length < 2) {
            errors.push(['full_name', 'Please enter your full name (2+ characters).']);
        }

        const email = val('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
        if (!email) {
            errors.push(['email', 'Email is required.']);
        } else if (!emailRegex.test(email)) {
            errors.push(['email', 'That email address doesn\'t look right.']);
        } else if (email.length > 254) {
            errors.push(['email', 'Email address is too long.']);
        }

        const phone = val('phone').replace(/[^\d+]/g, '');
        if (phone.length < 7) {
            errors.push(['phone', 'Please enter a valid phone number.']);
        }

        // ── Services ──
        const services = data.getAll('services[]');
        if (!services.length) {
            errors.push(['services', 'Select at least one service.']);
        }

        // ── Description ──
        const desc = val('project_description');
        if (desc.length < CONFIG.textareaMinChars) {
            errors.push([
                'project_description',
                `Please write at least ${CONFIG.textareaMinChars} characters.`,
            ]);
        } else if (desc.length > CONFIG.textareaMaxChars) {
            errors.push(['project_description', 'Description is too long.']);
        }

        // ── Call slot 1 ──
        if (!val('call_date_1')) {
            errors.push(['call_date_1', 'Please pick a date for the first call slot.']);
        }
        if (!val('call_time_1')) {
            errors.push(['call_time_1', 'Please pick a time for the first call slot.']);
        }

        // ── Consent ──
        if (!data.get('consent')) {
            errors.push(['consent', 'You must agree before submitting.']);
        }

        // ── Honeypot sanity (browser shouldn't fill these) ──
        if (val('website_url') || val('email_confirm')) {
            // Silently fail — don't tell the bot what tripped it.
            return { errors: [['full_name', 'Submission rejected.']], silent: true };
        }

        // Apply errors
        errors.forEach(([field, msg]) => setFieldError(field, msg));

        return { errors, valid: errors.length === 0 };
    };

    // ══════════════════════════════════════════════════════════════
    //  5. AJAX SUBMIT
    // ══════════════════════════════════════════════════════════════
    const initSubmit = (form) => {
        const submitBtn = $('#bv-ct-submit');
        const idleLabel = submitBtn?.querySelector('.bv-ct-submit__idle');
        const loadLabel = submitBtn?.querySelector('.bv-ct-submit__loading');

        const loadedAt = parseInt(form.dataset.loadedAt ?? '0', 10) ||
                         parseInt($('input[name="form_loaded_at"]')?.value ?? '0', 10);

        const setLoading = (loading) => {
            if (!submitBtn) return;
            submitBtn.disabled = loading;
            if (idleLabel) idleLabel.hidden = loading;
            if (loadLabel) loadLabel.hidden = !loading;
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlert();

            // ── Time gate ──
            const elapsed = Date.now() - loadedAt * 1000;
            if (elapsed < CONFIG.minSubmitDelay) {
                showAlert('error', 'The form was submitted too quickly. Please review your entries and try again.');
                return;
            }
            if (elapsed > CONFIG.maxSubmitDelay) {
                showAlert('warn', 'This form has been open too long. Please reload the page and try again.');
                return;
            }

            // ── Client-side validation ──
            const result = validateForm(form);
            if (!result.valid) {
                if (!result.silent) {
                    showAlert('error', 'Please fix the highlighted fields and try again.');
                }
                // Focus the first invalid field
                const firstInvalid = $('[aria-invalid="true"]');
                if (firstInvalid) firstInvalid.focus();
                return;
            }

            // ── Submit ──
            setLoading(true);
            try {
                const fd = new FormData(form);
                const res = await fetch(CONFIG.endpoint, {
                    method: 'POST',
                    body: fd,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });

                const json = await res.json().catch(() => null);

                if (!res.ok || !json) {
                    showAlert('error', 'Something went wrong on our end. Please email info@beardedviking.org directly.');
                    return;
                }

                if (json.success) {
                    // Show success overlay
                    showSuccessOverlay(json.reference || '—');
                    form.reset();
                    // Reset character counter
                    const counter = $('.bv-ct-charcount[data-for="project_description"]');
                    if (counter) counter.textContent = `0 / ${CONFIG.textareaMaxChars}`;
                } else if (json.errors && typeof json.errors === 'object') {
                    // Field-specific errors from server
                    Object.entries(json.errors).forEach(([field, msg]) => {
                        setFieldError(field, String(msg));
                    });
                    showAlert('error', json.message || 'Please review the highlighted fields.');
                } else {
                    showAlert('error', json.message || 'Submission failed. Please try again or email us directly.');
                }
            } catch (err) {
                console.error('[BVSec:contact] submit failed:', err);
                showAlert('error', 'Network error. Please check your connection or email info@beardedviking.org directly.');
            } finally {
                setLoading(false);
            }
        });
    };

    // ══════════════════════════════════════════════════════════════
    //  6. SUCCESS OVERLAY
    // ══════════════════════════════════════════════════════════════
    const showSuccessOverlay = (refCode) => {
        const overlay = $('#bv-ct-success');
        const refEl = $('#ct-success-ref');
        const closeBtn = $('#ct-success-close');
        if (!overlay) return;

        if (refEl) refEl.textContent = refCode;
        overlay.hidden = false;
        requestAnimationFrame(() => overlay.classList.add('is-open'));
        document.body.style.overflow = 'hidden';
        closeBtn?.focus();

        const close = () => {
            overlay.classList.remove('is-open');
            setTimeout(() => {
                overlay.hidden = true;
                document.body.style.overflow = '';
            }, 320);
        };

        closeBtn?.addEventListener('click', close, { once: true });
        overlay.querySelector('.bv-ct-success__backdrop')?.addEventListener('click', close, { once: true });
        document.addEventListener('keydown', function escHandler(e) {
            if (e.key === 'Escape') {
                close();
                document.removeEventListener('keydown', escHandler);
            }
        });
    };

    // ══════════════════════════════════════════════════════════════
    //  7. LIVE ERROR CLEARING
    //     When the user fixes a field, remove its error message.
    // ══════════════════════════════════════════════════════════════
    const initLiveValidation = () => {
        $$('.bv-ct-input, .bv-ct-textarea, .bv-ct-select').forEach((input) => {
            input.addEventListener('input', () => {
                if (input.getAttribute('aria-invalid') === 'true') {
                    setFieldError(input.name, '');
                }
            });
            input.addEventListener('change', () => {
                if (input.getAttribute('aria-invalid') === 'true') {
                    setFieldError(input.name, '');
                }
            });
        });
    };

    // ══════════════════════════════════════════════════════════════
    //  BOOT
    // ══════════════════════════════════════════════════════════════
    const boot = () => {
        const form = $('#bv-contact-form');
        if (!form) return;

        // Ensure the form records its own load time for the time gate.
        form.dataset.loadedAt = $('input[name="form_loaded_at"]')?.value ?? String(Math.floor(Date.now() / 1000));

        const features = {
            jsToken:        initJsToken,
            charCounter:    initCharCounter,
            dateSanity:     initDateSanity,
            liveValidation: initLiveValidation,
            submit:         () => initSubmit(form),
        };

        for (const [name, init] of Object.entries(features)) {
            try { init(); }
            catch (err) { console.error(`[BVSec:contact] "${name}" failed:`, err); }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();