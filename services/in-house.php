<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — In-House Projects
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      services/in-house.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'In-House Projects — Tools, Platforms & Research We Build For Ourselves',
    'description' => 'MyCitadel, Völva, SQLMap Tampers, and more. Privacy-first platforms, vulnerability scanners, and security research tools built by BVSec — some source-available, some public, some premium.',
    'canonical'   => '/services/in-house',
    'og_image'    => '/assets/images/og/in-house.png',
    'body_class'  => 'page-in-house',
];

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  FLAGSHIP PROJECTS
// ──────────────────────────────────────────────────────────────────────────
$projects = [
    [
        'id'          => 'mycitadel',
        'name'        => 'MyCitadel',
        'tagline'     => 'A privacy-first social platform. Zero ads. Zero tracking. Zero compromise.',
        'status'      => 'live',
        'status_label'=> 'LIVE',
        'icon'        => 'fa-solid fa-chess-rook',
        'year'        => '2024 – Present',
        'category'    => 'Platform · Privacy',
        'license'     => 'Source Available',
        'desc'        => 'The flagship project. MyCitadel is a social platform built on a simple, uncompromising principle: every social platform you use sells your attention — so we built one that doesn\'t. Custom PHP backend, bespoke REST API layer, self-hosted infrastructure, and a native Android client. No third-party trackers. No advertising SDKs. No data brokers. Source code published on GitHub for anyone to audit.',
        'highlights'  => [
            'Zero ads, zero trackers, zero data selling — by architecture, not by policy',
            'Custom-built PHP 8.2 + MySQL backend with no framework dependency',
            'Bespoke REST API layer powering web, mobile, and vendor integrations',
            'Argon2id password hashing, rotating sessions, full CSRF protection',
            'Public source on GitHub for independent security audit',
            'Active development — Android app in testing, iOS on roadmap',
        ],
        'components'  => [
            [
                'label' => 'Web Platform',
                'url'   => 'https://mycitadel.lol',
                'github'=> 'https://github.com/BeardedVikingTX/MyCitadel',
                'status'=> 'live',
                'note'  => 'Live web application',
            ],
            [
                'label' => 'API Server',
                'url'   => 'https://api.mycitadel.lol',
                'github'=> 'https://github.com/BeardedVikingTX/API_MyCitadel',
                'status'=> 'live',
                'note'  => 'Custom REST API layer',
            ],
            [
                'label' => 'Vendor System',
                'url'   => null,
                'github'=> 'https://github.com/BeardedVikingTX/Vendors_MyCitadel',
                'status'=> 'live',
                'note'  => 'Self-hosted vendor integrations',
            ],
            [
                'label' => 'Android App',
                'url'   => null,
                'github'=> 'https://github.com/BeardedVikingTX/MyCitadel_AndroidApp',
                'status'=> 'testing',
                'note'  => 'Currently in closed testing',
            ],
        ],
        'stack' => ['PHP 8.2', 'MySQL 8', 'REST API', 'Kotlin', 'Jetpack Compose', 'Vanilla JS', 'Nginx'],
        'featured' => true,
    ],

    [
        'id'          => 'volva',
        'name'        => 'Völva',
        'tagline'     => 'A modular, detection-first vulnerability scanner. Precision over noise.',
        'status'      => 'rebuilding',
        'status_label'=> 'REBUILDING',
        'icon'        => 'fa-solid fa-eye',
        'year'        => '2025 – Present',
        'category'    => 'Security Research · Tooling',
        'license'     => 'TBD (public release pending)',
        'desc'        => 'Völva is a precision instrument — not a fuzzer, not an exploit framework, not a crawler. She takes URLs you\'ve already discovered and tests exactly what you point her at, inside exactly the scope you authorize. Every finding is emitted only when multiple independent signals agree, and every finding ships with a copy-paste curl PoC, an evidence file, and a confidence rating. Feed her URLs from Burp, ZAP, waybackurls, or your own recon pipeline. She does not guess.',
        'highlights'  => [
            'Detection-first: every payload proves presence — never extracts data, never modifies state',
            'Multi-signal confidence: no finding emitted from a single weak signal',
            'Report-ready output: curl PoC + evidence file + confidence rating per finding',
            'Authorized-scope only: no crawling, no guessing, no scope expansion',
            'Built for HackerOne, Bugcrowd, YesWeHack, and self-hosted programs',
            'Public release pending — currently being rebuilt for open distribution',
        ],
        'components'  => [],
        'stack'       => ['Python 3', 'AsyncIO', 'Custom parsing', 'OOB detection', 'Browser-based DOM analysis'],
        'github'      => 'https://github.com/BeardedVikingTX/Volva',
        'github_note' => 'Private repo — public release pending rebuild',
        'warning'     => 'Völva is a research tool. You are the responsible party. Read the program policy before you point her at anything.',
    ],

    [
        'id'          => 'sqlmap-tampers',
        'name'        => 'SQLMap Tampers',
        'tagline'     => 'Advanced tamper scripts for modern WAF bypass. Built and battle-tested.',
        'status'      => 'live',
        'status_label'=> 'LIVE',
        'icon'        => 'fa-solid fa-mask',
        'year'        => '2025 – Present',
        'category'    => 'Security Research · Tooling',
        'license'     => 'MIT',
        'desc'        => 'A growing collection of advanced sqlmap tamper scripts designed to defeat modern WAF signature detection. Each script targets a specific obfuscation strategy — from fully-fledged JSON payload manipulation to random keyword fragmentation and deeply nested versioned comments. Used in real bug bounty engagements and published under MIT so the community can build on them.',
        'highlights'  => [
            'json_unicode_escape.py — Full JSON payload obfuscator (Unicode, hex, octal, case randomisation, comment fragmentation)',
            'math_exp_obfuscator.py — Replaces every integer with a random DBMS-aware mathematical expression from 100+ templates',
            'nested_versioned_comments.py — Wraps SQL keywords in deeply nested MySQL versioned comments, up to 5 levels deep',
            'random_chunk_splitter.py — Splits keywords into 2–4 fragments with inline or versioned comment separators',
            'MIT licensed — free to use, modify, and ship in your own tooling',
            'More tampers in active development',
        ],
        'components'  => [],
        'stack'       => ['Python 3', 'sqlmap API', 'WAF signature analysis'],
        'github'      => 'https://github.com/BeardedVikingTX/SQLMap_Tampers',
        'github_note' => 'Public repo — MIT licensed',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  FUTURE PROJECT CATEGORIES
// ──────────────────────────────────────────────────────────────────────────
$future_categories = [
    [
        'icon'  => 'fa-solid fa-users',
        'name'  => 'General Public Usage',
        'tagline' => 'Tools for everyday users.',
        'body'  => 'Applications and utilities designed for non-technical users who care about privacy, security, and not being treated as a product. Consumer-grade UX with enterprise-grade privacy underneath. No jargon, no dashboards, no complexity — just tools that respect you.',
        'examples' => [
            'Privacy-focused browser extensions',
            'Encrypted file sharing utilities',
            'Password hygiene tools',
            'Local-first note and document apps',
            'Personal security audit tools',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-building-shield',
        'name'  => 'Commercial Grade',
        'tagline' => 'Tools for companies.',
        'body'  => 'Enterprise-facing tools that help organizations grow while staying secure and compliant. Security infrastructure, compliance automation, and internal tooling that bridges the gap between developer productivity and corporate security requirements.',
        'examples' => [
            'Compliance automation tooling',
            'Internal security dashboards',
            'Audit log aggregation',
            'Secrets management utilities',
            'SIEM integrations',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-user-secret',
        'name'  => 'Bug Bounty Hunters',
        'tagline' => 'High-end tooling for the people who hunt.',
        'body'  => 'Python tools, Bash scripts, and workflow automation designed specifically for the bug bounty community. Built by a hunter who uses them in real engagements, published so the whole community gets better. No paywalls on the fundamentals, no gating behind Discord tiers.',
        'examples' => [
            'Recon automation pipelines',
            'Custom scanners and probes',
            'Payload generators and mutators',
            'Report generation tooling',
            'Scope management utilities',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-hammer',
        'name'  => 'True In-House',
        'tagline' => 'The tools we keep for ourselves.',
        'body'  => 'Internal-only tooling used for BVSec operations — customer-facing audit workflows, engagement management, and the private utilities that keep the forge running. Some may be released in time. Some stay internal. All of them are held to the same standard.',
        'examples' => [
            'Engagement management system',
            'Client communication workflows',
            'Report templating engine',
            'Internal audit dashboards',
            'Automated testing pipelines',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  PRINCIPLES
// ──────────────────────────────────────────────────────────────────────────
$principles = [
    [
        'num'   => 'I',
        'title' => 'We build what we need first.',
        'body'  => 'Every in-house project starts as a tool we actually wanted to use and couldn\'t find. MyCitadel exists because we wanted a social platform that doesn\'t sell users. Völva exists because we needed a scanner that reports findings instead of noise. Nothing here is built "for the market." It\'s built for us — then shared.',
    ],
    [
        'num'   => 'II',
        'title' => 'Source available. Always.',
        'body'  => 'Every project in this section is published on GitHub under a source-available license (or MIT where appropriate). You can read the code, audit the security, and verify the claims. The source is the receipt. If we say there\'s no tracking, you can prove it yourself.',
    ],
    [
        'num'   => 'III',
        'title' => 'Privacy is architecture, not policy.',
        'body'  => 'We don\'t "commit to not selling your data." We architect systems where selling your data is technically impossible. No telemetry SDKs. No third-party analytics. No ad networks. If a feature can\'t be built without harvesting user data, we don\'t build the feature.',
    ],
    [
        'num'   => 'IV',
        'title' => 'Small enough to stay honest.',
        'body'  => 'Every in-house project is built and maintained by one person. That means no committees deciding which privacy principle to sacrifice for growth, no boardroom pressure to add an ad SDK, and no venture capital demanding a 10x return at the expense of users. We build small and stay small — on purpose.',
    ],
];
?>

<main id="main-content" class="bv-main bv-in-house">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-ih-hero" id="ih-hero" aria-labelledby="ih-hero-title">

    <div class="bv-ih-hero__bg" aria-hidden="true">
        <div class="bv-ih-hero__vignette"></div>
        <div class="bv-ih-hero__aurora"></div>
        <div class="bv-ih-hero__grid"></div>
    </div>

    <div class="bv-ih-hero__runes bv-ih-hero__runes--left" aria-hidden="true">
        <span>ᚠ</span><span>ᛟ</span><span>ᚱ</span><span>ᚷ</span><span>ᛖ</span>
    </div>
    <div class="bv-ih-hero__runes bv-ih-hero__runes--right" aria-hidden="true">
        <span>ᛒ</span><span>ᚢ</span><span>ᛁ</span><span>ᛚ</span><span>ᛞ</span>
    </div>

    <div class="bv-ih-hero__inner">

        <span class="bv-section__eyebrow">᛫ Service Offering · In-House Projects ᛫</span>

        <h1 class="bv-ih-hero__title" id="ih-hero-title">
            <span class="bv-ih-hero__title-runes" aria-hidden="true">ᛒᚹᛊᛖᚲ</span>
            <span class="bv-ih-hero__title-line bv-ih-hero__title-line--viking">We Build For</span>
            <span class="bv-ih-hero__title-line bv-ih-hero__title-line--accent">
                <span class="bv-glitch" data-text="Ourselves First.">Ourselves First.</span>
            </span>
        </h1>

        <p class="bv-ih-hero__lead">
            Every tool on this page started as a problem we couldn't solve with
            existing software. So we built it ourselves. Then we published the
            source. MyCitadel, Völva, SQLMap Tampers — all forged in the same
            fire, all held to the same standard.
        </p>

        <div class="bv-ih-hero__actions">
            <a href="#projects" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span>See The Projects</span>
            </a>
            <a href="#future" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-forward" aria-hidden="true"></i>
                <span>What's Coming</span>
            </a>
        </div>

        <div class="bv-ih-hero__metrics" role="list">
            <div class="bv-ih-hero__metric" role="listitem">
                <span class="bv-ih-hero__metric-value" data-counter="3">0</span>
                <span class="bv-ih-hero__metric-label">Active Projects</span>
            </div>
            <div class="bv-ih-hero__metric" role="listitem">
                <span class="bv-ih-hero__metric-value" data-counter="4">0</span>
                <span class="bv-ih-hero__metric-label">Public Repos</span>
            </div>
            <div class="bv-ih-hero__metric" role="listitem">
                <span class="bv-ih-hero__metric-value" data-counter="100">0</span>
                <span class="bv-ih-hero__metric-label">% Source Available</span>
            </div>
            <div class="bv-ih-hero__metric" role="listitem">
                <span class="bv-ih-hero__metric-value" data-counter="0">0</span>
                <span class="bv-ih-hero__metric-label">Trackers Shipped</span>
            </div>
        </div>

    </div>

    <div class="bv-ih-hero__scroll" aria-hidden="true">
        <span class="bv-ih-hero__scroll-rune">ᛝ</span>
        <span class="bv-ih-hero__scroll-text">OPEN THE VAULT</span>
        <span class="bv-ih-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // FLAGSHIP PROJECTS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-ih-projects" id="projects" aria-labelledby="ih-projects-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // THE FLAGSHIPS</span>
        <h2 class="bv-section__title" id="ih-projects-title">
            Three projects. <span class="bv-text-gradient">One standard.</span>
        </h2>
        <p class="bv-section__lead">
            Each project in this section is a real, working system — deployed,
            maintained, and used in production. Source is published where
            possible. Where it isn't yet, we tell you why.
        </p>
    </div>

    <div class="bv-ih-projects__stack">

        <?php foreach ($projects as $p): ?>

            <?php if (!empty($p['featured'])): ?>

                <!-- ══════ FEATURED PROJECT — MYCITADEL ══════ -->
                <article class="bv-ih-featured bv-card" id="project-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="bv-ih-featured__header">

                        <div class="bv-ih-featured__brand">
                            <div class="bv-ih-featured__icon" aria-hidden="true">
                                <i class="<?= htmlspecialchars($p['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                            </div>
                            <div>
                                <div class="bv-ih-featured__meta bv-font-mono">
                                    <span><?= htmlspecialchars($p['year'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="bv-ih-featured__divider" aria-hidden="true">᛫</span>
                                    <span><?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <h3 class="bv-ih-featured__name bv-font-viking-display">
                                    <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>
                            </div>
                        </div>

                        <span class="bv-ih-featured__status bv-ih-featured__status--live bv-font-sci-label">
                            <span class="bv-ih-featured__status-dot"></span>
                            <?= htmlspecialchars($p['status_label'], ENT_QUOTES, 'UTF-8') ?>
                        </span>

                    </div>

                    <p class="bv-ih-featured__tagline bv-font-viking-body">
                        <?= htmlspecialchars($p['tagline'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p class="bv-ih-featured__desc">
                        <?= htmlspecialchars($p['desc'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <!-- Component grid -->
                    <div class="bv-ih-featured__components">
                        <h4 class="bv-ih-featured__components-title bv-font-sci-label">
                            <i class="fa-solid fa-cubes" aria-hidden="true"></i>
                            Components
                        </h4>
                        <div class="bv-ih-featured__component-grid">
                            <?php foreach ($p['components'] as $c): ?>
                                <div class="bv-ih-component bv-ih-component--<?= htmlspecialchars($c['status'], ENT_QUOTES, 'UTF-8') ?>">
                                    <div class="bv-ih-component__header">
                                        <span class="bv-ih-component__label bv-font-viking-heading">
                                            <?= htmlspecialchars($c['label'], ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                        <span class="bv-ih-component__status bv-font-mono">
                                            <?= $c['status'] === 'live' ? '● LIVE' : '◐ TESTING' ?>
                                        </span>
                                    </div>
                                    <p class="bv-ih-component__note">
                                        <?= htmlspecialchars($c['note'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                    <div class="bv-ih-component__links">
                                        <?php if (!empty($c['url'])): ?>
                                            <a href="<?= htmlspecialchars($c['url'], ENT_QUOTES, 'UTF-8') ?>"
                                               class="bv-ih-component__link bv-ih-component__link--primary"
                                               target="_blank" rel="noopener noreferrer">
                                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                                <span>Visit</span>
                                            </a>
                                        <?php else: ?>
                                            <span class="bv-ih-component__link bv-ih-component__link--disabled bv-font-mono">
                                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                                <span>Coming Soon</span>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($c['github'])): ?>
                                            <a href="<?= htmlspecialchars($c['github'], ENT_QUOTES, 'UTF-8') ?>"
                                               class="bv-ih-component__link"
                                               target="_blank" rel="noopener noreferrer">
                                                <i class="fa-brands fa-github" aria-hidden="true"></i>
                                                <span>Source</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Highlights -->
                    <div class="bv-ih-featured__section">
                        <h4 class="bv-ih-featured__section-title bv-font-sci-label">
                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            Highlights
                        </h4>
                        <ul class="bv-ih-featured__highlights" role="list">
                            <?php foreach ($p['highlights'] as $h): ?>
                                <li><?= htmlspecialchars($h, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Stack -->
                    <div class="bv-ih-featured__stack">
                        <span class="bv-ih-featured__stack-label bv-font-sci-label">STACK</span>
                        <div class="bv-ih-featured__stack-items">
                            <?php foreach ($p['stack'] as $tech): ?>
                                <span class="bv-ih-featured__tech bv-font-mono">
                                    <?= htmlspecialchars($tech, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </article>

            <?php else: ?>

                <!-- ══════ STANDARD PROJECT ══════ -->
                <article class="bv-ih-project bv-card" id="project-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="bv-ih-project__header">
                        <div class="bv-ih-project__brand">
                            <div class="bv-ih-project__icon" aria-hidden="true">
                                <i class="<?= htmlspecialchars($p['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                            </div>
                            <div>
                                <div class="bv-ih-project__meta bv-font-mono">
                                    <span><?= htmlspecialchars($p['year'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="bv-ih-project__divider" aria-hidden="true">᛫</span>
                                    <span><?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <h3 class="bv-ih-project__name bv-font-viking-display">
                                    <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>
                            </div>
                        </div>

                        <span class="bv-ih-project__status bv-ih-project__status--<?= htmlspecialchars($p['status'], ENT_QUOTES, 'UTF-8') ?> bv-font-sci-label">
                            <span class="bv-ih-project__status-dot"></span>
                            <?= htmlspecialchars($p['status_label'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>

                    <p class="bv-ih-project__tagline bv-font-viking-body">
                        <?= htmlspecialchars($p['tagline'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p class="bv-ih-project__desc">
                        <?= htmlspecialchars($p['desc'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <div class="bv-ih-project__section">
                        <h4 class="bv-ih-project__section-title bv-font-sci-label">
                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            Highlights
                        </h4>
                        <ul class="bv-ih-project__highlights" role="list">
                            <?php foreach ($p['highlights'] as $h): ?>
                                <li><?= htmlspecialchars($h, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <?php if (!empty($p['warning'])): ?>
                        <div class="bv-ih-project__warning">
                            <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                            <p><?= htmlspecialchars($p['warning'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="bv-ih-project__footer">
                        <div class="bv-ih-project__stack">
                            <span class="bv-ih-project__stack-label bv-font-sci-label">STACK</span>
                            <div class="bv-ih-project__stack-items">
                                <?php foreach ($p['stack'] as $tech): ?>
                                    <span class="bv-ih-project__tech bv-font-mono">
                                        <?= htmlspecialchars($tech, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if (!empty($p['github'])): ?>
                            <div class="bv-ih-project__github">
                                <a href="<?= htmlspecialchars($p['github'], ENT_QUOTES, 'UTF-8') ?>"
                                   class="bv-ih-project__github-link"
                                   target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-github" aria-hidden="true"></i>
                                    <span>View on GitHub</span>
                                </a>
                                <?php if (!empty($p['github_note'])): ?>
                                    <span class="bv-ih-project__github-note bv-font-mono">
                                        <?= htmlspecialchars($p['github_note'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </article>

            <?php endif; ?>

        <?php endforeach; ?>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // FUTURE PROJECT CATEGORIES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-ih-future" id="future" aria-labelledby="ih-future-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // WHAT'S COMING NEXT</span>
        <h2 class="bv-section__title" id="ih-future-title">
            Four battle lines. <span class="bv-text-gradient">More tools incoming.</span>
        </h2>
        <p class="bv-section__lead">
            The three projects above are live. These four categories are where
            the next round of in-house work is headed — each one defined by who
            it serves and why we're building it. No promises on dates. Real
            priorities, real direction.
        </p>
    </div>

    <div class="bv-ih-future__grid">
        <?php foreach ($future_categories as $cat): ?>
            <article class="bv-ih-future-cat bv-card">
                <div class="bv-ih-future-cat__icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($cat['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <h3 class="bv-ih-future-cat__name bv-font-viking-heading">
                    <?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="bv-ih-future-cat__tagline">
                    <?= htmlspecialchars($cat['tagline'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="bv-ih-future-cat__body">
                    <?= htmlspecialchars($cat['body'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <div class="bv-ih-future-cat__examples">
                    <span class="bv-ih-future-cat__examples-label bv-font-sci-label">Examples</span>
                    <ul class="bv-ih-future-cat__examples-list" role="list">
                        <?php foreach ($cat['examples'] as $ex): ?>
                            <li><?= htmlspecialchars($ex, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // PRINCIPLES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-ih-principles" id="principles" aria-labelledby="ih-principles-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // THE PRINCIPLES</span>
        <h2 class="bv-section__title" id="ih-principles-title">
            Four commitments. <span class="bv-text-gradient">Zero exceptions.</span>
        </h2>
        <p class="bv-section__lead">
            Every in-house project — shipped or planned — is governed by the
            same four principles. They're not marketing copy. They're the
            filters every idea has to pass before it gets built.
        </p>
    </div>

    <div class="bv-ih-principles__grid">
        <?php foreach ($principles as $p): ?>
            <article class="bv-ih-principle bv-card">
                <span class="bv-ih-principle__number bv-font-sci-display"><?= htmlspecialchars($p['num'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="bv-ih-principle__body">
                    <h3 class="bv-ih-principle__title bv-font-viking-heading">
                        <?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <p><?= htmlspecialchars($p['body'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-ih-cta" aria-labelledby="ih-cta-title">

    <div class="bv-ih-cta__inner">

        <span class="bv-ih-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-ih-cta__title bv-font-viking-display" id="ih-cta-title">
            Want a tool like this built for your team?
        </h2>

        <p class="bv-ih-cta__lead">
            Everything on this page is proof of concept. If any of it looks like
            the kind of thing your organization needs — a privacy-first platform,
            a detection-focused scanner, a custom security tool — reach out. The
            same discipline that built these can be pointed at your problem.
        </p>

        <div class="bv-ih-cta__actions">
            <a href="/contact?engagement=scoping" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Start a Conversation</span>
            </a>
            <a href="/portfolio" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span>See Client Work</span>
            </a>
        </div>

        <div class="bv-ih-cta__meta">
            <span class="bv-ih-cta__meta-item">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>PGP: security@beardedviking.org</span>
            </span>
            <span class="bv-ih-cta__meta-item">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <span>Response within 72 hours</span>
            </span>
            <span class="bv-ih-cta__meta-item">
                <i class="fa-brands fa-github" aria-hidden="true"></i>
                <span>github.com/BeardedVikingTX</span>
            </span>
        </div>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>