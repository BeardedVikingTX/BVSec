/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Navigation Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_nav.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Desktop dropdown open/close (click + hover + keyboard)
 *    - Mobile overlay open/close with focus trap
 *    - Mobile accordion submenus
 *    - Live UTC clock (updates every second)
 *    - Scroll progress bar
 *    - Nav scrolled state (denser background after scrolling)
 *    - Escape-to-close, click-outside-to-close
 *    - Auto-close mobile menu on link click
 *    - Responsive: re-syncs state on viewport change
 *    - ARIA-correct throughout
 * ═══════════════════════════════════════════════════════════════════════════
 */

(function () {
    'use strict';

    // ──────────────────────────────────────────────────────────────
    //  DOM refs
    // ──────────────────────────────────────────────────────────────
    const nav           = document.getElementById('bv-nav');
    if (!nav) return;

    const toggleBtn     = document.getElementById('bv-nav-toggle');
    const overlay       = document.getElementById('bv-nav-overlay');
    const overlayClose  = document.getElementById('bv-nav-overlay-close');
    const progressBar   = document.getElementById('bv-nav-progress');
    const clockEls      = [
        document.getElementById('bv-nav-clock'),
        document.getElementById('bv-nav-clock-mobile'),
    ].filter(Boolean);

    const desktopDropdownItems = nav.querySelectorAll('.bv-nav__item--has-dropdown');
    const overlayToggleLinks   = nav.querySelectorAll('.bv-nav__overlay-link--toggle');

    // ──────────────────────────────────────────────────────────────
    //  State
    // ──────────────────────────────────────────────────────────────
    const isDesktop = () => window.matchMedia('(min-width: 1025px)').matches;
    let   focusableBeforeOpen = null;

    // ──────────────────────────────────────────────────────────────
    //  UTC Clock
    // ──────────────────────────────────────────────────────────────
    function updateClock() {
        const now = new Date();
        const hh  = String(now.getUTCHours()).padStart(2, '0');
        const mm  = String(now.getUTCMinutes()).padStart(2, '0');
        const ss  = String(now.getUTCSeconds()).padStart(2, '0');
        const t   = `${hh}:${mm}:${ss}`;
        clockEls.forEach(el => { el.textContent = t; });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ──────────────────────────────────────────────────────────────
    //  Scroll progress + scrolled state
    // ──────────────────────────────────────────────────────────────
    let ticking = false;

    function onScroll() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
            const pct       = maxScroll > 0 ? (scrollTop / maxScroll) * 100 : 0;

            if (progressBar) {
                progressBar.style.width = pct.toFixed(2) + '%';
            }
            nav.classList.toggle('is-scrolled', scrollTop > 8);
            ticking = false;
        });
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ──────────────────────────────────────────────────────────────
    //  Desktop dropdowns
    // ──────────────────────────────────────────────────────────────
    function closeAllDropdowns(except = null) {
        desktopDropdownItems.forEach(item => {
            if (item === except) return;
            item.classList.remove('is-open');
            const trigger = item.querySelector('.bv-nav__link--toggle');
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
        });
    }

    desktopDropdownItems.forEach(item => {
        const trigger = item.querySelector('.bv-nav__link--toggle');
        if (!trigger) return;

        // Click toggle
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const willOpen = !item.classList.contains('is-open');
            closeAllDropdowns(item);
            item.classList.toggle('is-open', willOpen);
            trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });

        // Hover (desktop only)
        let hoverTimer;
        item.addEventListener('mouseenter', () => {
            if (!isDesktop()) return;
            clearTimeout(hoverTimer);
            closeAllDropdowns(item);
            item.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
        });
        item.addEventListener('mouseleave', () => {
            if (!isDesktop()) return;
            hoverTimer = setTimeout(() => {
                item.classList.remove('is-open');
                trigger.setAttribute('aria-expanded', 'false');
            }, 180);
        });

        // Keyboard navigation within dropdown
        item.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                item.classList.remove('is-open');
                trigger.setAttribute('aria-expanded', 'false');
                trigger.focus();
            }
        });
    });

    // Click outside closes desktop dropdowns
    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target)) {
            closeAllDropdowns();
        }
    });

    // ──────────────────────────────────────────────────────────────
    //  Mobile overlay
    // ──────────────────────────────────────────────────────────────
    function getFocusable() {
        if (!overlay) return [];
        return Array.from(
            overlay.querySelectorAll(
                'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
            )
        ).filter(el => el.offsetParent !== null);
    }

    function openOverlay() {
        if (!overlay || !toggleBtn) return;

        focusableBeforeOpen = document.activeElement;

        overlay.hidden = false;
        // Next frame so the transition runs
        requestAnimationFrame(() => {
            overlay.classList.add('is-open');
        });

        toggleBtn.setAttribute('aria-expanded', 'true');
        toggleBtn.setAttribute('aria-label', 'Close menu');
        document.body.style.overflow = 'hidden';

        // Focus first focusable inside overlay
        const focusables = getFocusable();
        if (focusables.length) {
            // Delay focus until after transition starts
            setTimeout(() => focusables[0].focus(), 60);
        }
    }

    function closeOverlay() {
        if (!overlay || !toggleBtn) return;

        overlay.classList.remove('is-open');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.setAttribute('aria-label', 'Open menu');
        document.body.style.overflow = '';

        // Hide after transition ends
        const onTransitionEnd = () => {
            overlay.hidden = true;
            overlay.removeEventListener('transitionend', onTransitionEnd);
        };
        overlay.addEventListener('transitionend', onTransitionEnd);

        // Fallback if transitionend doesn't fire
        setTimeout(() => { if (!overlay.classList.contains('is-open')) overlay.hidden = true; }, 400);

        // Restore focus
        if (focusableBeforeOpen && typeof focusableBeforeOpen.focus === 'function') {
            focusableBeforeOpen.focus();
        }
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';
            isOpen ? closeOverlay() : openOverlay();
        });
    }
    if (overlayClose) {
        overlayClose.addEventListener('click', closeOverlay);
    }

    // Escape key closes overlay
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay && overlay.classList.contains('is-open')) {
            closeOverlay();
        }
    });

    // Focus trap inside overlay
    document.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;
        if (!overlay || !overlay.classList.contains('is-open')) return;

        const focusables = getFocusable();
        if (!focusables.length) return;

        const first = focusables[0];
        const last  = focusables[focusables.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    });

    // Auto-close overlay when navigating to a new page (link click)
    if (overlay) {
        overlay.addEventListener('click', (e) => {
            const link = e.target.closest('a[href]');
            if (!link) return;
            // Don't close for accordion toggles
            if (link.classList.contains('bv-nav__overlay-link--toggle')) return;
            // Don't close for same-page hash links within overlay
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || link.target === '_blank') return;
            closeOverlay();
        });
    }

    // ──────────────────────────────────────────────────────────────
    //  Mobile accordion submenus
    // ──────────────────────────────────────────────────────────────
    overlayToggleLinks.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = btn.getAttribute('aria-controls');
            if (!targetId) return;
            const target = document.getElementById(targetId);
            if (!target) return;

            const isOpen = btn.getAttribute('aria-expanded') === 'true';

            // Close siblings
            overlayToggleLinks.forEach(other => {
                if (other === btn) return;
                other.setAttribute('aria-expanded', 'false');
                const otherId = other.getAttribute('aria-controls');
                const otherPanel = otherId ? document.getElementById(otherId) : null;
                if (otherPanel) otherPanel.hidden = true;
            });

            // Toggle this one
            btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
            target.hidden = isOpen;
        });
    });

    // ──────────────────────────────────────────────────────────────
    //  Responsive re-sync
    //  If user resizes past breakpoint while overlay is open, close it.
    // ──────────────────────────────────────────────────────────────
    let lastDesktop = isDesktop();
    window.addEventListener('resize', () => {
        const nowDesktop = isDesktop();
        if (nowDesktop !== lastDesktop) {
            lastDesktop = nowDesktop;
            if (nowDesktop && overlay && overlay.classList.contains('is-open')) {
                closeOverlay();
            }
            // Reset mobile accordion state on breakpoint change
            overlayToggleLinks.forEach(btn => {
                btn.setAttribute('aria-expanded', 'false');
                const id = btn.getAttribute('aria-controls');
                const panel = id ? document.getElementById(id) : null;
                if (panel) panel.hidden = true;
            });
        }
    });

})();