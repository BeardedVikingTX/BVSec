/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Footer Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_footer.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Back-to-top FAB visibility + smooth scroll
 *    - Terminal line-by-line reveal on intersection
 *    - Live UTC clock refresh (footer instance)
 *    - Optional server-stat poller (hits /api/server-stats.php if present)
 *    - Copy-to-clipboard for legal links (paste raw URL on modifier click)
 * ═══════════════════════════════════════════════════════════════════════════
 */

(function () {
    'use strict';

    // ──────────────────────────────────────────────────────────────
    //  1. BACK TO TOP
    // ──────────────────────────────────────────────────────────────
    const backToTop = document.querySelector('[data-back-to-top]');
    const prefersReducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (backToTop) {
        let ticking = false;

        const updateBackToTop = () => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                const scrolled = window.scrollY > 400;
                backToTop.classList.toggle('is-visible', scrolled);
                ticking = false;
            });
        };

        window.addEventListener('scroll', updateBackToTop, { passive: true });
        updateBackToTop();

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: prefersReducedMotion ? 'auto' : 'smooth',
            });
        });
    }

    // ──────────────────────────────────────────────────────────────
    //  2. TERMINAL — line-by-line reveal on intersection
    // ──────────────────────────────────────────────────────────────
    const terminal = document.querySelector('[data-terminal]');

    if (terminal) {
        const lines = terminal.querySelectorAll('.bv-footer__terminal-line');

        // Pre-stage each line with its delay, but don't fire yet.
        lines.forEach((line, i) => {
            line.style.setProperty('--bv-line-delay', String(i * 90));
            line.setAttribute('data-armed', '');
        });

        const startTerminal = () => {
            terminal.classList.add('is-live');
            lines.forEach((line) => line.removeAttribute('data-armed'));
        };

        // Intersection observer — fire once when 25% visible.
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Small delay so the reveal feels intentional.
                            setTimeout(startTerminal, 250);
                            observer.disconnect();
                        }
                    });
                },
                { threshold: 0.25 }
            );
            io.observe(terminal);
        } else {
            // No IO support — just reveal immediately.
            startTerminal();
        }
    }

    // ──────────────────────────────────────────────────────────────
    //  3. LIVE UTC CLOCK (footer instance)
    // ──────────────────────────────────────────────────────────────
    const utcTimeEls = document.querySelectorAll('[data-bv-utc-time]');
    const utcDateEls = document.querySelectorAll('[data-bv-utc-date]');

    if (utcTimeEls.length || utcDateEls.length) {
        const pad = (n) => String(n).padStart(2, '0');

        const tick = () => {
            const now = new Date();
            const time = `${pad(now.getUTCHours())}:${pad(now.getUTCMinutes())}:${pad(now.getUTCSeconds())}`;
            const date = `${now.getUTCFullYear()}-${pad(now.getUTCMonth() + 1)}-${pad(now.getUTCDate())}`;
            utcTimeEls.forEach((el) => { el.textContent = time; });
            utcDateEls.forEach((el) => { el.textContent = date; });
        };

        tick();
        setInterval(tick, 1000);
    }

    // ──────────────────────────────────────────────────────────────
    //  4. OPTIONAL — Server stats poller
    //     If /api/server-stats.php exists and returns JSON, refresh
    //     the vault every 30s. Silent failure if it doesn't exist.
    // ──────────────────────────────────────────────────────────────
    const vault = document.querySelector('.bv-footer__col--vault');

    if (vault && window.fetch) {
        const STATS_ENDPOINT = '/api/server-stats.php';
        const POLL_INTERVAL  = 30000; // 30s

        const updateStat = (selector, value) => {
            const el = vault.querySelector(selector);
            if (el && value !== undefined && value !== null) {
                el.textContent = String(value);
            }
        };

        const updateGauge = (selector, percent) => {
            const bar = vault.querySelector(selector + ' .bv-footer__gauge-bar');
            if (bar && typeof percent === 'number') {
                bar.style.setProperty('--bv-fill', `${percent}%`);
            }
        };

        const pollStats = async () => {
            try {
                const res = await fetch(STATS_ENDPOINT, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: { 'Accept': 'application/json' },
                });
                if (!res.ok) return;
                const data = await res.json();

                if (data.load_1 != null)  updateStat('[data-stat-load-1]', data.load_1);
                if (data.load_pct != null) updateGauge('[data-stat-load-gauge]', data.load_pct);
                if (data.disk_pct != null) updateGauge('[data-stat-disk-gauge]', data.disk_pct);
                if (data.disk_free_h)     updateStat('[data-stat-disk-free]', data.disk_free_h);
                if (data.response_ms != null) updateStat('[data-stat-response]', `${data.response_ms} ms`);
            } catch (_) {
                // Silent — endpoint may not be deployed yet.
            }
        };

        // Kick off after 5s so it doesn't compete with page load.
        setTimeout(pollStats, 5000);
        setInterval(pollStats, POLL_INTERVAL);
    }

    // ──────────────────────────────────────────────────────────────
    //  5. LEGAL LINKS — copy URL on modifier-click (Ctrl/Cmd+Click)
    // ──────────────────────────────────────────────────────────────
    document.querySelectorAll('.bv-footer__legal-link').forEach((link) => {
        link.addEventListener('click', (e) => {
            if (!(e.ctrlKey || e.metaKey)) return;
            e.preventDefault();
            const url = new URL(link.getAttribute('href'), window.location.origin).href;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(() => {
                    const original = link.innerHTML;
                    link.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i> COPIED';
                    setTimeout(() => { link.innerHTML = original; }, 1200);
                }).catch(() => {});
            }
        });
    });

})();