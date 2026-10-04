<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Primary Navigation
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      includes/nav.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  PURPOSE:
 *    Data-driven primary navigation with:
 *      - Status bar (system health, secure channel, live UTC clock)
 *      - Sticky glassmorphic main bar
 *      - Desktop dropdowns (mega-menu style, keyboard accessible)
 *      - Mobile full-screen overlay with staggered reveals
 *      - Scroll progress indicator
 *      - Active link highlighting (server-side path detection)
 *
 *  REQUIRES: includes/header.php loaded first (for $csp_nonce, $site).
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

// Defensive: CSP nonce must be present if header.php ran.
$csp_nonce = $GLOBALS['csp_nonce'] ?? '';

// Current path for active-state detection.
$current_path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Helper: is this href the current (or ancestor) path?
$bv_is_active = static function (string $href) use ($current_path): bool {
    if ($href === '/') {
        return $current_path === '/';
    }
    return str_starts_with($current_path, rtrim($href, '/'));
};

// ──────────────────────────────────────────────────────────────────────────
//  Navigation data — add/edit here; markup is rendered from this structure.
// ──────────────────────────────────────────────────────────────────────────
$nav_items = [
    [
        'label' => 'Home',
        'href'  => '/',
        'icon'  => 'fa-solid fa-house',
    ],
    [
        'label'    => 'Services',
        'href'     => '/services',
        'icon'     => 'fa-solid fa-shield-halved',
        'children' => [
            [
                'label' => 'Bug Bounty Hunting',
                'href'  => '/services/bug-bounty.php',
                'icon'  => 'fa-solid fa-bug',
                'desc'  => 'Responsible disclosure of critical vulnerabilities.',
            ],
            [
                'label' => 'Web Development',
                'href'  => '/services/web-development.php',
                'icon'  => 'fa-solid fa-code',
                'desc'  => 'Security-hardened websites and web applications.',
            ],
            [
                'label' => 'Mobile Development',
                'href'  => '/services/mobile-development.php',
                'icon'  => 'fa-solid fa-mobile-screen-button',
                'desc'  => 'Native Android and iOS applications.',
            ],
            [
                'label' => 'In-House Projects',
                'href'  => '/services/in-house.php',
                'icon'  => 'fa-solid fa-hammer',
                'desc'  => 'Tools and platforms built for ourselves.',
            ],
        ],
    ],
    [
        'label' => 'Portfolio',
        'href'  => '/portfolio.php',
        'icon'  => 'fa-solid fa-trophy',
    ],
    [
        'label' => 'About',
        'href'  => '/about.php',
        'icon'  => 'fa-solid fa-user-secret',
    ],
    [
        'label' => 'Contact',
        'href'  => '/contact.php',
        'icon'  => 'fa-solid fa-envelope',
    ],
];

// Special external callout — MyCitadel
$mycitadel = [
    'label' => 'MyCitadel',
    'href'  => 'https://mycitadel.lol',
    'icon'  => 'fa-solid fa-chess-rook',
];
?>

<!-- ═══════════════════════════════════════════════════════════════════════
     PRIMARY NAVIGATION
     ═══════════════════════════════════════════════════════════════════════ -->
<header class="bv-nav" id="bv-nav" role="banner">

    <!-- ─── Scroll progress bar ──────────────────────────────────────── -->
    <div class="bv-nav__progress" aria-hidden="true">
        <div class="bv-nav__progress-bar" id="bv-nav-progress"></div>
    </div>

    <!-- ─── Status bar (system / secure channel / UTC clock) ─────────── -->
    <div class="bv-nav__status" role="status" aria-label="System status">
        <div class="bv-nav__status-inner">

            <div class="bv-nav__status-group bv-nav__status-group--left">
                <span class="bv-nav__status-item">
                    <span class="bv-nav__status-dot" aria-hidden="true"></span>
                    <span class="bv-nav__status-label">SYSTEM</span>
                    <span class="bv-nav__status-value">ONLINE</span>
                </span>
                <span class="bv-nav__status-divider" aria-hidden="true">᛫</span>
                <span class="bv-nav__status-item bv-nav__status-item--hide-sm">
                    <i class="fa-solid fa-lock" aria-hidden="true"></i>
                    <span class="bv-nav__status-label">CHANNEL</span>
                    <span class="bv-nav__status-value">TLS 1.3</span>
                </span>
            </div>

            <div class="bv-nav__status-group bv-nav__status-group--center">
                <span class="bv-nav__status-rune" aria-hidden="true">ᚠ</span>
                <span class="bv-nav__status-motto">FORGED IN CODE · TEMPERED IN BLOOD</span>
                <span class="bv-nav__status-rune" aria-hidden="true">ᚠ</span>
            </div>

            <div class="bv-nav__status-group bv-nav__status-group--right">
                <span class="bv-nav__status-item">
                    <i class="fa-solid fa-satellite-dish" aria-hidden="true"></i>
                    <span class="bv-nav__status-label">UTC</span>
                    <time class="bv-nav__status-value" id="bv-nav-clock">--:--:--</time>
                </span>
            </div>

        </div>
    </div>

    <!-- ─── Main navigation bar ──────────────────────────────────────── -->
    <div class="bv-nav__main">
        <div class="bv-nav__inner">

            <!-- Logo / brand -->
            <a href="/" class="bv-nav__logo" aria-label="BVSec — Home">
                <span class="bv-nav__logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 40 40" width="40" height="40" fill="none" xmlns="http://www.w3.org/2000/svg" role="img">
                        <defs>
                            <linearGradient id="bvLogoGrad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="var(--bv-color-accent)"/>
                                <stop offset="100%" stop-color="var(--bv-color-accent-warm)"/>
                            </linearGradient>
                        </defs>
                        <path d="M20 2 L34 8 L34 20 C34 28 27 35 20 38 C13 35 6 28 6 20 L6 8 Z"
                              stroke="url(#bvLogoGrad)" stroke-width="2" fill="none"/>
                        <path d="M14 14 L14 26 M14 14 L20 14 C22 14 23 15 23 17 C23 18.5 22 19.5 20 19.5 L14 19.5 M14 19.5 L20 19.5 C22.5 19.5 24 20.5 24 23 C24 25 22.5 26 20 26 L14 26"
                              stroke="url(#bvLogoGrad)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="bv-nav__logo-text" data-text="BVSEC">BVSEC</span>
                <span class="bv-nav__logo-tag" aria-hidden="true">// SECURITY FORGE</span>
            </a>

            <!-- Desktop menu -->
            <nav class="bv-nav__menu-wrap" aria-label="Primary">
                <ul class="bv-nav__menu" role="list">
                    <?php foreach ($nav_items as $item): ?>
                        <?php $has_children = !empty($item['children']); ?>
                        <?php $active = $bv_is_active($item['href']); ?>
                        <li class="bv-nav__item <?= $has_children ? 'bv-nav__item--has-dropdown' : '' ?>">
                            <?php if ($has_children): ?>
                                <button
                                    type="button"
                                    class="bv-nav__link bv-nav__link--toggle <?= $active ? 'is-active' : '' ?>"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    aria-controls="bv-dropdown-<?= md5($item['label']) ?>"
                                >
                                    <i class="<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                    <span><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <i class="fa-solid fa-chevron-down bv-nav__caret" aria-hidden="true"></i>
                                </button>

                                <div
                                    class="bv-nav__dropdown"
                                    id="bv-dropdown-<?= md5($item['label']) ?>"
                                    role="region"
                                    aria-label="<?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?> submenu"
                                >
                                    <div class="bv-nav__dropdown-inner">
                                        <ul class="bv-nav__dropdown-list" role="list">
                                            <?php foreach ($item['children'] as $child): ?>
                                                <li>
                                                    <a href="<?= htmlspecialchars($child['href'], ENT_QUOTES, 'UTF-8') ?>" class="bv-nav__dropdown-link">
                                                        <span class="bv-nav__dropdown-icon" aria-hidden="true">
                                                            <i class="<?= htmlspecialchars($child['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                                                        </span>
                                                        <span class="bv-nav__dropdown-body">
                                                            <span class="bv-nav__dropdown-label"><?= htmlspecialchars($child['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                                            <?php if (!empty($child['desc'])): ?>
                                                                <span class="bv-nav__dropdown-desc"><?= htmlspecialchars($child['desc'], ENT_QUOTES, 'UTF-8') ?></span>
                                                            <?php endif; ?>
                                                        </span>
                                                        <span class="bv-nav__dropdown-arrow" aria-hidden="true">→</span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"
                                   class="bv-nav__link <?= $active ? 'is-active' : '' ?>"
                                   <?= $active ? 'aria-current="page"' : '' ?>>
                                    <i class="<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                    <span><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <!-- Right-side actions -->
            <div class="bv-nav__actions">

                <a
                    href="<?= htmlspecialchars($mycitadel['href'], ENT_QUOTES, 'UTF-8') ?>"
                    class="bv-nav__citadel"
                    rel="noopener noreferrer"
                    target="_blank"
                    title="MyCitadel — privacy-first social platform"
                >
                    <i class="<?= htmlspecialchars($mycitadel['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                    <span class="bv-nav__citadel-text"><?= htmlspecialchars($mycitadel['label'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="bv-nav__citadel-pulse" aria-hidden="true"></span>
                </a>

                <a href="/contact" class="bv-nav__cta">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    <span>HIRE US</span>
                </a>

                <!-- Hamburger (mobile) -->
                <button
                    type="button"
                    class="bv-nav__toggle"
                    id="bv-nav-toggle"
                    aria-label="Open menu"
                    aria-expanded="false"
                    aria-controls="bv-nav-overlay"
                >
                    <span class="bv-nav__toggle-box" aria-hidden="true">
                        <span class="bv-nav__toggle-line"></span>
                        <span class="bv-nav__toggle-line"></span>
                        <span class="bv-nav__toggle-line"></span>
                    </span>
                    <span class="bv-nav__toggle-text">MENU</span>
                </button>

            </div>

        </div>
    </div>

    <!-- ─── Mobile overlay ──────────────────────────────────────────── -->
    <div
        class="bv-nav__overlay"
        id="bv-nav-overlay"
        role="dialog"
        aria-modal="true"
        aria-label="Navigation menu"
        hidden
    >
        <div class="bv-nav__overlay-scanlines" aria-hidden="true"></div>

        <div class="bv-nav__overlay-inner">

            <div class="bv-nav__overlay-header">
                <span class="bv-nav__overlay-title">
                    <span class="bv-nav__status-rune" aria-hidden="true">ᛝ</span>
                    NAVIGATION
                </span>
                <button
                    type="button"
                    class="bv-nav__overlay-close"
                    id="bv-nav-overlay-close"
                    aria-label="Close menu"
                >
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <nav class="bv-nav__overlay-nav" aria-label="Mobile">
                <ul class="bv-nav__overlay-list" role="list">
                    <?php foreach ($nav_items as $index => $item): ?>
                        <?php $has_children = !empty($item['children']); ?>
                        <?php $active = $bv_is_active($item['href']); ?>

                        <?php if ($has_children): ?>
                            <li class="bv-nav__overlay-item bv-nav__overlay-item--has-children" style="--bv-stagger: <?= $index ?>">
                                <button
                                    type="button"
                                    class="bv-nav__overlay-link bv-nav__overlay-link--toggle <?= $active ? 'is-active' : '' ?>"
                                    aria-expanded="false"
                                    aria-controls="bv-overlay-sub-<?= md5($item['label']) ?>"
                                >
                                    <span class="bv-nav__overlay-num" aria-hidden="true"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                    <i class="<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                    <span class="bv-nav__overlay-label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <i class="fa-solid fa-chevron-down bv-nav__overlay-caret" aria-hidden="true"></i>
                                </button>

                                <div class="bv-nav__overlay-sub" id="bv-overlay-sub-<?= md5($item['label']) ?>" hidden>
                                    <ul role="list">
                                        <?php foreach ($item['children'] as $child): ?>
                                            <li>
                                                <a href="<?= htmlspecialchars($child['href'], ENT_QUOTES, 'UTF-8') ?>" class="bv-nav__overlay-sublink">
                                                    <i class="<?= htmlspecialchars($child['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                                    <span><?= htmlspecialchars($child['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="bv-nav__overlay-item" style="--bv-stagger: <?= $index ?>">
                                <a
                                    href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="bv-nav__overlay-link <?= $active ? 'is-active' : '' ?>"
                                    <?= $active ? 'aria-current="page"' : '' ?>
                                >
                                    <span class="bv-nav__overlay-num" aria-hidden="true"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                    <i class="<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                                    <span class="bv-nav__overlay-label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="bv-nav__overlay-arrow" aria-hidden="true">→</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- MyCitadel external -->
                    <li class="bv-nav__overlay-item bv-nav__overlay-item--external" style="--bv-stagger: <?= count($nav_items) ?>">
                        <a
                            href="<?= htmlspecialchars($mycitadel['href'], ENT_QUOTES, 'UTF-8') ?>"
                            class="bv-nav__overlay-link bv-nav__overlay-link--external"
                            rel="noopener noreferrer"
                            target="_blank"
                        >
                            <span class="bv-nav__overlay-num" aria-hidden="true">★</span>
                            <i class="<?= htmlspecialchars($mycitadel['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                            <span class="bv-nav__overlay-label"><?= htmlspecialchars($mycitadel['label'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="bv-nav__overlay-arrow" aria-hidden="true">↗</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="bv-nav__overlay-footer">
                <a href="/contact" class="bv-nav__overlay-cta">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    <span>HIRE US</span>
                </a>
                <div class="bv-nav__overlay-meta">
                    <span><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> SECURE CHANNEL</span>
                    <span class="bv-nav__status-divider" aria-hidden="true">᛫</span>
                    <span><i class="fa-solid fa-satellite-dish" aria-hidden="true"></i> <span id="bv-nav-clock-mobile">--:--:--</span> UTC</span>
                </div>
            </div>

        </div>
    </div>

</header>

<!-- Spacer so sticky nav doesn't overlap content on load -->
<div class="bv-nav-spacer" aria-hidden="true"></div>