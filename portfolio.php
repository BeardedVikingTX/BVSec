<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Portfolio / The Archive
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      portfolio.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Portfolio — The Archive of Forged Work',
    'description' => 'A decade of shipped applications, web platforms, and client engagements. Android, iOS, Ruby on Rails, PHP — every project field-proven.',
    'canonical'   => '/portfolio',
    'og_image'    => '/assets/images/og/portfolio.png',
    'body_class'  => 'page-portfolio',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  PROJECT DATA
//  Single source of truth for the grid, filters, and lightbox.
//  Adding a project = adding one array entry. No markup changes needed.
// ──────────────────────────────────────────────────────────────────────────
$projects = [
    [
        'id'          => 'mycitadel-android',
        'title'       => 'MyCitadel (Android)',
        'subtitle'    => 'Native privacy-first social platform',
        'year'        => '2026',
        'type'        => 'In-House',
        'categories'  => ['android', 'in-house'],
        'image'       => '/assets/img/portfolio/MyCitadel_Android_App_Home_Page.jpeg',
        'image_alt'   => 'MyCitadel native Android application home feed',
        'tagline'     => 'The privacy-first social platform — shipped natively for Android.',
        'description' => 'Native Android application built with Kotlin, mirroring the full MyCitadel web experience with offline-first architecture, end-to-end encrypted messaging, and hardware-backed keystore for credential storage. No ads. No trackers. No telemetry. Your feed, your device, your rules.',
        'stack'       => ['Kotlin', 'Jetpack Compose', 'Room DB', 'Keystore', 'Retrofit', 'REST API'],
        'highlights'  => [
            'Zero third-party SDKs — no analytics, no ad networks, no crash reporters',
            'Hardware-backed key storage for session tokens and message keys',
            'Offline-first architecture with conflict-free sync',
            'Certificate pinning on all API calls',
            'Full source available on GitHub for public audit',
        ],
        'status'      => 'live',
        'link'        => 'https://mycitadel.lol',
    ],
    [
        'id'          => 'mycitadel-web',
        'title'       => 'MyCitadel (Web)',
        'subtitle'    => 'Privacy-first social platform',
        'year'        => '2025',
        'type'        => 'In-House',
        'categories'  => ['web', 'in-house'],
        'image'       => '/assets/img/portfolio/MyCitadel_Web.png',
        'image_alt'   => 'MyCitadel web platform interface',
        'tagline'     => 'The fortress. Built from scratch. No compromises.',
        'description' => 'Custom social platform built entirely from the ground up — no WordPress, no Laravel, no frameworks doing the heavy lifting. A bespoke PHP backend with a RESTful API layer, custom authentication system with Argon2id hashing, and a hand-rolled content pipeline that handles real-time interactions without a single third-party tracker.',
        'stack'       => ['PHP 8.2', 'MySQL 8', 'REST API', 'Vanilla JS', 'HTML5', 'CSS3', 'WebSockets'],
        'highlights'  => [
            'Custom authentication with Argon2id + rotating session tokens',
            'Zero third-party JavaScript — no Google Analytics, no CDNs, no fonts leaked to third parties',
            'Full-stack content moderation with cryptographic audit log',
            'Built to handle federation protocol extensions',
            'Source code published for public security audit',
        ],
        'status'      => 'live',
        'link'        => 'https://mycitadel.lol',
    ],
    [
        'id'          => 'b1tech',
        'title'       => 'B1Tech',
        'subtitle'    => 'Multi-carrier insurance quote engine',
        'year'        => '2022',
        'type'        => 'Client Work',
        'categories'  => ['web', 'client'],
        'image'       => '/assets/img/portfolio/b1tech.png',
        'image_alt'   => 'B1Tech insurance quote aggregation platform',
        'tagline'     => 'Enter it once. Quote from everywhere. Bind in seconds.',
        'description' => 'Ruby on Rails application integrating multiple insurance carrier APIs into a single unified quoting interface. Agents enter client information once, hit "Quote All," and receive real-time pricing from every connected carrier — allowing side-by-side comparison, digital signature, and immediate bind. Deployed on in-house servers with failover to cloud.',
        'stack'       => ['Ruby on Rails', 'PostgreSQL', 'Insurance APIs', 'Sidekiq', 'Redis', 'Nginx'],
        'highlights'  => [
            'Multi-carrier API orchestration with parallel request handling',
            'Digital signature and bind workflow with carrier-specific validation',
            'Automated commission tracking and reporting',
            'Role-based access control for agencies, agents, and support staff',
            'In-house server deployment with cloud failover',
        ],
        'status'      => 'delivered',
    ],
    [
        'id'          => 'expertware',
        'title'       => 'Expertware',
        'subtitle'    => 'All-in-one call center operations platform',
        'year'        => '2021',
        'type'        => 'Client Work',
        'categories'  => ['web', 'client'],
        'image'       => '/assets/img/portfolio/expertware.png',
        'image_alt'   => 'Expertware call center operations dashboard',
        'tagline'     => 'One screen. Every caller. Every dispatch. Every payment.',
        'description' => 'Ruby on Rails operations platform that unified a fragmented call center workflow into a single-pane-of-glass dashboard. Pulled live caller data from the Five9 dialing platform, integrated a dispatch board for field service coordination, and handled third-party vendor payments — all without requiring operators to leave the interface.',
        'stack'       => ['Ruby on Rails', 'Five9 API', 'PostgreSQL', 'Stripe', 'ActionCable', 'Heroku'],
        'highlights'  => [
            'Live caller data streaming from Five9 dialing software',
            'Drag-and-drop dispatch board with driver tracking',
            'Third-party vendor payment integration',
            'Real-time operator dashboard with WebSocket updates',
            'Full audit trail for every caller interaction',
        ],
        'status'      => 'delivered',
    ],
    [
        'id'          => 'wc-android',
        'title'       => 'Weatherford College',
        'subtitle'    => 'The original campus mobile app',
        'year'        => '2018',
        'type'        => 'Client Work',
        'categories'  => ['android', 'client'],
        'image'       => '/assets/img/portfolio/wc_android.png',
        'image_alt'   => 'Weatherford College Android application',
        'tagline'     => 'The one that started it all. Built while I was still a student.',
        'description' => 'Original Android application for Weatherford College, built during my time as a Video Game Design & Development student. Connected students to campus resources — course schedules, dining menus, event calendars, and campus maps — in a single native app. This is where I learned that mobile development was more than a hobby.',
        'stack'       => ['Java', 'Android SDK', 'SQLite', 'REST API', 'XML Layouts'],
        'highlights'  => [
            'Native Android built before Jetpack existed',
            'Custom REST client for campus data endpoints',
            'Offline-capable schedule and event caching',
            'Built while working toward a Video Game Design & Development degree',
            'The project that turned me into a mobile developer',
        ],
        'status'      => 'archived',
    ],
    [
        'id'          => 'mydaddy',
        'title'       => 'MyDaddy',
        'subtitle'    => 'The first paid client project',
        'year'        => '2019',
        'type'        => 'Client Work',
        'categories'  => ['android', 'client'],
        'image'       => '/assets/img/portfolio/mydaddy_android.png',
        'image_alt'   => 'MyDaddy Android application interface',
        'tagline'     => 'The project that turned a hobby into a career.',
        'description' => 'My first professional Android application, built for a paying client. A utility app designed around a specific family-oriented use case, delivered end-to-end from concept through Play Store deployment. This engagement is where I learned that shipping for a real client — with real deadlines and real expectations — is a completely different discipline than coding for myself.',
        'stack'       => ['Java', 'Android SDK', 'SQLite', 'Firebase', 'Material Design'],
        'highlights'  => [
            'First paid client engagement — sold, scoped, built, and delivered solo',
            'Play Store deployment and post-launch support',
            'Learned the reality of client communication and scope management',
            'Foundation for every client project that followed',
        ],
        'status'      => 'archived',
    ],
    [
        'id'          => 'diy-dwi',
        'title'       => 'DIY / DWI Legal Assistant',
        'subtitle'    => 'Cross-platform legal mobile app',
        'year'        => '2020',
        'type'        => 'Client Work',
        'categories'  => ['android', 'ios', 'client'],
        'image'       => '/assets/img/portfolio/diy_dwi_mobile.png',
        'image_alt'   => 'DIY/DWI legal assistant mobile application',
        'tagline'     => 'Where the iOS chapter of my career began.',
        'description' => 'Dual-platform mobile application built for a practicing attorney. Guided clients through common legal scenarios with a decision-tree interface, document templates, and appointment scheduling. This project was the start of my iOS development path — I built the Android version first, then taught myself Swift to ship the iOS counterpart.',
        'stack'       => ['Kotlin', 'Swift', 'Android SDK', 'iOS SDK', 'SQLite', 'REST API'],
        'highlights'  => [
            'First iOS application — Swift was learned mid-project',
            'Dual-platform deployment to Play Store and App Store',
            'Decision-tree UI driven by data, not hardcoded flows',
            'Document generation with PDF export',
            'The turning point that made me a cross-platform developer',
        ],
        'status'      => 'archived',
    ],
];

// Category display labels for the filter bar.
$categories = [
    'all'       => 'All Work',
    'android'   => 'Android',
    'ios'       => 'iOS',
    'web'       => 'Web Platforms',
    'client'    => 'Client Work',
    'in-house'  => 'In-House',
];

// Status → label + style class
$status_meta = [
    'live'      => ['label' => 'LIVE',      'class' => 'live'],
    'delivered' => ['label' => 'DELIVERED', 'class' => 'delivered'],
    'archived'  => ['label' => 'ARCHIVED',  'class' => 'archived'],
];
?>

<main id="main-content" class="bv-main bv-portfolio">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-pf-hero" id="pf-hero" aria-labelledby="pf-hero-title">

    <div class="bv-pf-hero__bg" aria-hidden="true">
        <div class="bv-pf-hero__vignette"></div>
        <div class="bv-pf-hero__grid"></div>
        <div class="bv-pf-hero__aurora"></div>
    </div>

    <div class="bv-pf-hero__runes bv-pf-hero__runes--left" aria-hidden="true">
        <span>ᚹ</span><span>ᛟ</span><span>ᚱ</span><span>ᚲ</span>
    </div>
    <div class="bv-pf-hero__runes bv-pf-hero__runes--right" aria-hidden="true">
        <span>ᚨ</span><span>ᚱ</span><span>ᚲ</span><span>ᛁ</span><span>ᚢ</span><span>ᛖ</span>
    </div>

    <div class="bv-pf-hero__inner">

        <span class="bv-section__eyebrow">᛫ The Archive · Field-Proven Work ᛫</span>

        <h1 class="bv-pf-hero__title" id="pf-hero-title">
            <span class="bv-pf-hero__title-runes" aria-hidden="true">ᚨᚱᚲᛁᚢᛖ</span>
            <span class="bv-pf-hero__title-line bv-pf-hero__title-line--viking">Not a Gallery.</span>
            <span class="bv-pf-hero__title-line bv-pf-hero__title-line--accent">
                <span class="bv-glitch" data-text="A War Record.">A War Record.</span>
            </span>
        </h1>

        <p class="bv-pf-hero__lead">
            Every project below shipped. Every client paid. Every line of code was
            written by the same keyboard you're reading this on. No agency. No team.
            No handoffs. Just the work — and the proof that it exists.
        </p>

        <div class="bv-pf-hero__metrics" role="list">
            <div class="bv-pf-hero__metric" role="listitem">
                <span class="bv-pf-hero__metric-value" data-counter="<?= count($projects) ?>">0</span>
                <span class="bv-pf-hero__metric-label">Projects Shipped</span>
            </div>
            <div class="bv-pf-hero__metric" role="listitem">
                <span class="bv-pf-hero__metric-value" data-counter="3">0</span>
                <span class="bv-pf-hero__metric-label">Platforms</span>
            </div>
            <div class="bv-pf-hero__metric" role="listitem">
                <span class="bv-pf-hero__metric-value" data-counter="8">0</span>
                <span class="bv-pf-hero__metric-label">Years Shipping</span>
            </div>
            <div class="bv-pf-hero__metric" role="listitem">
                <span class="bv-pf-hero__metric-value" data-counter="100">0</span>
                <span class="bv-pf-hero__metric-label">% Solo</span>
            </div>
        </div>

    </div>

    <div class="bv-pf-hero__scroll" aria-hidden="true">
        <span class="bv-pf-hero__scroll-rune">ᛝ</span>
        <span class="bv-pf-hero__scroll-text">OPEN THE ARCHIVE</span>
        <span class="bv-pf-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CONTROL BAR — FILTERS + SEARCH
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-pf-controls" aria-label="Portfolio filters">

    <div class="bv-pf-controls__inner">

        <div class="bv-pf-filters" role="tablist" aria-label="Filter projects by category">
            <?php foreach ($categories as $key => $label): ?>
                <?php $count = $key === 'all'
                    ? count($projects)
                    : count(array_filter($projects, fn($p) => in_array($key, $p['categories'], true))); ?>
                <button
                    type="button"
                    class="bv-pf-filter <?= $key === 'all' ? 'is-active' : '' ?>"
                    role="tab"
                    aria-selected="<?= $key === 'all' ? 'true' : 'false' ?>"
                    data-filter="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                >
                    <span class="bv-pf-filter__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="bv-pf-filter__count"><?= $count ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="bv-pf-search">
            <i class="fa-solid fa-magnifying-glass bv-pf-search__icon" aria-hidden="true"></i>
            <input
                type="search"
                class="bv-pf-search__input"
                id="bv-pf-search"
                placeholder="Search projects, tech, or year..."
                aria-label="Search projects"
                autocomplete="off"
                spellcheck="false"
            >
            <button
                type="button"
                class="bv-pf-search__clear"
                id="bv-pf-search-clear"
                aria-label="Clear search"
                hidden
            >
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

    </div>

    <div class="bv-pf-controls__status" aria-live="polite">
        <span id="bv-pf-result-count">Showing all <?= count($projects) ?> projects</span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     PROJECT GRID
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-pf-grid-wrap" aria-label="Projects">

    <div class="bv-pf-grid" id="bv-pf-grid">

        <?php foreach ($projects as $i => $p): ?>
            <?php
                $status = $status_meta[$p['status']] ?? ['label' => 'UNKNOWN', 'class' => 'archived'];
                $is_live = $p['status'] === 'live';
            ?>
            <article
                class="bv-pf-card"
                data-project-id="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>"
                data-categories="<?= htmlspecialchars(implode(' ', $p['categories']), ENT_QUOTES, 'UTF-8') ?>"
                data-search="<?= htmlspecialchars(
                    strtolower(
                        $p['title'] . ' ' .
                        $p['subtitle'] . ' ' .
                        $p['tagline'] . ' ' .
                        $p['year'] . ' ' .
                        implode(' ', $p['stack'])
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                data-index="<?= $i ?>"
            >
                <div class="bv-pf-card__frame">

                    <!-- Image -->
                    <button
                        type="button"
                        class="bv-pf-card__media"
                        data-pf-open="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>"
                        aria-label="Open case study for <?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <img
                            src="<?= htmlspecialchars($p['image'], ENT_QUOTES, 'UTF-8') ?>"
                            alt="<?= htmlspecialchars($p['image_alt'], ENT_QUOTES, 'UTF-8') ?>"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="bv-pf-card__overlay" aria-hidden="true">
                            <span class="bv-pf-card__overlay-icon">
                                <i class="fa-solid fa-expand"></i>
                            </span>
                            <span class="bv-pf-card__overlay-text">View Case Study</span>
                        </span>
                        <span class="bv-pf-card__status bv-pf-card__status--<?= $status['class'] ?>">
                            <span class="bv-pf-card__status-dot"></span>
                            <?= $status['label'] ?>
                        </span>
                    </button>

                    <!-- Body -->
                    <div class="bv-pf-card__body">

                        <div class="bv-pf-card__meta">
                            <span class="bv-pf-card__year bv-font-mono"><?= htmlspecialchars($p['year'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="bv-pf-card__divider" aria-hidden="true">᛫</span>
                            <span class="bv-pf-card__type bv-font-sci-label"><?= htmlspecialchars($p['type'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>

                        <h2 class="bv-pf-card__title"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p class="bv-pf-card__subtitle"><?= htmlspecialchars($p['subtitle'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="bv-pf-card__tagline"><?= htmlspecialchars($p['tagline'], ENT_QUOTES, 'UTF-8') ?></p>

                        <div class="bv-pf-card__stack">
                            <?php foreach (array_slice($p['stack'], 0, 4) as $tech): ?>
                                <span class="bv-pf-card__tech bv-font-mono"><?= htmlspecialchars($tech, ENT_QUOTES, 'UTF-8') ?></span>
                            <?php endforeach; ?>
                            <?php if (count($p['stack']) > 4): ?>
                                <span class="bv-pf-card__tech bv-pf-card__tech--more bv-font-mono">
                                    +<?= count($p['stack']) - 4 ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="bv-pf-card__actions">
                            <button
                                type="button"
                                class="bv-pf-card__btn"
                                data-pf-open="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>"
                            >
                                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                                <span>Case Study</span>
                            </button>
                            <?php if (!empty($p['link'])): ?>
                                <a
                                    href="<?= htmlspecialchars($p['link'], ENT_QUOTES, 'UTF-8') ?>"
                                    class="bv-pf-card__btn bv-pf-card__btn--ghost"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                    <span>Visit Live</span>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </article>
        <?php endforeach; ?>

    </div>

    <!-- Empty state -->
    <div class="bv-pf-empty" id="bv-pf-empty" hidden>
        <span class="bv-pf-empty__rune" aria-hidden="true">ᛝ</span>
        <h2 class="bv-pf-empty__title">Nothing matches that search.</h2>
        <p class="bv-pf-empty__lead">
            Try a different keyword — or clear the filters and start over.
        </p>
        <button type="button" class="bv-btn bv-btn--secondary" data-pf-reset>
            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
            <span>Reset Filters</span>
        </button>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     REDACTED — OTHER CLIENT WORK
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-pf-redacted" aria-labelledby="pf-redacted-title">

    <div class="bv-pf-redacted__inner">

        <div class="bv-pf-redacted__stamp" aria-hidden="true">
            <span class="bv-font-sci-display">CLASSIFIED</span>
        </div>

        <span class="bv-section__eyebrow">REDACTED FILE // ADDITIONAL WORK</span>

        <h2 class="bv-section__title bv-font-viking-display" id="pf-redacted-title">
            Some records are sealed by NDA.
        </h2>

        <p class="bv-pf-redacted__lead">
            Over the years I've handled engagements for clients who require
            confidentiality as part of their security posture — banks, healthcare
            providers, and a few outfits that simply don't want their names
            associated with anything digital. Those projects exist. They shipped.
            They're just not in this archive.
        </p>

        <div class="bv-pf-redacted__lines" aria-hidden="true">
            <div class="bv-pf-redacted__line">
                <span class="bv-pf-redacted__line-label">PROJECT</span>
                <span class="bv-pf-redacted__line-bar"></span>
                <span class="bv-pf-redacted__line-meta">2020 · Healthcare</span>
            </div>
            <div class="bv-pf-redacted__line">
                <span class="bv-pf-redacted__line-label">PROJECT</span>
                <span class="bv-pf-redacted__line-bar"></span>
                <span class="bv-pf-redacted__line-meta">2021 · Fintech</span>
            </div>
            <div class="bv-pf-redacted__line">
                <span class="bv-pf-redacted__line-label">PROJECT</span>
                <span class="bv-pf-redacted__line-bar"></span>
                <span class="bv-pf-redacted__line-meta">2022 · Logistics</span>
            </div>
            <div class="bv-pf-redacted__line">
                <span class="bv-pf-redacted__line-label">PROJECT</span>
                <span class="bv-pf-redacted__line-bar"></span>
                <span class="bv-pf-redacted__line-meta">2023 · E-Commerce</span>
            </div>
            <div class="bv-pf-redacted__line">
                <span class="bv-pf-redacted__line-label">PROJECT</span>
                <span class="bv-pf-redacted__line-bar"></span>
                <span class="bv-pf-redacted__line-meta">2024 · Non-Profit</span>
            </div>
        </div>

        <p class="bv-pf-redacted__closing bv-font-viking-body">
            If you need a reference for confidential work, I can provide client
            contacts on request — subject to their approval and NDA terms.
        </p>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-pf-cta" aria-labelledby="pf-cta-title">

    <div class="bv-pf-cta__inner">

        <span class="bv-pf-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-pf-cta__title bv-font-viking-display" id="pf-cta-title">
            Want your project in this archive?
        </h2>

        <p class="bv-pf-cta__lead">
            Every project on this page started as a conversation. Yours can too —
            whether it's a vulnerability hunt, a web platform, a native mobile app,
            or something that doesn't have a name yet.
        </p>

        <div class="bv-pf-cta__actions">
            <a href="/contact" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Start a Project</span>
            </a>
            <a href="/services" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
                <span>See Services</span>
            </a>
        </div>

    </div>

</section>

</main>


<!-- ═══════════════════════════════════════════════════════════════════════
     LIGHTBOX MODAL — CASE STUDY VIEWER
     ═══════════════════════════════════════════════════════════════════════ -->
<div
    class="bv-pf-modal"
    id="bv-pf-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="bv-pf-modal-title"
    hidden
>
    <div class="bv-pf-modal__backdrop" data-pf-close aria-hidden="true"></div>

    <div class="bv-pf-modal__panel" role="document">

        <!-- Header bar -->
        <div class="bv-pf-modal__bar">
            <span class="bv-pf-modal__bar-title bv-font-mono">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span id="bv-pf-modal-bar-label">case_study.md</span>
            </span>
            <div class="bv-pf-modal__bar-controls">
                <button
                    type="button"
                    class="bv-pf-modal__nav-btn"
                    id="bv-pf-modal-prev"
                    aria-label="Previous project"
                >
                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                </button>
                <button
                    type="button"
                    class="bv-pf-modal__nav-btn"
                    id="bv-pf-modal-next"
                    aria-label="Next project"
                >
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </button>
                <button
                    type="button"
                    class="bv-pf-modal__close"
                    id="bv-pf-modal-close"
                    aria-label="Close case study"
                >
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Scrollable body -->
        <div class="bv-pf-modal__body" id="bv-pf-modal-body">

            <!-- Image -->
            <div class="bv-pf-modal__media">
                <img
                    src=""
                    alt=""
                    id="bv-pf-modal-image"
                    loading="lazy"
                    decoding="async"
                >
                <div class="bv-pf-modal__media-glow" aria-hidden="true"></div>
            </div>

            <!-- Content -->
            <div class="bv-pf-modal__content">

                <div class="bv-pf-modal__meta">
                    <span class="bv-pf-modal__year bv-font-mono" id="bv-pf-modal-year"></span>
                    <span class="bv-pf-modal__divider" aria-hidden="true">᛫</span>
                    <span class="bv-pf-modal__type bv-font-sci-label" id="bv-pf-modal-type"></span>
                    <span class="bv-pf-modal__status bv-font-sci-label" id="bv-pf-modal-status"></span>
                </div>

                <h2 class="bv-pf-modal__title bv-font-viking-display" id="bv-pf-modal-title"></h2>
                <p class="bv-pf-modal__subtitle bv-font-viking-body" id="bv-pf-modal-subtitle"></p>

                <p class="bv-pf-modal__description" id="bv-pf-modal-description"></p>

                <div class="bv-pf-modal__section">
                    <h3 class="bv-pf-modal__section-title bv-font-viking-heading">
                        <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                        Highlights
                    </h3>
                    <ul class="bv-pf-modal__highlights" id="bv-pf-modal-highlights"></ul>
                </div>

                <div class="bv-pf-modal__section">
                    <h3 class="bv-pf-modal__section-title bv-font-viking-heading">
                        <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                        Tech Stack
                    </h3>
                    <div class="bv-pf-modal__stack" id="bv-pf-modal-stack"></div>
                </div>

                <div class="bv-pf-modal__actions" id="bv-pf-modal-actions"></div>

            </div>

        </div>

    </div>
</div>
<!-- ═══ PORTFOLIO DATA ISLAND ═══ -->
<script type="application/json" id="bv-portfolio-data" nonce="<?= $csp_nonce ?>">
<?= json_encode(
    array_combine(
        array_column($projects, 'id'),
        $projects
    ),
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) ?>
</script>

<script nonce="<?= $csp_nonce ?>">
    // Hydrate the JSON island into a JS object the modal reads
    try {
        window.BVSEC_PORTFOLIO_DATA = JSON.parse(
            document.getElementById('bv-portfolio-data').textContent
        );
    } catch (e) {
        console.warn('[BVSec] Portfolio data island failed to parse:', e);
        window.BVSEC_PORTFOLIO_DATA = {};
    }
</script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>