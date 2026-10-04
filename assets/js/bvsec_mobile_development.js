/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Mobile Development Page Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_mobile_development.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Animated hero metric counters
 *    - FAQ accordion (single-open enforcement)
 *    - Deep-link to specific FAQ (via #faq-N)
 *    - Scroll-spy for process phases
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
    const prefersReducedMotion = () =>
        matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ──────────────────────────────────────────────────────────────
    //  1. HERO METRIC COUNTERS
    // ──────────────────────────────────────────────────────────────
    const initCounters = () => {
        const counters = $$('.bv-md-hero [data-counter]');
        if (!counters.length) return;

        const animate = (el) => {
            const target = parseInt(el.dataset.counter, 10) || 0;
            if (prefersReducedMotion()) {
                el.textContent = String(target);
                return;
            }
            const duration = 1500;
            const start = performance.now();

            const tick = (now) => {
                const t = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - t, 4);
                el.textContent = String(Math.round(target * eased));
                if (t < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        };

        if (!('IntersectionObserver' in window)) {
            counters.forEach(animate);
            return;
        }

        const io = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    animate(entry.target);
                    obs.unobserve(entry.target);
                });
            },
            { threshold: 0.5 }
        );

        counters.forEach((c) => io.observe(c));
    };

    // ──────────────────────────────────────────────────────────────
    //  2. FAQ ACCORDION
    // ──────────────────────────────────────────────────────────────
    const initFaq = () => {
        const items = $$('.bv-md-faq__item');
        if (!items.length) return;

        items.forEach((item) => {
            item.addEventListener('toggle', () => {
                if (!item.open) return;
                items.forEach((other) => {
                    if (other !== item && other.open) {
                        other.open = false;
                    }
                });
            });
        });

        const openFromHash = () => {
            const hash = location.hash.replace(/^#/, '');
            if (!hash || !hash.startsWith('faq-')) return;
            const idx = parseInt(hash.slice(4), 10);
            if (Number.isNaN(idx) || !items[idx]) return;
            items.forEach((it) => { it.open = false; });
            items[idx].open = true;
            setTimeout(() => {
                items[idx].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        };
        openFromHash();
        window.addEventListener('hashchange', openFromHash);
    };

    // ──────────────────────────────────────────────────────────────
    //  3. SCROLL-SPY — highlight active process phase
    // ──────────────────────────────────────────────────────────────
    const initScrollSpy = () => {
        const phases = $$('.bv-md-process__phase');
        if (!phases.length || !('IntersectionObserver' in window)) return;

        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    entry.target.classList.toggle('is-active', entry.isIntersecting);
                });
            },
            {
                threshold: 0.4,
                rootMargin: '-20% 0px -20% 0px',
            }
        );

        phases.forEach((p) => io.observe(p));
    };

    // ──────────────────────────────────────────────────────────────
    //  4. ENGAGEMENT CTA — let browser follow the query string
    //     (No analytics shipped. Hook for future extensibility.)
    // ──────────────────────────────────────────────────────────────
    const initEngagementTracking = () => {
        const links = $$('.bv-md-engagement__cta');
        links.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  BOOT
    // ──────────────────────────────────────────────────────────────
    const features = {
        counters:  initCounters,
        faq:       initFaq,
        scrollSpy: initScrollSpy,
        engagementTracking: initEngagementTracking,
    };

    const boot = () => {
        for (const [name, init] of Object.entries(features)) {
            try { init(); }
            catch (err) { console.error(`[BVSec:mobileDev] "${name}" failed:`, err); }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();