/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Main Content Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_main.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  ARCHITECTURE:
 *    ┌─ Utils             → pure helpers (CSS var reader, rAF throttle)
 *    ├─ COLORS            → CSS custom props resolved once at boot
 *    ├─ ChartManager      → class-based, lazily loads Chart.js, handles
 *    │                      mount / resize / destroy with per-instance isolation
 *    ├─ ChartBuilders     → registered declaratively by canvas ID
 *    ├─ CounterAnimator   → hero metric counters, respects reduced motion
 *    └─ Feature registry  → add new features by registering them; boot runs
 *                           them all with try/catch isolation
 *
 *  DESIGN NOTES:
 *    - Zero global namespace pollution (single frozen window.BVSec for debug)
 *    - Per-feature error isolation — one failure never kills the rest
 *    - Chart.js loaded once, ever, with a proper Promise resolver
 *    - ResizeObserver re-fits charts on container resize
 *    - Reduced motion respected system-wide
 *    - Modern syntax: private class fields, optional chaining, ??, Intl, etc.
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    // ══════════════════════════════════════════════════════════════════════
    //  CONFIG — frozen, single source of truth
    // ══════════════════════════════════════════════════════════════════════
    const CONFIG = Object.freeze({
        chartJsCdn: 'https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js',
        chartObserver: {
            threshold: 0.1,
            rootMargin: '200px',
        },
        counter: {
            duration: 1600,
            threshold: 0.5,
        },
    });

    const MONO = "'JetBrains Mono', ui-monospace, monospace";

    // ══════════════════════════════════════════════════════════════════════
    //  UTILS
    // ══════════════════════════════════════════════════════════════════════
    const Utils = Object.freeze({
        /**
         * Read a CSS custom property value from :root.
         * @param {string} name
         * @param {string} [fallback='']
         * @returns {string}
         */
        cssVar(name, fallback = '') {
            const val = getComputedStyle(document.documentElement)
                .getPropertyValue(name)
                .trim();
            return val || fallback;
        },

        /** @returns {boolean} */
        prefersReducedMotion() {
            return matchMedia('(prefers-reduced-motion: reduce)').matches;
        },

        /**
         * Format an integer with locale-aware thousands separators.
         * @param {number} n
         * @returns {string}
         */
        formatNumber(n) {
            return new Intl.NumberFormat('en-US').format(n);
        },

        /**
         * Coalesce args into a requestAnimationFrame-throttled function.
         * @template {(...args: any[]) => void} F
         * @param {F} fn
         * @returns {F}
         */
        rafThrottle(fn) {
            let ticking = false;
            return /** @type {F} */ ((...args) => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(() => {
                    fn(...args);
                    ticking = false;
                });
            });
        },
    });

    // ══════════════════════════════════════════════════════════════════════
    //  COLORS — resolved from CSS custom properties at boot
    // ══════════════════════════════════════════════════════════════════════
    const COLORS = Object.freeze({
        accent:      Utils.cssVar('--bv-color-accent', '#58a6ff'),
        accentWarm:  Utils.cssVar('--bv-color-accent-warm', '#d29922'),
        success:     Utils.cssVar('--bv-color-success', '#3fb950'),
        danger:      Utils.cssVar('--bv-color-danger', '#f85149'),
        warning:     Utils.cssVar('--bv-color-warning', '#d29922'),
        textPrimary: Utils.cssVar('--bv-color-text-primary', '#e6edf3'),
        textMuted:   Utils.cssVar('--bv-color-text-muted', '#8b949e'),
        border:      Utils.cssVar('--bv-color-border', '#30363d'),
        bgElevated:  Utils.cssVar('--bv-color-bg-elevated', '#161b22'),
    });

    // ══════════════════════════════════════════════════════════════════════
    //  CHART MANAGER
    // ══════════════════════════════════════════════════════════════════════
    class ChartManager {
        /** @type {Map<string, () => object>} */
        #registry = new Map();

        /** @type {Map<string, Chart>} */
        #instances = new Map();

        /** @type {Promise<void> | null} */
        #loaderPromise = null;

        /** @type {IntersectionObserver | null} */
        #observer = null;

        /** @type {ResizeObserver | null} */
        #resizeObserver = null;

        constructor() {
            this.#initResizeObserver();
        }

        /**
         * Register a chart config builder for a given canvas ID.
         * The builder is called lazily the first time the canvas enters view.
         * @param {string} id - the canvas element's id
         * @param {() => object} builder - returns a Chart.js config object
         * @returns {this}
         */
        register(id, builder) {
            this.#registry.set(id, builder);
            return this;
        }

        /**
         * Observe every registered canvas. Charts mount lazily as they scroll
         * into view. Idempotent — safe to call more than once.
         * @returns {this}
         */
        observeAll() {
            if (!('IntersectionObserver' in window)) {
                this.#ensureChartJs().then(() => this.mountAll()).catch(() => {});
                return this;
            }

            this.#observer = new IntersectionObserver(
                (entries, obs) => {
                    for (const entry of entries) {
                        if (!entry.isIntersecting) continue;
                        const id = entry.target.id;
                        if (!this.#registry.has(id)) continue;

                        this.#ensureChartJs()
                            .then(() => this.mount(id))
                            .catch(() => {});

                        obs.unobserve(entry.target);
                    }
                },
                CONFIG.chartObserver
            );

            for (const id of this.#registry.keys()) {
                const el = document.getElementById(id);
                if (el) this.#observer.observe(el);
            }

            return this;
        }

        /**
         * Mount a single chart by id. No-op if already mounted or unknown.
         * @param {string} id
         * @returns {this}
         */
        mount(id) {
            if (this.#instances.has(id)) return this;

            const builder = this.#registry.get(id);
            if (!builder) return this;

            const canvas = document.getElementById(id);
            if (!(canvas instanceof HTMLCanvasElement)) return this;

            try {
                const config = builder();
                const instance = new Chart(canvas, config);
                this.#instances.set(id, instance);

                const observed = canvas.parentElement ?? canvas;
                this.#resizeObserver?.observe(observed);
            } catch (err) {
                console.error(`[BVSec:ChartManager] mount("${id}") failed:`, err);
            }

            return this;
        }

        /** Mount every registered chart immediately. @returns {this} */
        mountAll() {
            for (const id of this.#registry.keys()) this.mount(id);
            return this;
        }

        /** Destroy a single chart instance and free its memory. */
        destroy(id) {
            const inst = this.#instances.get(id);
            if (!inst) return;
            try { inst.destroy(); } catch {}
            this.#instances.delete(id);
        }

        /** Destroy every chart instance. */
        destroyAll() {
            for (const id of [...this.#instances.keys()]) this.destroy(id);
        }

        // ────────────────────────── private ──────────────────────────

        /**
         * Load Chart.js from CDN exactly once. Resolves when window.Chart
         * is available and global defaults have been applied.
         * @returns {Promise<void>}
         */
        #ensureChartJs() {
            if (window.Chart) return Promise.resolve();
            if (this.#loaderPromise) return this.#loaderPromise;

            this.#loaderPromise = new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = CONFIG.chartJsCdn;
                script.crossOrigin = 'anonymous';
                script.async = true;

                script.addEventListener(
                    'load',
                    () => {
                        this.#applyGlobalDefaults();
                        resolve();
                    },
                    { once: true }
                );

                script.addEventListener(
                    'error',
                    () => {
                        console.warn('[BVSec:ChartManager] Chart.js failed to load');
                        reject(new Error('Chart.js CDN load failed'));
                    },
                    { once: true }
                );

                document.head.appendChild(script);
            });

            return this.#loaderPromise;
        }

        #applyGlobalDefaults() {
            if (!window.Chart) return;
            const d = Chart.defaults;
            d.color = COLORS.textMuted;
            d.font = d.font ?? {};
            d.font.family = MONO;
            d.animation = Utils.prefersReducedMotion()
                ? false
                : { duration: 900, easing: 'easeOutQuart' };
        }

        #initResizeObserver() {
            if (!('ResizeObserver' in window)) return;

            this.#resizeObserver = new ResizeObserver(
                Utils.rafThrottle(() => {
                    for (const inst of this.#instances.values()) {
                        try { inst.resize(); } catch {}
                    }
                })
            );
        }
    }

    // ══════════════════════════════════════════════════════════════════════
    //  SHARED CHART STYLE
    // ══════════════════════════════════════════════════════════════════════
    const baseLegend = {
        labels: {
            color: COLORS.textMuted,
            font: { family: MONO, size: 11 },
            padding: 16,
            usePointStyle: true,
        },
    };

    const baseTooltip = {
        backgroundColor: 'rgba(13, 17, 23, 0.95)',
        titleColor: COLORS.textPrimary,
        bodyColor: COLORS.textMuted,
        borderColor: COLORS.border,
        borderWidth: 1,
        padding: 12,
        cornerRadius: 6,
        titleFont: { family: MONO, size: 12 },
        bodyFont: { family: MONO, size: 11 },
    };

    /**
     * Cartesian (x/y) scales with optional y-axis tick formatter.
     * @param {(v: number) => string} [yFormatter]
     */
    const cartesianScales = (yFormatter) => ({
        x: {
            ticks: { color: COLORS.textMuted, font: { family: MONO, size: 10 } },
            grid: { color: 'rgba(48, 54, 61, 0.4)' },
            border: { color: COLORS.border },
        },
        y: {
            beginAtZero: true,
            ticks: {
                color: COLORS.textMuted,
                font: { family: MONO, size: 10 },
                ...(yFormatter && { callback: yFormatter }),
            },
            grid: { color: 'rgba(48, 54, 61, 0.4)' },
            border: { color: COLORS.border },
        },
    });

    /**
     * Radar scales — uses suggestedMax (not stepSize/max) to let Chart.js
     * pick sensible tick steps on fractional data.
     * @param {(v: number) => string} [tickFormatter]
     * @param {number} [suggestedMax]
     */
    const radarScales = (tickFormatter, suggestedMax) => ({
        r: {
            angleLines: { color: 'rgba(48, 54, 61, 0.4)' },
            grid: { color: 'rgba(48, 54, 61, 0.4)' },
            pointLabels: {
                color: COLORS.textMuted,
                font: { family: MONO, size: 11 },
            },
            ticks: {
                color: COLORS.textMuted,
                backdropColor: 'transparent',
                font: { family: MONO, size: 9 },
                ...(tickFormatter && { callback: tickFormatter }),
            },
            beginAtZero: true,
            ...(suggestedMax && { suggestedMax }),
        },
    });

    // ══════════════════════════════════════════════════════════════════════
    //  CHART REGISTRATION
    // ══════════════════════════════════════════════════════════════════════
    const charts = new ChartManager();

    // ── 1. Cost Overrun: Traditional vs. BVSec ───────────────────────────
    charts.register('chart-cost-overrun', () => ({
        type: 'bar',
        data: {
            labels: ['Simple Web App', 'Mid-Complexity', 'SaaS Platform', 'Enterprise'],
            datasets: [
                {
                    label: 'Traditional Agency',
                    data: [28, 75, 145, 320],
                    backgroundColor: COLORS.danger + '80',
                    borderColor: COLORS.danger,
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'BVSec',
                    data: [18, 48, 95, 210],
                    backgroundColor: COLORS.success + '80',
                    borderColor: COLORS.success,
                    borderWidth: 1,
                    borderRadius: 4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: baseLegend,
                tooltip: {
                    ...baseTooltip,
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: $${ctx.parsed.y}K`,
                    },
                },
            },
            scales: cartesianScales((v) => `$${v}K`),
        },
    }));

    // ── 2. Timeline: Estimated vs. Traditional vs. BVSec ─────────────────
    charts.register('chart-timeline', () => ({
        type: 'line',
        data: {
            labels: ['Kickoff', 'Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Month 6'],
            datasets: [
                {
                    label: 'Estimated',
                    data: [0, 1, 2, 3, 4, 5, 6],
                    borderColor: COLORS.textMuted,
                    backgroundColor: COLORS.textMuted + '20',
                    borderDash: [6, 4],
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: COLORS.textMuted,
                    fill: false,
                    tension: 0,
                },
                {
                    label: 'Traditional Actual',
                    data: [0, 0.5, 1.8, 3.5, 5.5, 8, 10.5],
                    borderColor: COLORS.danger,
                    backgroundColor: COLORS.danger + '15',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: COLORS.danger,
                    fill: true,
                    tension: 0.3,
                },
                {
                    label: 'BVSec Actual',
                    data: [0, 0.8, 1.9, 3.1, 4.2, 5, 5.8],
                    borderColor: COLORS.success,
                    backgroundColor: COLORS.success + '15',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: COLORS.success,
                    fill: true,
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: baseLegend,
                tooltip: {
                    ...baseTooltip,
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.y} mo`,
                    },
                },
            },
            scales: cartesianScales((v) => `${v} mo`),
        },
    }));

    // ── 3. Savings Projection (Radar) ────────────────────────────────────
    charts.register('chart-savings', () => ({
        type: 'radar',
        data: {
            labels: ['Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5'],
            datasets: [
                {
                    label: 'With BVSec',
                    data: [1.5, 2.8, 4.1, 5.4, 6.7],
                    borderColor: COLORS.success,
                    backgroundColor: COLORS.success + '25',
                    borderWidth: 2.5,
                    pointBackgroundColor: COLORS.success,
                    pointRadius: 4,
                },
                {
                    label: 'Without BVSec',
                    data: [3.2, 6.8, 10.2, 13.5, 16.8],
                    borderColor: COLORS.danger,
                    backgroundColor: COLORS.danger + '20',
                    borderWidth: 2.5,
                    pointBackgroundColor: COLORS.danger,
                    pointRadius: 4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: baseLegend,
                tooltip: {
                    ...baseTooltip,
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: $${ctx.parsed.r}M`,
                    },
                },
            },
            scales: radarScales((v) => `$${v}M`, 18),
        },
    }));

    // ── 4. Efficiency Matrix (Radar) ─────────────────────────────────────
    charts.register('chart-efficiency', () => ({
        type: 'radar',
        data: {
            labels: [
                'On-Time Delivery',
                'Budget Accuracy',
                'Security Coverage',
                'Communication',
                'Post-Launch Support',
                'Code Quality',
            ],
            datasets: [
                {
                    label: 'BVSec',
                    data: [89, 92, 100, 96, 90, 94],
                    borderColor: COLORS.accent,
                    backgroundColor: COLORS.accent + '25',
                    borderWidth: 2.5,
                    pointBackgroundColor: COLORS.accent,
                    pointRadius: 4,
                },
                {
                    label: 'Industry Average',
                    data: [34, 55, 42, 60, 45, 58],
                    borderColor: COLORS.danger,
                    backgroundColor: COLORS.danger + '20',
                    borderWidth: 2.5,
                    pointBackgroundColor: COLORS.danger,
                    pointRadius: 4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: baseLegend,
                tooltip: {
                    ...baseTooltip,
                    callbacks: {
                        label: (ctx) => `${ctx.dataset.label}: ${ctx.parsed.r}%`,
                    },
                },
            },
            scales: radarScales((v) => `${v}%`, 100),
        },
    }));

    // ══════════════════════════════════════════════════════════════════════
    //  COUNTER ANIMATOR
    // ══════════════════════════════════════════════════════════════════════
    class CounterAnimator {
        /** @type {IntersectionObserver | null} */
        #observer = null;

        /** @returns {this} */
        start() {
            const counters = document.querySelectorAll('[data-counter]');
            if (!counters.length) return this;

            if (!('IntersectionObserver' in window)) {
                for (const el of counters) this.#animate(el);
                return this;
            }

            this.#observer = new IntersectionObserver(
                (entries, obs) => {
                    for (const entry of entries) {
                        if (!entry.isIntersecting) continue;
                        this.#animate(entry.target);
                        obs.unobserve(entry.target);
                    }
                },
                { threshold: CONFIG.counter.threshold }
            );

            for (const el of counters) this.#observer.observe(el);
            return this;
        }

        /** @param {Element} el */
        #animate(el) {
            const target = Number.parseInt(el.getAttribute('data-counter') ?? '', 10);
            if (!Number.isFinite(target)) return;

            if (Utils.prefersReducedMotion()) {
                el.textContent = Utils.formatNumber(target);
                return;
            }

            const duration = CONFIG.counter.duration;
            const startTime = performance.now();

            const tick = (now) => {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 4); // easeOutQuart
                el.textContent = Utils.formatNumber(Math.round(target * eased));
                if (progress < 1) requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);
        }
    }

    // ══════════════════════════════════════════════════════════════════════
    //  FEATURE REGISTRY
    //  Add new features here. Each runs in isolation; a throw in one does
    //  not prevent the others from booting.
    // ══════════════════════════════════════════════════════════════════════
    const features = {
        counters() {
            new CounterAnimator().start();
        },

        charts() {
            charts.observeAll();
        },

        // ── Future features go here, one method each ──
        // testimonials()  { ... }
        // scrollSpy()     { ... }
        // portfolio()     { ... }
    };

    // ══════════════════════════════════════════════════════════════════════
    //  BOOT
    // ══════════════════════════════════════════════════════════════════════
    const boot = () => {
        for (const [name, init] of Object.entries(features)) {
            try {
                init();
            } catch (err) {
                console.error(`[BVSec:boot] Feature "${name}" failed:`, err);
            }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

    // ══════════════════════════════════════════════════════════════════════
    //  DEBUG API — inspect from console, does not expose internals
    // ══════════════════════════════════════════════════════════════════════
    Object.defineProperty(window, 'BVSec', {
        value: Object.freeze({
            version: '1.0.0',
            colors: COLORS,
            utils: Utils,
            charts: Object.freeze({
                mount: (id) => charts.mount(id),
                destroy: (id) => charts.destroy(id),
                destroyAll: () => charts.destroyAll(),
            }),
        }),
        writable: false,
        configurable: false,
    });

})();