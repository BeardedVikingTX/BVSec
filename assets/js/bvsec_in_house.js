/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — In-House Projects Page Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_in_house.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Animated hero metric counters
 *    - Deep-link scroll to project anchors (#project-mycitadel, etc.)
 *    - Copy GitHub URL helper on modifier-click
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
        const counters = $$('.bv-ih-hero [data-counter]');
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
    //  2. DEEP-LINK SCROLL — anchor jump to project cards
    // ──────────────────────────────────────────────────────────────
    const initProjectAnchors = () => {
        const openFromHash = () => {
            const hash = location.hash.replace(/^#/, '');
            if (!hash.startsWith('project-')) return;
            const target = document.getElementById(hash);
            if (!target) return;
            setTimeout(() => {
                target.scrollIntoView({
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                    block: 'start',
                });
            }, 100);
        };
        openFromHash();
        window.addEventListener('hashchange', openFromHash);
    };

    // ──────────────────────────────────────────────────────────────
    //  3. GITHUB URL COPY on Ctrl/Cmd+Click
    //     Bonus: lets visitors grab repo URLs without leaving the page.
    // ──────────────────────────────────────────────────────────────
    const initGithubCopy = () => {
        const links = $$('.bv-ih-component__link[href*="github.com"], .bv-ih-project__github-link[href*="github.com"]');

        links.forEach((link) => {
            link.addEventListener('click', async (e) => {
                if (!(e.ctrlKey || e.metaKey)) return;
                e.preventDefault();

                const url = link.href;
                try {
                    await navigator.clipboard.writeText(url);
                    const original = link.innerHTML;
                    link.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i><span>Copied</span>';
                    setTimeout(() => { link.innerHTML = original; }, 1400);
                } catch (_) {
                    // Clipboard blocked — silently fail
                }
            });
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  BOOT
    // ──────────────────────────────────────────────────────────────
    const features = {
        counters:       initCounters,
        projectAnchors: initProjectAnchors,
        githubCopy:     initGithubCopy,
    };

    const boot = () => {
        for (const [name, init] of Object.entries(features)) {
            try { init(); }
            catch (err) { console.error(`[BVSec:inHouse] "${name}" failed:`, err); }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();