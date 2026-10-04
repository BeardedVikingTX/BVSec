/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Portfolio Controller
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      assets/js/bvsec_portfolio.js
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  FEATURES:
 *    - Category filtering with animated transitions
 *    - Live search with debounce
 *    - URL hash sync (filters persist across reloads/shareable)
 *    - Lightbox modal with keyboard navigation
 *    - Focus trap in modal
 *    - Counter animations for hero metrics
 *    - Reduced-motion respected
 * ═══════════════════════════════════════════════════════════════════════════
 */

(() => {
    'use strict';

    // ══════════════════════════════════════════════════════════════════════
    //  UTILS
    // ══════════════════════════════════════════════════════════════════════
    const $  = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    const prefersReducedMotion = () =>
        matchMedia('(prefers-reduced-motion: reduce)').matches;

    const debounce = (fn, wait = 200) => {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...args), wait);
        };
    };

    const rafThrottle = (fn) => {
        let ticking = false;
        return (...args) => {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(() => {
                fn(...args);
                ticking = false;
            });
        };
    };

    // ══════════════════════════════════════════════════════════════════════
    //  PROJECT DATA — extracted from DOM at boot
    // ══════════════════════════════════════════════════════════════════════
    const readProjectsFromDOM = () => {
        return $$('.bv-pf-card').map((card) => ({
            id:         card.dataset.projectId,
            categories: (card.dataset.categories || '').split(/\s+/).filter(Boolean),
            search:     card.dataset.search || '',
            card,
        }));
    };

    // ══════════════════════════════════════════════════════════════════════
    //  FILTER + SEARCH CONTROLLER
    // ══════════════════════════════════════════════════════════════════════
    class PortfolioFilter {
        constructor() {
            this.cards        = readProjectsFromDOM();
            this.grid         = $('#bv-pf-grid');
            this.empty        = $('#bv-pf-empty');
            this.resultCount  = $('#bv-pf-result-count');
            this.searchInput  = $('#bv-pf-search');
            this.searchClear  = $('#bv-pf-search-clear');
            this.filters      = $$('.bv-pf-filter');
            this.resetBtns    = $$('[data-pf-reset]');

            this.activeFilter = 'all';
            this.query        = '';
        }

        start() {
            if (!this.grid || !this.cards.length) return this;

            // Filter button clicks
            this.filters.forEach((btn) => {
                btn.addEventListener('click', () => {
                    this.setFilter(btn.dataset.filter);
                });
            });

            // Search input
            if (this.searchInput) {
                const debounced = debounce(() => {
                    this.query = this.searchInput.value.trim().toLowerCase();
                    this.searchClear.hidden = this.query.length === 0;
                    this.apply();
                }, 180);
                this.searchInput.addEventListener('input', debounced);
                this.searchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.searchInput.value = '';
                        this.query = '';
                        this.searchClear.hidden = true;
                        this.apply();
                    }
                });
            }

            // Clear search
            if (this.searchClear) {
                this.searchClear.addEventListener('click', () => {
                    this.searchInput.value = '';
                    this.query = '';
                    this.searchClear.hidden = true;
                    this.searchInput.focus();
                    this.apply();
                });
            }

            // Reset buttons
            this.resetBtns.forEach((btn) => {
                btn.addEventListener('click', () => this.reset());
            });

            // Restore from URL hash
            this.applyFromHash();

            // Keyboard: hash change
            window.addEventListener('hashchange', () => this.applyFromHash());

            // Initial paint
            this.apply();

            return this;
        }

        setFilter(id) {
            this.activeFilter = id || 'all';

            // Update button state
            this.filters.forEach((btn) => {
                const active = btn.dataset.filter === this.activeFilter;
                btn.classList.toggle('is-active', active);
                btn.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            // Sync URL hash
            if (this.activeFilter === 'all' && !this.query) {
                history.replaceState(null, '', location.pathname + location.search);
            } else {
                history.replaceState(null, '', `#filter=${this.activeFilter}`);
            }

            this.apply();
        }

        applyFromHash() {
            const hash = location.hash.replace(/^#/, '');
            const params = new URLSearchParams(hash);
            const filter = params.get('filter');
            if (filter && this.filters.some((b) => b.dataset.filter === filter)) {
                this.activeFilter = filter;
                this.filters.forEach((btn) => {
                    const active = btn.dataset.filter === filter;
                    btn.classList.toggle('is-active', active);
                    btn.setAttribute('aria-selected', active ? 'true' : 'false');
                });
            }
        }

        reset() {
            this.query = '';
            if (this.searchInput) this.searchInput.value = '';
            if (this.searchClear) this.searchClear.hidden = true;
            this.setFilter('all');
        }

        matches(card) {
            // Category filter
            if (this.activeFilter !== 'all' && !card.categories.includes(this.activeFilter)) {
                return false;
            }
            // Search query
            if (this.query && !card.search.includes(this.query)) {
                return false;
            }
            return true;
        }

        apply() {
            let visible = 0;

            this.cards.forEach(({ card }) => {
                const show = this.matches(card);
                card.hidden = !show;
                if (show) {
                    // Re-trigger stagger animation
                    card.style.setProperty('--bv-pf-delay', String(visible % 8));
                    visible++;
                }
            });

            // Empty state
            if (this.empty) this.empty.hidden = visible > 0;

            // Result count
            if (this.resultCount) {
                const total = this.cards.length;
                if (visible === total && this.activeFilter === 'all' && !this.query) {
                    this.resultCount.textContent = `Showing all ${total} projects`;
                } else if (visible === 0) {
                    this.resultCount.textContent = 'No matching projects';
                } else {
                    this.resultCount.textContent = `Showing ${visible} of ${total} projects`;
                }
            }
        }
    }

    // ══════════════════════════════════════════════════════════════════════
    //  LIGHTBOX MODAL
    // ══════════════════════════════════════════════════════════════════════
    class PortfolioModal {
        constructor() {
            this.modal       = $('#bv-pf-modal');
            if (!this.modal) return;

            this.body        = $('#bv-pf-modal-body');
            this.image       = $('#bv-pf-modal-image');
            this.yearEl      = $('#bv-pf-modal-year');
            this.typeEl      = $('#bv-pf-modal-type');
            this.statusEl    = $('#bv-pf-modal-status');
            this.titleEl     = $('#bv-pf-modal-title');
            this.subtitleEl  = $('#bv-pf-modal-subtitle');
            this.descEl      = $('#bv-pf-modal-description');
            this.highlightsEl= $('#bv-pf-modal-highlights');
            this.stackEl     = $('#bv-pf-modal-stack');
            this.actionsEl   = $('#bv-pf-modal-actions');
            this.barLabel    = $('#bv-pf-modal-bar-label');

            this.closeBtn    = $('#bv-pf-modal-close');
            this.prevBtn     = $('#bv-pf-modal-prev');
            this.nextBtn     = $('#bv-pf-modal-next');

            this.triggerBtns = $$('[data-pf-open]');

            this.currentIndex = -1;
            this.ids = [];
            this.focusBeforeOpen = null;

            this.buildIndex();
            this.bindEvents();
        }

        buildIndex() {
            this.ids = $$('.bv-pf-card').map((c) => c.dataset.projectId);
        }

        bindEvents() {
            // Open buttons
            this.triggerBtns.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = btn.dataset.pfOpen;
                    const idx = this.ids.indexOf(id);
                    if (idx >= 0) this.open(idx);
                });
            });

            // Close buttons
            this.closeBtn.addEventListener('click', () => this.close());
            this.modal.querySelector('.bv-pf-modal__backdrop')
                ?.addEventListener('click', () => this.close());

            // Prev/Next
            this.prevBtn.addEventListener('click', () => this.navigate(-1));
            this.nextBtn.addEventListener('click', () => this.navigate(1));

            // Keyboard
            document.addEventListener('keydown', (e) => {
                if (!this.modal.classList.contains('is-open')) return;
                switch (e.key) {
                    case 'Escape':    e.preventDefault(); this.close(); break;
                    case 'ArrowLeft': e.preventDefault(); this.navigate(-1); break;
                    case 'ArrowRight':e.preventDefault(); this.navigate(1); break;
                    case 'Tab':       this.trapFocus(e); break;
                }
            });
        }

        async open(index) {
            const id = this.ids[index];
            if (!id) return;

            const card = document.querySelector(`.bv-pf-card[data-project-id="${id}"]`);
            if (!card) return;

            // Try to fetch full data from the embedded JSON or reconstruct from card
            const data = this.extractData(card);
            if (!data) return;

            this.currentIndex = index;
            this.focusBeforeOpen = document.activeElement;

            // Populate modal
            this.populate(data);

            // Show
            this.modal.hidden = false;
            requestAnimationFrame(() => {
                this.modal.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            });

            // Focus close button
            setTimeout(() => this.closeBtn.focus(), 60);

            // Reset scroll
            if (this.body) this.body.scrollTop = 0;
        }

        extractData(card) {
            // Minimal reconstruction from DOM.
            // For full data (description, highlights, stack), we rely on the
            // embedded JSON island in the page. See init() below.
            return window.BVSEC_PORTFOLIO_DATA?.[card.dataset.projectId] ?? null;
        }

        populate(d) {
            // Image
            this.image.src = d.image;
            this.image.alt = d.image_alt || d.title;

            // Meta
            this.yearEl.textContent = d.year;
            this.typeEl.textContent = d.type;

            // Status
            const statusLabel = { live: 'LIVE', delivered: 'DELIVERED', archived: 'ARCHIVED' }[d.status] || 'UNKNOWN';
            this.statusEl.textContent = statusLabel;
            this.statusEl.className = `bv-pf-modal__status bv-pf-modal__status--${d.status}`;

            // Titles
            this.titleEl.textContent    = d.title;
            this.subtitleEl.textContent = d.subtitle;
            this.descEl.textContent     = d.description;

            // Bar label
            this.barLabel.textContent = `${d.id}.md`;

            // Highlights
            this.highlightsEl.innerHTML = '';
            (d.highlights || []).forEach((h) => {
                const li = document.createElement('li');
                li.textContent = h;
                this.highlightsEl.appendChild(li);
            });

            // Stack
            this.stackEl.innerHTML = '';
            (d.stack || []).forEach((s) => {
                const span = document.createElement('span');
                span.className = 'bv-badge';
                span.textContent = s;
                this.stackEl.appendChild(span);
            });

            // Actions
            this.actionsEl.innerHTML = '';
            if (d.link) {
                const a = document.createElement('a');
                a.href = d.link;
                a.target = '_blank';
                a.rel = 'noopener noreferrer';
                a.className = 'bv-btn bv-btn--primary';
                a.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i><span>Visit Live Site</span>';
                this.actionsEl.appendChild(a);
            }
            const cta = document.createElement('a');
            cta.href = '/contact';
            cta.className = 'bv-btn bv-btn--secondary';
            cta.innerHTML = '<i class="fa-solid fa-bolt" aria-hidden="true"></i><span>Build Something Like This</span>';
            this.actionsEl.appendChild(cta);
        }

        navigate(delta) {
            const next = (this.currentIndex + delta + this.ids.length) % this.ids.length;
            // Only navigate to visible cards? Simpler: navigate all.
            this.open(next);
        }

        close() {
            this.modal.classList.remove('is-open');
            const onEnd = () => {
                this.modal.hidden = true;
                this.modal.removeEventListener('transitionend', onEnd);
            };
            this.modal.addEventListener('transitionend', onEnd);
            setTimeout(() => { if (!this.modal.classList.contains('is-open')) this.modal.hidden = true; }, 400);

            document.body.style.overflow = '';
            if (this.focusBeforeOpen && typeof this.focusBeforeOpen.focus === 'function') {
                this.focusBeforeOpen.focus();
            }
        }

        trapFocus(e) {
            const focusables = $$(
                'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])',
                this.modal
            ).filter((el) => el.offsetParent !== null);

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
        }
    }

    // ══════════════════════════════════════════════════════════════════════
    //  COUNTER ANIMATIONS
    // ══════════════════════════════════════════════════════════════════════
    const initCounters = () => {
        const counters = $$('[data-counter]');
        if (!counters.length) return;

        if (prefersReducedMotion() || !('IntersectionObserver' in window)) {
            counters.forEach((c) => { c.textContent = c.dataset.counter; });
            return;
        }

        const animate = (el) => {
            const target = parseInt(el.dataset.counter, 10) || 0;
            const duration = 1500;
            const start = performance.now();

            const tick = (now) => {
                const t = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - t, 4);
                el.textContent = Math.round(target * eased);
                if (t < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        };

        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    animate(entry.target);
                    obs.unobserve(entry.target);
                });
            },
            { threshold: 0.5 }
        );

        counters.forEach((c) => observer.observe(c));
    };

    // ══════════════════════════════════════════════════════════════════════
    //  BOOT
    // ══════════════════════════════════════════════════════════════════════
    const boot = () => {
        try { new PortfolioFilter().start(); } catch (e) { console.error('[BVSec:portfolio] filter failed:', e); }
        try { new PortfolioModal(); }          catch (e) { console.error('[BVSec:portfolio] modal failed:', e); }
        try { initCounters(); }                catch (e) { console.error('[BVSec:portfolio] counters failed:', e); }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

})();