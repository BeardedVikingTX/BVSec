/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Services Hub Page Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_services.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Animated hero metric counters
 *    - FAQ accordion (single-open enforcement)
 *    - Deep-link to specific Q&A (via #qa-N)
 *    - Smooth scroll to sections from CTAs
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
        const counters = $$('.bv-sh-hero [data-counter]');
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
    //  2. Q&A ACCORDION — single-open + deep-link
    // ──────────────────────────────────────────────────────────────
    const initQa = () => {
        const items = $$('.bv-sh-qa__item');
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
            if (!hash || !hash.startsWith('qa-')) return;
            const idx = parseInt(hash.slice(3), 10);
            if (Number.isNaN(idx) || !items[idx]) return;
            items.forEach((it) => { it.open = false; });
            items[idx].open = true;
            setTimeout(() => {
                items[idx].scrollIntoView({
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                    block: 'center',
                });
            }, 100);
        };
        openFromHash();
        window.addEventListener('hashchange', openFromHash);
    };

    // ──────────────────────────────────────────────────────────────
    //  3. SMOOTH SCROLL — for internal CTA anchors
    //     (#services, #decision-qa, #payment-plans, etc.)
    // ──────────────────────────────────────────────────────────────
    const initSmoothScroll = () => {
        const anchors = $$('a[href^="#"]');
        anchors.forEach((a) => {
            a.addEventListener('click', (e) => {
                const target = a.getAttribute('href');
                if (!target || target === '#') return;
                const el = document.querySelector(target);
                if (!el) return;
                e.preventDefault();
                el.scrollIntoView({
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                    block: 'start',
                });
                history.replaceState(null, '', target);
            });
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  BOOT
    // ──────────────────────────────────────────────────────────────
    const features = {
        counters:     initCounters,
        qa:           initQa,
        smoothScroll: initSmoothScroll,
    };

    const boot = () => {
        for (const [name, init] of Object.entries(features)) {
            try { init(); }
            catch (err) { console.error(`[BVSec:services] "${name}" failed:`, err); }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();