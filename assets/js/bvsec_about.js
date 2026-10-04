/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — About Page Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_about.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Timeline scroll-driven entrance animations
 *    - Read-time estimator (calculates from word count)
 *    - Rune tooltips on hover (accessible)
 *    - Copy-to-clipboard on manifesto signature
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    const prefersReducedMotion = () =>
        matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ──────────────────────────────────────────────────────────────
    //  1. TIMELINE ENTRANCE ANIMATIONS
    //     Each era slides in from its side when it enters the viewport.
    // ──────────────────────────────────────────────────────────────
    const initTimelineAnimations = () => {
        const eras = document.querySelectorAll('.bv-chronicle__era');
        if (!eras.length) return;

        if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
            eras.forEach((era) => era.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                });
            },
            { threshold: 0.15, rootMargin: '0px 0px -60px 0px' }
        );

        eras.forEach((era) => observer.observe(era));
    };

    // ──────────────────────────────────────────────────────────────
    //  2. RUNE TOOLTIPS
    //     Each rune-row is already a grid; we enhance with a
    //     screen-reader-friendly label and keyboard focus.
    // ──────────────────────────────────────────────────────────────
    const initRuneTooltips = () => {
        const rows = document.querySelectorAll('.bv-heritage__rune-row');
        rows.forEach((row) => {
            const runeEl = row.querySelector('.bv-heritage__rune-char');
            const nameEl = row.querySelector('.bv-heritage__rune-name');
            const meaningEl = row.querySelector('.bv-heritage__rune-meaning');
            if (!runeEl || !nameEl || !meaningEl) return;

            const label = `${nameEl.textContent}: ${meaningEl.textContent}`;
            runeEl.setAttribute('title', label);
            runeEl.setAttribute('aria-label', label);
            runeEl.setAttribute('role', 'img');
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  3. READ-TIME ESTIMATOR
    //     Counts words in the manifesto section, estimates reading
    //     time at 220 wpm, and injects it under the manifesto title.
    // ──────────────────────────────────────────────────────────────
    const initReadTime = () => {
        const manifesto = document.querySelector('.bv-manifesto__content');
        const title = document.querySelector('.bv-manifesto__title');
        if (!manifesto || !title) return;

        const text = manifesto.textContent || '';
        const words = text.trim().split(/\s+/).filter(Boolean).length;
        const minutes = Math.max(1, Math.round(words / 220));

        const meta = document.createElement('p');
        meta.className = 'bv-manifesto__read-time bv-font-mono';
        meta.style.cssText = `
            text-align: center;
            font-family: var(--bv-font-mono-primary);
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--bv-color-text-muted);
            margin-top: -1.5rem;
            margin-bottom: 2rem;
        `;
        meta.textContent = `${words} words · ${minutes} min read`;
        title.insertAdjacentElement('afterend', meta);
    };

    // ──────────────────────────────────────────────────────────────
    //  4. MANIFESTO SIGNATURE — copy to clipboard on Ctrl/Cmd+Click
    // ──────────────────────────────────────────────────────────────
    const initSignatureCopy = () => {
        const signature = document.querySelector('.bv-manifesto__signature');
        if (!signature) return;

        signature.style.cursor = 'pointer';
        signature.title = 'Ctrl/Cmd + Click to copy';

        signature.addEventListener('click', async (e) => {
            if (!(e.ctrlKey || e.metaKey)) return;
            e.preventDefault();

            const text = 'BeardedVikingTX · Texas · 2026';
            try {
                await navigator.clipboard.writeText(text);
                const original = signature.innerHTML;
                signature.innerHTML = '<span style="color: var(--bv-color-success);">✓ COPIED</span>';
                setTimeout(() => { signature.innerHTML = original; }, 1400);
            } catch (_) {
                // Clipboard unavailable — silent
            }
        });
    };

    // ──────────────────────────────────────────────────────────────
    //  BOOT
    // ──────────────────────────────────────────────────────────────
    const features = {
        timeline:   initTimelineAnimations,
        runeTips:   initRuneTooltips,
        readTime:   initReadTime,
        signature:  initSignatureCopy,
    };

    const boot = () => {
        for (const [name, init] of Object.entries(features)) {
            try { init(); }
            catch (err) { console.error(`[BVSec:about] "${name}" failed:`, err); }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();