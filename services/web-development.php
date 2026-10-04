<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Custom Web Development Services
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      services/web-development.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Custom Web Development — Security-First Applications & APIs',
    'description' => 'Security-hardened custom web applications, APIs, and platforms built by BeardedVikingTX. PHP 8.2, Ruby on Rails, MySQL. OWASP 2026 baseline on every project. 2–6 month turnaround.',
    'canonical'   => '/services/web-development',
    'og_image'    => '/assets/images/og/web-development.png',
    'body_class'  => 'page-web-development',
];

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  SERVICE CATEGORIES — what we build
// ──────────────────────────────────────────────────────────────────────────
$services = [
    [
        'icon'    => 'fa-solid fa-window-restore',
        'name'    => 'Custom Web Applications',
        'tagline' => 'SaaS platforms, portals, dashboards.',
        'body'    => 'Full-stack applications built from scratch — no page builders, no bloated CMS frameworks, no security-by-obscurity. Bespoke architecture that fits the problem instead of the template.',
        'items'   => [
            'SaaS platforms and subscription products',
            'Customer portals and self-service dashboards',
            'Internal tools and admin interfaces',
            'Multi-tenant architectures',
            'Real-time features (WebSockets, SSE)',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-plug-circle-bolt',
        'name'    => 'API Design & Development',
        'tagline' => 'REST, GraphQL, and everything between.',
        'body'    => 'Clean, documented, versioned APIs designed for consumers — not just for the frontend that happens to ship first. Every endpoint is authenticated, rate-limited, and tested against the OWASP API Top 10.',
        'items'   => [
            'RESTful API architecture and implementation',
            'GraphQL schemas with proper depth limiting',
            'Webhook systems with retry and signing',
            'OpenAPI / Swagger documentation',
            'Third-party API integrations',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-database',
        'name'    => 'Database Architecture',
        'tagline' => 'Schema design that scales.',
        'body'    => 'Relational design that survives the first year of production traffic. Normalized when it should be, denormalized when performance demands it, indexed with intent — never guessed at.',
        'items'   => [
            'Schema design and normalization',
            'Query optimization and index strategy',
            'Migration planning with zero-downtime strategy',
            'Backup and disaster recovery configuration',
            'Read-replica and sharding when needed',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-user-shield',
        'name'    => 'Authentication & Authorization',
        'tagline' => 'The gatekeeper is the hard part.',
        'body'    => 'Hand-rolled auth systems that actually follow best practices — Argon2id hashing, rotating session tokens, MFA support, and role-based access control that maps to how your organization actually works.',
        'items'   => [
            'Custom auth with Argon2id and rotating tokens',
            'OAuth2 / OIDC integration (Google, GitHub, etc.)',
            'Multi-factor authentication (TOTP, WebAuthn)',
            'Role-based and attribute-based access control',
            'Session management and CSRF protection',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-cloud-arrow-up',
        'name'    => 'Deployment & Infrastructure',
        'tagline' => 'Ship it, monitor it, sleep well.',
        'body'    => 'Zero-downtime deployment pipelines with rollback capability, structured logging, health checks, and alerting from day one. You should know your app is broken before your customers do.',
        'items'   => [
            'Zero-downtime deployment with rollback',
            'Docker containerization where appropriate',
            'CI/CD pipeline setup (GitHub Actions, etc.)',
            'Monitoring, structured logging, and alerting',
            'SSL/TLS configuration and certificate automation',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-gauge-high',
        'name'    => 'Performance Optimization',
        'tagline' => 'Fast is a feature.',
        'body'    => 'Audits and rewrites of slow applications. Database query analysis, caching strategy, CDN configuration, asset optimization — every millisecond you save is a conversion you keep.',
        'items'   => [
            'Core Web Vitals optimization',
            'Database query analysis and tuning',
            'Caching strategy (Redis, Memcached, CDN)',
            'Asset bundling and minification',
            'Lazy loading and code splitting',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  THE FORGE PROCESS — 5 phases
// ──────────────────────────────────────────────────────────────────────────
$phases = [
    [
        'num'   => '01',
        'icon'  => 'fa-solid fa-map',
        'title' => 'Reconnaissance & Threat Modeling',
        'body'  => 'Before a single line of code is written, we define what we\'re building, who will use it, and what we\'re defending against. The threat model drives the architecture — not the other way around.',
        'items' => [
            'Requirements gathering and user story mapping',
            'Threat modeling per OWASP and STRIDE',
            'Data classification and compliance requirements',
            'Third-party integration inventory',
            'Success metrics and acceptance criteria',
        ],
    ],
    [
        'num'   => '02',
        'icon'  => 'fa-solid fa-drafting-compass',
        'title' => 'Architecture & Design',
        'body'  => 'System architecture, database schema, API contract, and UI/UX flows designed in parallel — because they inform each other. Security decisions made here cascade through everything that follows.',
        'items' => [
            'System architecture diagram and documentation',
            'Database schema with migration strategy',
            'API contract (OpenAPI spec)',
            'UI/UX wireframes with accessibility annotations',
            'Security control selection and implementation plan',
        ],
    ],
    [
        'num'   => '03',
        'icon'  => 'fa-solid fa-hammer',
        'title' => 'Forging & Implementation',
        'body'  => 'Iterative, testable, shippable increments. Every commit is reviewed against the security baseline. Every feature is demoed early. We don\'t do "big bang" releases — we build in the open and adjust before the code becomes expensive to change.',
        'items' => [
            'Feature-branch workflow with mandatory review',
            'Automated security scanning on every commit',
            'Unit, integration, and E2E test coverage targets',
            'Continuous deployment to staging environment',
            'Weekly demo cadence so you always know where we are',
        ],
    ],
    [
        'num'   => '04',
        'icon'  => 'fa-solid fa-crosshairs',
        'title' => 'Adversarial Testing',
        'body'  => 'Before anything ships, it gets attacked. By me. The same playbook I use on bug bounty engagements: injection, auth bypass, IDOR, SSRF, business logic abuse, race conditions. If I can break it, we fix it. If I can\'t, you\'re ready.',
        'items' => [
            'Manual penetration testing of all attack surfaces',
            'Automated DAST/SAST tooling for coverage',
            'Business logic and race condition testing',
            'Authentication and authorization bypass attempts',
            'Performance and load testing under realistic conditions',
        ],
    ],
    [
        'num'   => '05',
        'icon'  => 'fa-solid fa-rocket',
        'title' => 'Deployment & Handover',
        'body'  => 'Deployment to your environment or ours. Monitoring, logging, and alerting from day one. Documentation, architecture diagrams, and an encrypted credential handover. Then 90 days of post-launch support because launch day is when the real bugs reveal themselves.',
        'items' => [
            'Zero-downtime deployment with rollback capability',
            'Monitoring, logging, and alerting configuration',
            'Complete documentation and architecture diagrams',
            'Encrypted credential handover',
            '90-day post-launch support included',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  SECURITY BASELINE — what every project ships with
// ──────────────────────────────────────────────────────────────────────────
$baseline = [
    [
        'icon'  => 'fa-solid fa-shield-halved',
        'title' => 'OWASP 2026 Headers',
        'desc'  => 'CSP with nonces, HSTS with preload, COOP/CORP/COEP, Permissions-Policy lockdown, and the full modern header suite.',
    ],
    [
        'icon'  => 'fa-solid fa-syringe',
        'title' => 'Prepared Statements',
        'desc'  => 'Every database query. No exceptions. String concatenation never touches SQL. ORMs configured with parameterized queries by default.',
    ],
    [
        'icon'  => 'fa-solid fa-key',
        'title' => 'Argon2id Hashing',
        'desc'  => 'Modern password hashing. Rotating session tokens. Rate-limited authentication endpoints. Lockout policies that actually work.',
    ],
    [
        'icon'  => 'fa-solid fa-user-lock',
        'title' => 'CSRF Protection',
        'desc'  => 'Token-based CSRF on every state-changing request. SameSite cookies as defense-in-depth. No exceptions for "internal only" endpoints.',
    ],
    [
        'icon'  => 'fa-solid fa-file-shield',
        'title' => 'Input Validation',
        'desc'  => 'Server-side validation is authoritative. Client-side is UX, not security. Every input validated against a strict allowlist where possible.',
    ],
    [
        'icon'  => 'fa-solid fa-lock',
        'title' => 'Encrypted Secrets',
        'desc'  => 'API keys, database credentials, and secrets never live in code. Environment variables or a proper secrets manager — with rotation policy.',
    ],
    [
        'icon'  => 'fa-solid fa-list-check',
        'title' => 'Structured Logging',
        'desc'  => 'Every authentication event, authorization failure, and suspicious action logged with context. No sensitive data in logs, ever.',
    ],
    [
        'icon'  => 'fa-solid fa-bell',
        'title' => 'Monitoring & Alerts',
        'desc'  => 'Health checks, error tracking, and alerting from day one. You know about problems before your users do — that\'s the whole point.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  TECH STACK
// ──────────────────────────────────────────────────────────────────────────
$stack = [
    'languages' => [
        'label' => 'Languages',
        'items' => ['PHP 8.2+', 'Ruby on Rails', 'Python 3', 'JavaScript (ES2024+)', 'TypeScript', 'SQL'],
    ],
    'frontend' => [
        'label' => 'Frontend',
        'items' => ['HTML5', 'CSS3', 'Tailwind CSS', 'Bootstrap', 'Vanilla JS', 'Alpine.js', 'Vite'],
    ],
    'backend' => [
        'label' => 'Backend',
        'items' => ['PHP-FPM', 'Rails', 'REST APIs', 'GraphQL', 'WebSockets', 'Redis', 'Sidekiq'],
    ],
    'database' => [
        'label' => 'Database',
        'items' => ['MySQL 8', 'MariaDB', 'PostgreSQL', 'Redis', 'SQLite (embedded)', 'pgvector'],
    ],
    'hosting' => [
        'label' => 'Hosting',
        'items' => ['DigitalOcean', 'AWS S3', 'Google Cloud', 'Namecheap', 'GitHub Pages', 'Heroku', 'Self-hosted VPS'],
    ],
    'tooling' => [
        'label' => 'Tooling',
        'items' => ['Git', 'Composer', 'npm', 'Docker', 'GitHub Actions', 'Nginx', 'Let\'s Encrypt'],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  ENGAGEMENT MODELS
// ──────────────────────────────────────────────────────────────────────────
$engagements = [
    [
        'id'      => 'starter',
        'icon'    => 'fa-solid fa-globe',
        'name'    => 'Starter Website',
        'tagline' => 'Informational site. Fast turnaround.',
        'price'   => 'From $500',
        'desc'    => 'A clean, professional informational website for new businesses, personal brands, or anyone who wants a low-risk way to test-drive BVSec before committing to a larger project. Standard pages — Home, About, Contact, and a photo gallery — delivered in 3–5 business days. Security baseline included, fully mobile responsive, production-ready out of the box.',
        'includes' => [
            'Home, About, Contact, and photo gallery pages',
            'Mobile-responsive design across all devices',
            'Security-hardened baseline (OWASP headers, HTTPS)',
            'Basic on-page SEO configuration',
            'Delivery within 3–5 business days',
        ],
        'best_for' => 'New businesses, personal brands, or a low-risk way to test BVSec',
    ],
    [
        'id'      => 'greenfield',
        'icon'    => 'fa-solid fa-seedling',
        'name'    => 'Greenfield Build',
        'tagline' => 'New application from scratch.',
        'price'   => 'From $15,000',
        'desc'    => 'Full-cycle development of a new web application, API, or platform. Requirements through deployment, with 90 days of post-launch support included. Timeline: 2–6 months depending on scope.',
        'includes' => [
            'Scoping workshop and architecture design',
            'Full-stack implementation with weekly demos',
            'Adversarial testing before launch',
            'Zero-downtime deployment setup',
            '90-day post-launch support',
        ],
        'best_for' => 'Startups, new products, internal tools that need to ship',
        'featured' => true,
    ],
    [
        'id'      => 'rescue',
        'icon'    => 'fa-solid fa-screwdriver-wrench',
        'name'    => 'Rescue Mission',
        'tagline' => 'Fix the app someone else broke.',
        'price'   => 'From $5,000',
        'desc'    => 'Inherited codebase that\'s slow, insecure, or undocumented? I\'ll audit it, map the architecture, fix the critical issues, and leave you with documentation you can actually maintain. Optionally take over ongoing development.',
        'includes' => [
            'Full code and architecture audit',
            'Security vulnerability assessment',
            'Priority fix list with effort estimates',
            'Documentation of existing behavior',
            'Optional ongoing maintenance retainer',
        ],
        'best_for' => 'Orphaned projects, post-acquisition codebases, legacy modernization',
    ],
    [
        'id'      => 'retainer',
        'icon'    => 'fa-solid fa-rotate',
        'name'    => 'Development Retainer',
        'tagline' => 'Your standing engineering capacity.',
        'price'   => 'From $3,500/mo',
        'desc'    => 'Ongoing development partnership for teams that ship continuously. New features, bug fixes, performance work, and security review — all under one monthly retainer. Priority scheduling, no surprise invoices.',
        'includes' => [
            'Monthly hours allocation for new work',
            'Priority bug fix and security response',
            'Continuous security review of new features',
            'Monthly written progress summary',
            'Direct Slack/email channel',
        ],
        'best_for' => 'SaaS products, funded startups, agencies needing overflow',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  FAQ
// ──────────────────────────────────────────────────────────────────────────
$faq = [
    [
        'q' => 'How long does a typical project take?',
        'a' => 'A scoped web application is typically 2–6 months from kickoff to launch. Simple marketing sites with custom functionality run 4–8 weeks. Complex multi-surface platforms (web + API + mobile + admin) can run 6–12 months. You get a firm timeline during scoping, and I under-promise on purpose — the number in the proposal is the number I intend to hit.',
    ],
    [
        'q' => 'What if the scope changes mid-project?',
        'a' => 'Scope changes are normal and expected. Every engagement includes a written change-order process: you describe the change, I estimate the cost and timeline impact, you approve, and we proceed. Nothing gets built outside the approved scope. No surprise invoices.',
    ],
    [
        'q' => 'Do you work with existing codebases?',
        'a' => 'Yes — this is what the "Rescue Mission" engagement is for. I audit the codebase, map the architecture, and either fix it in place or modernize the critical paths. If the codebase is beyond saving, I\'ll tell you that honestly and quote a greenfield rebuild instead.',
    ],
    [
        'q' => 'Who owns the code after deployment?',
        'a' => 'You do. Full copyright assignment on delivery — every line of custom code, every design decision, every piece of documentation. I retain the right to use the project as a portfolio piece unless you request otherwise, and I never reuse client-specific logic on other projects.',
    ],
    [
        'q' => 'What about hosting and infrastructure?',
        'a' => 'I\'ll deploy to whatever infrastructure you prefer — your existing AWS account, DigitalOcean, Google Cloud, or a self-hosted VPS. If you don\'t have a preference, I\'ll recommend the right fit for your scale and budget. I don\'t resell hosting and don\'t take commissions — you pay the provider directly.',
    ],
    [
        'q' => 'Do you offer ongoing maintenance?',
        'a' => 'Every project includes 90 days of post-launch support at no additional cost. After that, ongoing maintenance is available under a retainer. Maintenance includes security patches, dependency updates, bug fixes, and a monthly health report. You\'re never left hanging after launch.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  WHY SECURITY FIRST
// ──────────────────────────────────────────────────────────────────────────
$principles = [
    [
        'num'   => 'I',
        'title' => 'Security is not a feature. It\'s the foundation.',
        'body'  => 'You don\'t add authentication at the end. You don\'t "harden later." You don\'t decide whether to add rate limiting based on budget. Every project ships with the same security baseline because those aren\'t optional features — they\'re the floor you build the house on.',
    ],
    [
        'num'   => 'II',
        'title' => 'Written by the person you hired.',
        'body'  => 'No offshore handoffs. No junior developers "supporting" the senior team. No account manager between you and the code. The same person who designs the architecture writes the implementation, tests the security, and shows up on launch day.',
    ],
    [
        'num'   => 'III',
        'title' => 'Under-promise. Over-deliver. Every time.',
        'body'  => 'I\'d rather quote you six months and ship in five than quote four and apologize on day 28. Clients don\'t hire me for the lowest bid. They hire me because the timeline holds, the budget holds, and the thing actually works when it launches.',
    ],
    [
        'num'   => 'IV',
        'title' => 'You own everything. Forever.',
        'body'  => 'Full copyright assignment on delivery. No proprietary frameworks to license. No vendor lock-in to a service you can\'t migrate away from. The code is yours, the documentation is yours, and the deployment is on infrastructure you control.',
    ],
];
?>

<main id="main-content" class="bv-main bv-web-dev">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-wd-hero" id="wd-hero" aria-labelledby="wd-hero-title">

    <div class="bv-wd-hero__bg" aria-hidden="true">
        <div class="bv-wd-hero__vignette"></div>
        <div class="bv-wd-hero__aurora"></div>
        <div class="bv-wd-hero__grid"></div>
    </div>

    <div class="bv-wd-hero__runes bv-wd-hero__runes--left" aria-hidden="true">
        <span>ᛒ</span><span>ᚢ</span><span>ᛁ</span><span>ᛚ</span><span>ᛞ</span>
    </div>
    <div class="bv-wd-hero__runes bv-wd-hero__runes--right" aria-hidden="true">
        <span>ᚠ</span><span>ᛟ</span><span>ᚱ</span><span>ᚷ</span><span>ᛖ</span>
    </div>

    <div class="bv-wd-hero__inner">

        <span class="bv-section__eyebrow">᛫ Service Offering · Custom Web Development ᛫</span>

        <h1 class="bv-wd-hero__title" id="wd-hero-title">
            <span class="bv-wd-hero__title-runes" aria-hidden="true">ᚠᛟᚱᚷᛖ</span>
            <span class="bv-wd-hero__title-line bv-wd-hero__title-line--viking">Fortresses.</span>
            <span class="bv-wd-hero__title-line bv-wd-hero__title-line--accent">
                <span class="bv-glitch" data-text="Not Websites.">Not Websites.</span>
            </span>
        </h1>

        <p class="bv-wd-hero__lead">
            Most web projects ship insecure because security is bolted on at the end.
            We do the opposite: every project starts with a threat model, every line
            of code assumes an attacker is reading it, and every deployment ships with
            the OWASP 2026 baseline from commit one.
        </p>

        <div class="bv-wd-hero__actions">
            <a href="#engagement-models" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-file-contract" aria-hidden="true"></i>
                <span>See Engagement Models</span>
            </a>
            <a href="#forge-process" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-hammer" aria-hidden="true"></i>
                <span>The Forge Process</span>
            </a>
        </div>

        <div class="bv-wd-hero__metrics" role="list">
            <div class="bv-wd-hero__metric" role="listitem">
                <span class="bv-wd-hero__metric-value" data-counter="8">0</span>
                <span class="bv-wd-hero__metric-label">Years Building</span>
            </div>
            <div class="bv-wd-hero__metric" role="listitem">
                <span class="bv-wd-hero__metric-value" data-counter="47">0</span>
                <span class="bv-wd-hero__metric-label">Projects Shipped</span>
            </div>
            <div class="bv-wd-hero__metric" role="listitem">
                <span class="bv-wd-hero__metric-value" data-counter="89">0</span>
                <span class="bv-wd-hero__metric-label">% Scope Accuracy</span>
            </div>
            <div class="bv-wd-hero__metric" role="listitem">
                <span class="bv-wd-hero__metric-value" data-counter="90">0</span>
                <span class="bv-wd-hero__metric-label">Day Support</span>
            </div>
        </div>

    </div>

    <div class="bv-wd-hero__scroll" aria-hidden="true">
        <span class="bv-wd-hero__scroll-rune">ᛝ</span>
        <span class="bv-wd-hero__scroll-text">SCROLL FOR INTEL</span>
        <span class="bv-wd-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // THE PHILOSOPHY
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-philosophy" id="philosophy" aria-labelledby="wd-philosophy-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // THE PHILOSOPHY</span>
        <h2 class="bv-section__title" id="wd-philosophy-title">
            Four principles. <span class="bv-text-gradient">Zero compromise.</span>
        </h2>
        <p class="bv-section__lead">
            Most agencies have a "values" page that nobody reads. Here are four
            commitments that shape every decision on every project — including the
            ones that cost me money to keep.
        </p>
    </div>

    <div class="bv-wd-philosophy__grid">
        <?php foreach ($principles as $p): ?>
            <article class="bv-wd-philosophy__principle bv-card">
                <span class="bv-wd-philosophy__number bv-font-sci-display"><?= htmlspecialchars($p['num'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="bv-wd-philosophy__body">
                    <h3 class="bv-wd-philosophy__title"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p><?= htmlspecialchars($p['body'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // WHAT WE BUILD
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-services" id="what-we-build" aria-labelledby="wd-services-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // WHAT WE BUILD</span>
        <h2 class="bv-section__title" id="wd-services-title">
            Six disciplines. <span class="bv-text-gradient">One operator.</span>
        </h2>
        <p class="bv-section__lead">
            From a single API endpoint to a multi-tenant SaaS platform — every
            discipline in the stack, executed by the same person. No handoffs,
            no learning curve, no "let me ask the backend team."
        </p>
    </div>

    <div class="bv-wd-services__grid">
        <?php foreach ($services as $s): ?>
            <article class="bv-wd-service bv-card">
                <div class="bv-wd-service__icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($s['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <div class="bv-wd-service__header">
                    <h3 class="bv-wd-service__name"><?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="bv-wd-service__tagline"><?= htmlspecialchars($s['tagline'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <p class="bv-wd-service__body"><?= htmlspecialchars($s['body'], ENT_QUOTES, 'UTF-8') ?></p>
                <ul class="bv-wd-service__list" role="list">
                    <?php foreach ($s['items'] as $item): ?>
                        <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // THE FORGE PROCESS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-process" id="forge-process" aria-labelledby="wd-process-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // THE FORGE PROCESS</span>
        <h2 class="bv-section__title" id="wd-process-title">
            Five phases. <span class="bv-text-gradient">Zero shortcuts.</span>
        </h2>
        <p class="bv-section__lead">
            Every project — a two-week API endpoint or a nine-month platform —
            moves through the same disciplined pipeline. No phase skipped. No
            phase rushed. This is how fortresses are built.
        </p>
    </div>

    <ol class="bv-wd-process__phases" role="list">
        <?php foreach ($phases as $phase): ?>
            <li class="bv-wd-process__phase">
                <div class="bv-wd-process__phase-num bv-font-sci-display">
                    <?= htmlspecialchars($phase['num'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="bv-wd-process__phase-body bv-card">
                    <h3 class="bv-wd-process__phase-title">
                        <i class="<?= htmlspecialchars($phase['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                        <span><?= htmlspecialchars($phase['title'], ENT_QUOTES, 'UTF-8') ?></span>
                    </h3>
                    <p class="bv-wd-process__phase-desc"><?= htmlspecialchars($phase['body'], ENT_QUOTES, 'UTF-8') ?></p>
                    <ul class="bv-wd-process__phase-list">
                        <?php foreach ($phase['items'] as $item): ?>
                            <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     04 // SECURITY BASELINE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-baseline" id="security-baseline" aria-labelledby="wd-baseline-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // THE SECURITY BASELINE</span>
        <h2 class="bv-section__title" id="wd-baseline-title">
            What every project ships with. <span class="bv-text-gradient">No exceptions.</span>
        </h2>
        <p class="bv-section__lead">
            These aren't upsells. They aren't "premium add-ons." They aren't
            features you can negotiate away. This is the floor — the minimum
            every BVSec project ships with from day one.
        </p>
    </div>

    <div class="bv-wd-baseline__grid">
        <?php foreach ($baseline as $b): ?>
            <article class="bv-wd-baseline__item bv-card">
                <div class="bv-wd-baseline__icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($b['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <h3 class="bv-wd-baseline__title"><?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p class="bv-wd-baseline__desc"><?= htmlspecialchars($b['desc'], ENT_QUOTES, 'UTF-8') ?></p>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     05 // TECH STACK
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-stack" id="tech-stack" aria-labelledby="wd-stack-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">05 // THE ARSENAL</span>
        <h2 class="bv-section__title" id="wd-stack-title">
            Languages we speak. <span class="bv-text-gradient">Platforms we build on.</span>
        </h2>
        <p class="bv-section__lead">
            Technology is a tool, not a religion. I choose the stack that fits
            the problem — not the one that happens to be trending on Hacker News.
            Here's what I actually ship with.
        </p>
    </div>

    <div class="bv-wd-stack__grid">
        <?php foreach ($stack as $key => $group): ?>
            <div class="bv-wd-stack__column bv-card">
                <div class="bv-wd-stack__column-header">
                    <span class="bv-wd-stack__column-label bv-font-sci-label">
                        <?= htmlspecialchars($group['label'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <div class="bv-wd-stack__items">
                    <?php foreach ($group['items'] as $item): ?>
                        <span class="bv-wd-stack__item bv-font-mono">
                            <?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     06 // ENGAGEMENT MODELS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-engagements" id="engagement-models" aria-labelledby="wd-engagements-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // ENGAGEMENT MODELS</span>
        <h2 class="bv-section__title" id="wd-engagements-title">
            Four ways to <span class="bv-text-gradient">work together.</span>
        </h2>
        <p class="bv-section__lead">
            Pick the model that fits your stage and budget. Every engagement
            starts with a written scope, a firm timeline, and a fixed price.
            No hourly surprises. No scope creep without a change order.
        </p>
    </div>

    <div class="bv-wd-engagements__grid">
        <?php foreach ($engagements as $e): ?>
            <article class="bv-wd-engagement bv-card <?= !empty($e['featured']) ? 'bv-wd-engagement--featured' : '' ?>">
                <?php if (!empty($e['featured'])): ?>
                    <div class="bv-wd-engagement__featured-badge bv-font-sci-label">Most Popular</div>
                <?php endif; ?>

                <div class="bv-wd-engagement__header">
                    <div class="bv-wd-engagement__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($e['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div>
                        <h3 class="bv-wd-engagement__name"><?= htmlspecialchars($e['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="bv-wd-engagement__tagline"><?= htmlspecialchars($e['tagline'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="bv-wd-engagement__price bv-font-sci-display">
                    <?= htmlspecialchars($e['price'], ENT_QUOTES, 'UTF-8') ?>
                </div>

                <p class="bv-wd-engagement__desc"><?= htmlspecialchars($e['desc'], ENT_QUOTES, 'UTF-8') ?></p>

                <ul class="bv-wd-engagement__includes" role="list">
                    <?php foreach ($e['includes'] as $item): ?>
                        <li>
                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                            <span><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="bv-wd-engagement__best-for">
                    <span class="bv-font-sci-label">Best For</span>
                    <span><?= htmlspecialchars($e['best_for'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>

                <a href="/contact?engagement=<?= htmlspecialchars($e['id'], ENT_QUOTES, 'UTF-8') ?>" class="bv-btn bv-btn--primary bv-wd-engagement__cta">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    <span>Start This Engagement</span>
                </a>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     07 // FAQ
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-faq" id="faq" aria-labelledby="wd-faq-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">07 // FREQUENT QUESTIONS</span>
        <h2 class="bv-section__title" id="wd-faq-title">
            The questions <span class="bv-text-gradient">everyone asks.</span>
        </h2>
    </div>

    <div class="bv-wd-faq__list" role="list">
        <?php foreach ($faq as $i => $item): ?>
            <details class="bv-wd-faq__item bv-card" id="faq-<?= $i ?>">
                <summary class="bv-wd-faq__question">
                    <span><?= htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="bv-wd-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
                </summary>
                <div class="bv-wd-faq__answer">
                    <p><?= htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </details>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-wd-cta" aria-labelledby="wd-cta-title">

    <div class="bv-wd-cta__inner">

        <span class="bv-wd-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-wd-cta__title bv-font-viking-display" id="wd-cta-title">
            Let's build something that actually holds.
        </h2>

        <p class="bv-wd-cta__lead">
            Whether you need a new application from scratch, a codebase rescue,
            or a standing engineering partner — reach out. Scoping call is free.
            NDA-friendly. Fixed-price proposals within a week.
        </p>

        <div class="bv-wd-cta__actions">
            <a href="/contact?engagement=scoping" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Schedule Scoping Call</span>
            </a>
            <a href="/portfolio" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span>See Past Work</span>
            </a>
        </div>

        <div class="bv-wd-cta__meta">
            <span class="bv-wd-cta__meta-item">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>PGP: security@beardedviking.org</span>
            </span>
            <span class="bv-wd-cta__meta-item">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <span>Response within 72 hours</span>
            </span>
            <span class="bv-wd-cta__meta-item">
                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                <span>NDA-friendly</span>
            </span>
        </div>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>