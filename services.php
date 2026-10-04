<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Services Hub
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      services.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Services — The Four Disciplines of BVSec',
    'description' => 'Bug bounty hunting, custom web development, native mobile apps, and in-house security tooling. Payment plans, hosting options, and honest answers to the questions every client asks.',
    'canonical'   => '/services',
    'og_image'    => '/assets/images/og/services.png',
    'body_class'  => 'page-services-hub',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  THE FOUR SERVICE LINES
// ──────────────────────────────────────────────────────────────────────────
$service_lines = [
    [
        'id'      => 'bug-bounty',
        'icon'    => 'fa-solid fa-bug',
        'name'    => 'Bug Bounty Hunting',
        'tagline' => 'Find what scanners miss.',
        'url'     => '/services/bug-bounty.php',
        'accent'  => 'bounty',
        'desc'    => 'Professional penetration testing and responsible vulnerability disclosure across web, API, and mobile attack surfaces. Every finding proven with PoC. Every report written for engineers, not executives.',
        'highlights' => [
            '8 vulnerability disciplines covered',
            'OWASP Top 10 + API Top 10 methodology',
            'Full responsible disclosure support',
            '3 engagement models from $2,500',
        ],
    ],
    [
        'id'      => 'web-development',
        'icon'    => 'fa-solid fa-code',
        'name'    => 'Custom Web Development',
        'tagline' => 'Fortresses, not websites.',
        'url'     => '/services/web-development.php',
        'accent'  => 'web',
        'desc'    => 'Security-hardened web applications, APIs, and platforms built from scratch. PHP 8.2 + Ruby on Rails + modern JavaScript. OWASP 2026 baseline on every project, no exceptions, no upcharges.',
        'highlights' => [
            'Custom applications, APIs, and dashboards',
            'Security baseline included on every project',
            '2–6 month typical turnaround',
            '4 engagement models from $500',
        ],
    ],
    [
        'id'      => 'mobile-development',
        'icon'    => 'fa-solid fa-mobile-screen-button',
        'name'    => 'Native Mobile Apps',
        'tagline' => 'In your pocket. Hardened to core.',
        'url'     => '/services/mobile-development.php',
        'accent'  => 'mobile',
        'desc'    => 'Native Android (Kotlin) and iOS (Swift) applications. No cross-platform wrappers, no compromise on security, no compromise on performance. Hardware-backed keystores, certificate pinning, RASP integration.',
        'highlights' => [
            'Kotlin + Jetpack Compose (Android)',
            'Swift + SwiftUI (iOS)',
            'Full store submission handled end-to-end',
            '4 engagement models from $2,000/mo',
        ],
    ],
    [
        'id'      => 'in-house',
        'icon'    => 'fa-solid fa-hammer',
        'name'    => 'In-House Projects',
        'tagline' => 'We build for ourselves first.',
        'url'     => '/services/in-house.php',
        'accent'  => 'inhouse',
        'desc'    => 'The tools we build because we need them — then release for everyone else. MyCitadel, Völva, SQLMap Tampers, and a growing collection of privacy-first platforms and security research tooling.',
        'highlights' => [
            'MyCitadel — privacy-first social platform',
            'Völva — detection-first vulnerability scanner',
            'SQLMap Tampers — WAF bypass toolkit',
            'Source available on GitHub',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  TECHNICAL SKILLS DEEP DIVE
// ──────────────────────────────────────────────────────────────────────────
$skill_groups = [
    [
        'label' => 'Programming Languages',
        'icon'  => 'fa-solid fa-terminal',
        'skills' => [
            ['name' => 'C / C++',          'level' => 'Systems & performance'],
            ['name' => 'C#',               'level' => '.NET services'],
            ['name' => 'Ruby on Rails',    'level' => 'Rapid application dev'],
            ['name' => 'PHP 8.2+',         'level' => 'Hardened web apps'],
            ['name' => 'Python 3',         'level' => 'Tooling, AI/LLM, automation'],
            ['name' => 'Kotlin',           'level' => 'Native Android'],
            ['name' => 'Swift',            'level' => 'Native iOS'],
            ['name' => 'JavaScript (ES2024+)','level' => 'Frontend & Node tooling'],
            ['name' => 'Bash',             'level' => 'Unix automation & glue'],
            ['name' => 'SQL',              'level' => 'MySQL, PostgreSQL, SQLite'],
        ],
    ],
    [
        'label' => 'Security Tooling',
        'icon'  => 'fa-solid fa-shield-halved',
        'skills' => [
            ['name' => 'Burp Suite Pro',   'level' => 'Web pentesting'],
            ['name' => 'Nmap / Masscan',   'level' => 'Network mapping'],
            ['name' => 'Metasploit',       'level' => 'Exploitation framework'],
            ['name' => 'sqlmap',           'level' => 'SQL injection testing'],
            ['name' => 'ffuf / gobuster',  'level' => 'Content discovery'],
            ['name' => 'Frida / Objection','level' => 'Mobile runtime analysis'],
            ['name' => 'Ghidra',           'level' => 'Reverse engineering'],
            ['name' => 'Wireshark',        'level' => 'Traffic analysis'],
            ['name' => 'Hashcat',          'level' => 'Credential cracking'],
            ['name' => 'Custom Python',    'level' => 'Bespoke tooling'],
        ],
    ],
    [
        'label' => 'Infrastructure',
        'icon'  => 'fa-solid fa-server',
        'skills' => [
            ['name' => 'Debian',           'level' => 'Primary server OS'],
            ['name' => 'Ubuntu LTS',       'level' => 'Fleet standard'],
            ['name' => 'Nginx / Apache',   'level' => 'Reverse proxy & web server'],
            ['name' => 'Docker',           'level' => 'Containerization'],
            ['name' => 'DigitalOcean',     'level' => 'Droplets, managed DBs'],
            ['name' => 'AWS S3 / EC2',     'level' => 'Storage & compute'],
            ['name' => 'Google Cloud',     'level' => 'Compute & AI services'],
            ['name' => 'GitHub Actions',   'level' => 'CI/CD pipelines'],
            ['name' => 'Let\'s Encrypt',   'level' => 'TLS automation'],
            ['name' => 'Cloudflare',       'level' => 'CDN & DDoS mitigation'],
        ],
    ],
    [
        'label' => 'AI / LLM Engineering',
        'icon'  => 'fa-solid fa-microchip',
        'skills' => [
            ['name' => 'Ollama',           'level' => 'Local model inference'],
            ['name' => 'HuggingFace',      'level' => 'Fine-tuning & hosting'],
            ['name' => 'LangChain',        'level' => 'Agent frameworks'],
            ['name' => 'LlamaIndex',       'level' => 'RAG pipelines'],
            ['name' => 'pgvector',         'level' => 'Vector storage'],
            ['name' => 'MCP',              'level' => 'Tool-calling protocol'],
            ['name' => 'OpenAI API',       'level' => 'As needed, not by default'],
            ['name' => 'Anthropic API',    'level' => 'As needed, not by default'],
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  PAYMENT OPTIONS
// ──────────────────────────────────────────────────────────────────────────
$payment_plans = [
    [
        'id'     => 'upfront',
        'label'  => 'Plan A',
        'name'   => 'Full Upfront',
        'tagline'=> 'Single payment. Best rate.',
        'split'  => [
            ['stage' => 'Kickoff',   'pct' => '100%'],
        ],
        'desc'   => 'Pay the full project cost at kickoff. In exchange for the upfront commitment, we discount the total price by 5–10% depending on scope. Best for clients with a locked budget and a clear scope.',
        'pros'   => [
            'Discounted total price (5–10% off)',
            'Simplest paperwork — one invoice, one payment',
            'Priority scheduling on our calendar',
        ],
        'cons'   => [
            'Highest cash outlay at the start',
            'Less leverage if scope changes mid-project',
        ],
        'best_for' => 'Well-scoped projects with locked budgets',
    ],
    [
        'id'     => 'half',
        'label'  => 'Plan B',
        'name'   => 'Fifty / Fifty',
        'tagline'=> 'Half at kickoff, half at delivery.',
        'split'  => [
            ['stage' => 'Kickoff',  'pct' => '50%'],
            ['stage' => 'Delivery', 'pct' => '50%'],
        ],
        'desc'   => 'Pay half of the project cost to begin. The remaining half is due on delivery, before final handover of credentials and source code. The most common arrangement for fixed-scope projects.',
        'pros'   => [
            'Balanced cash flow for both parties',
            'Payment tied to tangible milestones',
            'No discount markup — standard pricing',
        ],
        'cons'   => [
            'Two invoices instead of one',
            '50% is still a substantial initial outlay',
        ],
        'best_for' => 'Most projects. Our default recommendation.',
        'featured' => true,
    ],
    [
        'id'     => 'thirds',
        'label'  => 'Plan C',
        'name'   => 'Three-Payment Split',
        'tagline'=> 'Thirds: kickoff, midpoint, delivery.',
        'split'  => [
            ['stage' => 'Kickoff',   'pct' => '33%'],
            ['stage' => 'Midpoint',  'pct' => '33%'],
            ['stage' => 'Delivery',  'pct' => '34%'],
        ],
        'desc'   => 'Split the project across three milestones. The midpoint payment is due at the halfway point of the engagement — typically after the architecture is approved and development is under way. Best for larger projects where cash flow matters.',
        'pros'   => [
            'Spread cost across the project timeline',
            'Lower initial outlay than Plans A or B',
            'Payment milestones tied to real progress',
        ],
        'cons'   => [
            'Three invoices to manage',
            'Small price markup on very large projects (2–3%)',
        ],
        'best_for' => 'Large engagements, funded startups, cash-flow-sensitive projects',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  HOSTING OPTIONS
// ──────────────────────────────────────────────────────────────────────────
$hosting_options = [
    [
        'id'     => 'in-house',
        'icon'   => 'fa-solid fa-server',
        'name'   => 'In-House Hosting',
        'tagline'=> 'We host it. You use it.',
        'desc'   => 'We deploy your application to our infrastructure — professionally managed Debian servers with monitored uptime, automated backups, and TLS certificates that renew themselves. You focus on your business; we keep the lights on.',
        'includes' => [
            'Server infrastructure managed by BVSec',
            'Annual hosting fee (billed separately from development)',
            'Automated daily backups with 30-day retention',
            'TLS certificates and renewal automation',
            'Server monitoring and alerting',
            'Security patches applied automatically',
        ],
        'billing'   => 'Annual fee, billed at deployment',
        'best_for'  => 'Clients without a technical team or existing infrastructure',
        'consider'  => 'You don\'t get root access. If you need direct server control, choose Your Servers or Cloud Hosting.',
    ],
    [
        'id'     => 'your-servers',
        'icon'   => 'fa-solid fa-hard-drive',
        'name'   => 'Your Servers',
        'tagline'=> 'We deploy to infrastructure you already own.',
        'desc'   => 'You already have servers — whether a colocated rack, a VPS with a specific provider, or an on-premise environment. We design, build, and deploy your application directly onto your infrastructure. You maintain physical control; we handle the software.',
        'includes' => [
            'Deployment to your existing server environment',
            'Full server configuration and hardening',
            'Application deployment with zero-downtime strategy',
            'Monitoring and logging integration',
            'Documentation and runbook for your team',
            'Optional 90-day post-launch support',
        ],
        'billing'   => 'No hosting fees — you pay your provider directly',
        'best_for'  => 'Companies with existing infrastructure or data residency requirements',
        'consider'  => 'You are responsible for hardware, network, and OS maintenance after handover.',
    ],
    [
        'id'     => 'cloud',
        'icon'   => 'fa-solid fa-cloud',
        'name'   => 'Cloud Hosting',
        'tagline'=> 'You own the account. We set it up.',
        'desc'   => 'We provision a dedicated cloud environment on your behalf — DigitalOcean, AWS, Google Cloud, or another provider. You get full credentials to the account and billing relationship; we architect and configure the entire environment.',
        'includes' => [
            'Cloud provider account in your name',
            'Full infrastructure provisioning (compute, storage, DNS, CDN)',
            'Application deployment and configuration',
            'Auto-scaling and load balancing where appropriate',
            'Monitoring, alerting, and log aggregation',
            'Complete documentation and credential handover',
        ],
        'billing'   => 'You pay the cloud provider directly — no BVSec markup',
        'best_for'  => 'Clients who want full account control but no infrastructure expertise',
        'consider'  => 'You own the account and billing. Cloud costs scale with usage.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  DECISION Q&A
// ──────────────────────────────────────────────────────────────────────────
$decision_qa = [
    [
        'q' => 'What type of website do I actually need?',
        'a' => 'There are five common categories, and the right one depends on what you\'re trying to accomplish. <strong>Informational sites</strong> (brochure-style, Home + About + Contact + Gallery) are the smallest — perfect for personal brands, small businesses, or validating an idea. <strong>E-commerce sites</strong> add product catalogs, carts, and checkout for retail. <strong>Web applications</strong> introduce user accounts, dashboards, and complex workflows — anything where users log in and do work. <strong>SaaS platforms</strong> go further with multi-tenancy, subscriptions, and self-service onboarding. <strong>APIs and backend-only services</strong> skip the UI entirely — they power mobile apps, third-party integrations, or internal tooling. During our scoping call, we\'ll map your goals against these categories and recommend the smallest build that actually meets them. No upselling you into a SaaS platform when an informational site would serve you better.',
    ],
    [
        'q' => 'Do I really need a mobile app? Or is a website enough?',
        'a' => 'Not every business needs a mobile app, and some that have one shouldn\'t. The honest answer is: <strong>you need a mobile app only if your users will benefit from things a website cannot easily provide.</strong> Push notifications, offline access, camera and GPS hardware, biometric authentication, background processing, and app-store discoverability are the six things native apps do that websites don\'t do well. If your business model depends on any of them — a delivery service that needs push notifications, a field tool that works offline, a fitness app that uses GPS — you probably need a mobile app. If your users just need to read content, fill out forms, or check their account, a mobile-responsive website is faster, cheaper, and reaches more people. We\'ll tell you honestly which one fits your case, even if the answer costs us the bigger engagement.',
    ],
    [
        'q' => 'What are the pros and cons of having a mobile app?',
        'a' => '<strong>Pros:</strong> Push notifications reach users who\'ve stopped opening email. Hardware access — camera, GPS, biometrics, Bluetooth — enables features a website simply cannot replicate. Offline capability means your app works on airplanes and in rural areas. App store presence gives you a discovery channel and a legitimacy signal to investors and enterprise buyers. Native performance feels faster and smoother. Home screen presence increases repeat engagement. <strong>Cons:</strong> Mobile apps cost significantly more than responsive websites — usually 3–8× for equivalent scope. Both iOS and Android require separate native codebases. App Review adds uncertainty and delay to every release. Apple and Google take 15–30% of any in-app purchase revenue. User acquisition is expensive — most installs are abandoned within 30 days. Operating system updates force periodic maintenance. If you don\'t have a clear reason to be in the app store, a responsive web app is almost always the better first investment.',
    ],
    [
        'q' => 'What are the pros and cons of having a website?',
        'a' => '<strong>Pros:</strong> Universal access — any device with a browser works, no installation required. Instant updates — deploy once, every user sees the new version immediately. Single codebase serves desktop, tablet, and mobile with responsive design. SEO drives organic traffic that apps don\'t get. Zero app store review overhead, zero store tax on payments. Lower initial cost and faster turnaround. Easier to A/B test and iterate. <strong>Cons:</strong> No true push notifications — email and web notifications are weaker substitutes. Limited hardware access — camera and GPS work but with friction and permission prompts. Repeat access requires the user to remember your URL or bookmark it. No offline capability unless you build a PWA (which has its own limits). Discoverability depends entirely on your marketing. If your business depends on frequent re-engagement, daily use, or hardware access, a website alone may not be enough.',
    ],
    [
        'q' => 'Can I start with a website and add a mobile app later?',
        'a' => 'Yes — and this is usually the right approach. Start with a well-built responsive website that validates the concept, then add mobile apps once you have paying users and clear evidence that they want mobile features. The architecture matters: if the website is built with a proper API layer from day one, that same API powers the mobile apps later without rework. This is how every project we build is structured — the API is the foundation, and the web app is just the first client. Adding mobile later becomes a frontend project, not a rebuild. We recommend this path to almost every founder we talk to, even though it means smaller initial engagements for us. It\'s the honest answer.',
    ],
    [
        'q' => 'What does "estimated timeline" actually mean?',
        'a' => 'It means exactly that — an estimate. We provide a target completion window in every proposal, and we under-promise on purpose: the number we give is the number we intend to hit. But it is not a contractually guaranteed date, and here\'s why. BVSec is a small operation — sometimes a single person — running multiple engagements concurrently, plus ongoing in-house projects like MyCitadel. Occasionally timelines shift because a bug bounty disclosure turns into a critical fix that has to ship first, or because a client delivers feedback late, or because a third-party integration that worked in testing behaves differently in production. When we can deliver early, we do. When we can\'t, we communicate immediately — not after the deadline passes. You will never be surprised by our timeline. You will always know where the project stands. If you need a contractually guaranteed delivery date with penalties attached, we can discuss that, but it will affect pricing and scope.',
    ],
    [
        'q' => 'How do I know which engagement model to pick?',
        'a' => 'Start with scope. If you need a simple informational site or a landing page, pick the Starter Website tier under Web Development ($500, 3–5 business days). If you have a concept you want to validate, pick the MVP Build under Mobile Development ($8,000, single platform) or the Greenfield Build under Web Development ($15,000). If you have an existing codebase that\'s slow or insecure, pick the Rescue Mission ($5,000). If you know you\'ll need ongoing work, the Development Retainer ($3,500/mo) is the most economical path. For security work, one-shot audits start at $2,500, and continuous hunting retainers start at $4,000/mo. Every engagement includes 90 days of post-launch support. During the scoping call, we\'ll walk through your specific case and recommend the model — not the biggest one, the right one.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  TIMELINE NOTES
// ──────────────────────────────────────────────────────────────────────────
$timeline_facts = [
    [
        'icon' => 'fa-solid fa-clock',
        'value' => '3–5 Days',
        'label' => 'Starter Website',
        'note'  => 'Informational sites, small fixes, single-page builds',
    ],
    [
        'icon' => 'fa-solid fa-clock',
        'value' => '2–6 Weeks',
        'label' => 'Small Build',
        'note'  => 'Landing pages with custom features, small APIs',
    ],
    [
        'icon' => 'fa-solid fa-clock',
        'value' => '2–6 Months',
        'label' => 'Full Application',
        'note'  => 'Typical web app, mobile MVP, medium security audit',
    ],
    [
        'icon' => 'fa-solid fa-clock',
        'value' => '6–12 Months',
        'label' => 'Complex Platform',
        'note'  => 'Multi-surface platforms, dual-platform mobile, enterprise',
    ],
];
?>

<main id="main-content" class="bv-main bv-services-hub">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-sh-hero" id="sh-hero" aria-labelledby="sh-hero-title">

    <div class="bv-sh-hero__bg" aria-hidden="true">
        <div class="bv-sh-hero__vignette"></div>
        <div class="bv-sh-hero__aurora"></div>
        <div class="bv-sh-hero__grid"></div>
    </div>

    <div class="bv-sh-hero__runes bv-sh-hero__runes--left" aria-hidden="true">
        <span>ᛊ</span><span>ᛖ</span><span>ᚱ</span><span>ᚢ</span><span>ᛁ</span><span>ᚲ</span>
    </div>
    <div class="bv-sh-hero__runes bv-sh-hero__runes--right" aria-hidden="true">
        <span>ᚹ</span><span>ᛁ</span><span>ᚲ</span><span>ᛁ</span><span>ᚾ</span><span>ᚷ</span>
    </div>

    <div class="bv-sh-hero__inner">

        <span class="bv-section__eyebrow">᛫ The Gateway · Everything We Offer ᛫</span>

        <h1 class="bv-sh-hero__title" id="sh-hero-title">
            <span class="bv-sh-hero__title-runes" aria-hidden="true">ᛊᛖᚱᚢᛁᚲᛖ</span>
            <span class="bv-sh-hero__title-line bv-sh-hero__title-line--viking">Four Disciplines.</span>
            <span class="bv-sh-hero__title-line bv-sh-hero__title-line--accent">
                <span class="bv-glitch" data-text="One Standard.">One Standard.</span>
            </span>
        </h1>

        <p class="bv-sh-hero__lead">
            Bug bounty hunting. Custom web development. Native mobile apps.
            In-house security tooling. Four service lines, one operator, one
            standard of quality. This page answers the questions every client
            asks before they hire — honestly, without marketing fluff.
        </p>

        <div class="bv-sh-hero__actions">
            <a href="#services" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
                <span>Explore Services</span>
            </a>
            <a href="#decision-qa" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                <span>Decide What You Need</span>
            </a>
        </div>

        <div class="bv-sh-hero__metrics" role="list">
            <div class="bv-sh-hero__metric" role="listitem">
                <span class="bv-sh-hero__metric-value" data-counter="4">0</span>
                <span class="bv-sh-hero__metric-label">Service Lines</span>
            </div>
            <div class="bv-sh-hero__metric" role="listitem">
                <span class="bv-sh-hero__metric-value" data-counter="3">0</span>
                <span class="bv-sh-hero__metric-label">Payment Plans</span>
            </div>
            <div class="bv-sh-hero__metric" role="listitem">
                <span class="bv-sh-hero__metric-value" data-counter="3">0</span>
                <span class="bv-sh-hero__metric-label">Hosting Options</span>
            </div>
            <div class="bv-sh-hero__metric" role="listitem">
                <span class="bv-sh-hero__metric-value" data-counter="90">0</span>
                <span class="bv-sh-hero__metric-label">Day Support</span>
            </div>
        </div>

    </div>

    <div class="bv-sh-hero__scroll" aria-hidden="true">
        <span class="bv-sh-hero__scroll-rune">ᛝ</span>
        <span class="bv-sh-hero__scroll-text">SCROLL FOR INTEL</span>
        <span class="bv-sh-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // THE FOUR SERVICE LINES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-services" id="services" aria-labelledby="sh-services-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // THE FOUR DISCIPLINES</span>
        <h2 class="bv-section__title" id="sh-services-title">
            What we do. <span class="bv-text-gradient">Why it matters.</span>
        </h2>
        <p class="bv-section__lead">
            Four service lines, each with its own dedicated page, its own
            engagement models, and its own pricing. Click into any of them
            for the full deep dive — or keep reading for the technical skills,
            payment options, and hosting arrangements that apply across all
            four.
        </p>
    </div>

    <div class="bv-sh-services__grid">
        <?php foreach ($service_lines as $s): ?>
            <a href="<?= htmlspecialchars($s['url'], ENT_QUOTES, 'UTF-8') ?>"
               class="bv-sh-service bv-card bv-sh-service--<?= htmlspecialchars($s['accent'], ENT_QUOTES, 'UTF-8') ?>">
                <div class="bv-sh-service__header">
                    <div class="bv-sh-service__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($s['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div class="bv-sh-service__header-text">
                        <h3 class="bv-sh-service__name bv-font-viking-display">
                            <?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="bv-sh-service__tagline">
                            <?= htmlspecialchars($s['tagline'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>

                <p class="bv-sh-service__desc">
                    <?= htmlspecialchars($s['desc'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <ul class="bv-sh-service__highlights" role="list">
                    <?php foreach ($s['highlights'] as $h): ?>
                        <li><?= htmlspecialchars($h, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>

                <span class="bv-sh-service__link">
                    <span>Read the full page</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </span>
            </a>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // TECHNICAL SKILLS DEEP DIVE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-skills" id="technical-skills" aria-labelledby="sh-skills-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // THE TECHNICAL ARSENAL</span>
        <h2 class="bv-section__title" id="sh-skills-title">
            The full stack. <span class="bv-text-gradient">Every layer.</span>
        </h2>
        <p class="bv-section__lead">
            You can read about our services on their individual pages. This
            section is the technical depth behind them — every language,
            every tool, every platform we actually work with. No padding,
            no "familiar with" wishy-washy language. If it's listed here,
            we ship with it.
        </p>
    </div>

    <div class="bv-sh-skills__grid">
        <?php foreach ($skill_groups as $g): ?>
            <div class="bv-sh-skills__group bv-card">
                <div class="bv-sh-skills__group-header">
                    <div class="bv-sh-skills__group-icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($g['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <h3 class="bv-sh-skills__group-title bv-font-viking-heading">
                        <?= htmlspecialchars($g['label'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                </div>
                <ul class="bv-sh-skills__list" role="list">
                    <?php foreach ($g['skills'] as $skill): ?>
                        <li class="bv-sh-skills__item">
                            <span class="bv-sh-skills__skill-name bv-font-mono">
                                <?= htmlspecialchars($skill['name'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="bv-sh-skills__skill-level">
                                <?= htmlspecialchars($skill['level'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // PAYMENT PLANS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-payments" id="payment-plans" aria-labelledby="sh-payments-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // PAYMENT OPTIONS</span>
        <h2 class="bv-section__title" id="sh-payments-title">
            Three payment plans. <span class="bv-text-gradient">Pick your comfort level.</span>
        </h2>
        <p class="bv-section__lead">
            Every project is priced with a fixed cost before kickoff — no
            hourly billing, no surprise invoices. How you pay is your call.
            Choose the plan that matches your cash flow and your comfort
            with the engagement.
        </p>
    </div>

    <div class="bv-sh-payments__grid">
        <?php foreach ($payment_plans as $plan): ?>
            <article class="bv-sh-payment bv-card <?= !empty($plan['featured']) ? 'bv-sh-payment--featured' : '' ?>">
                <?php if (!empty($plan['featured'])): ?>
                    <div class="bv-sh-payment__featured-badge bv-font-sci-label">Default</div>
                <?php endif; ?>

                <div class="bv-sh-payment__header">
                    <span class="bv-sh-payment__label bv-font-mono"><?= htmlspecialchars($plan['label'], ENT_QUOTES, 'UTF-8') ?></span>
                    <h3 class="bv-sh-payment__name bv-font-viking-heading">
                        <?= htmlspecialchars($plan['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                    <p class="bv-sh-payment__tagline">
                        <?= htmlspecialchars($plan['tagline'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>

                <div class="bv-sh-payment__split">
                    <?php foreach ($plan['split'] as $stage): ?>
                        <div class="bv-sh-payment__stage">
                            <span class="bv-sh-payment__stage-pct bv-font-sci-display">
                                <?= htmlspecialchars($stage['pct'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <span class="bv-sh-payment__stage-label bv-font-mono">
                                <?= htmlspecialchars($stage['stage'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <p class="bv-sh-payment__desc">
                    <?= htmlspecialchars($plan['desc'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <div class="bv-sh-payment__columns">
                    <div class="bv-sh-payment__col bv-sh-payment__col--pros">
                        <span class="bv-sh-payment__col-label bv-font-sci-label">
                            <i class="fa-solid fa-check" aria-hidden="true"></i> Pros
                        </span>
                        <ul role="list">
                            <?php foreach ($plan['pros'] as $p): ?>
                                <li><?= htmlspecialchars($p, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="bv-sh-payment__col bv-sh-payment__col--cons">
                        <span class="bv-sh-payment__col-label bv-font-sci-label">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i> Cons
                        </span>
                        <ul role="list">
                            <?php foreach ($plan['cons'] as $c): ?>
                                <li><?= htmlspecialchars($c, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="bv-sh-payment__best-for">
                    <span class="bv-font-sci-label">Best For</span>
                    <span><?= htmlspecialchars($plan['best_for'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>

            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     04 // HOSTING OPTIONS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-hosting" id="hosting-options" aria-labelledby="sh-hosting-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // HOSTING OPTIONS</span>
        <h2 class="bv-section__title" id="sh-hosting-title">
            Three ways to <span class="bv-text-gradient">run your application.</span>
        </h2>
        <p class="bv-section__lead">
            Where your application lives matters — for cost, for control, and
            for how much infrastructure responsibility you want to carry.
            Every project ships on one of these three foundations. Pick the
            one that fits your situation.
        </p>
    </div>

    <div class="bv-sh-hosting__grid">
        <?php foreach ($hosting_options as $h): ?>
            <article class="bv-sh-hosting-option bv-card">
                <div class="bv-sh-hosting-option__header">
                    <div class="bv-sh-hosting-option__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($h['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div>
                        <h3 class="bv-sh-hosting-option__name bv-font-viking-heading">
                            <?= htmlspecialchars($h['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="bv-sh-hosting-option__tagline">
                            <?= htmlspecialchars($h['tagline'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>

                <p class="bv-sh-hosting-option__desc">
                    <?= htmlspecialchars($h['desc'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <div class="bv-sh-hosting-option__section">
                    <span class="bv-sh-hosting-option__section-label bv-font-sci-label">
                        <i class="fa-solid fa-list-check" aria-hidden="true"></i> What's Included
                    </span>
                    <ul class="bv-sh-hosting-option__includes" role="list">
                        <?php foreach ($h['includes'] as $item): ?>
                            <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="bv-sh-hosting-option__meta">
                    <div class="bv-sh-hosting-option__meta-item">
                        <span class="bv-sh-hosting-option__meta-label bv-font-sci-label">Billing</span>
                        <span class="bv-sh-hosting-option__meta-value"><?= htmlspecialchars($h['billing'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="bv-sh-hosting-option__meta-item">
                        <span class="bv-sh-hosting-option__meta-label bv-font-sci-label">Best For</span>
                        <span class="bv-sh-hosting-option__meta-value"><?= htmlspecialchars($h['best_for'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="bv-sh-hosting-option__meta-item bv-sh-hosting-option__meta-item--consider">
                        <span class="bv-sh-hosting-option__meta-label bv-font-sci-label">
                            <i class="fa-solid fa-circle-info" aria-hidden="true"></i> Consider
                        </span>
                        <span class="bv-sh-hosting-option__meta-value"><?= htmlspecialchars($h['consider'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     05 // DECISION Q&A
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-qa" id="decision-qa" aria-labelledby="sh-qa-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">05 // DECISION SUPPORT</span>
        <h2 class="bv-section__title" id="sh-qa-title">
            The questions <span class="bv-text-gradient">you should actually be asking.</span>
        </h2>
        <p class="bv-section__lead">
            These are the questions we hear most often during scoping calls.
            We're answering them here — plainly, honestly, without upselling
            — so you can make an informed decision about what you actually
            need before you ever talk to us.
        </p>
    </div>

    <div class="bv-sh-qa__list" role="list">
        <?php foreach ($decision_qa as $i => $qa): ?>
            <details class="bv-sh-qa__item bv-card" id="qa-<?= $i ?>">
                <summary class="bv-sh-qa__question">
                    <span><?= htmlspecialchars($qa['q'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="bv-sh-qa__icon" aria-hidden="true">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </summary>
                <div class="bv-sh-qa__answer">
                    <p><?= $qa['a'] /* contains HTML <strong> tags — escaped at source */ ?></p>
                </div>
            </details>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     06 // TIMELINE REALITY
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-timeline" id="timeline-reality" aria-labelledby="sh-timeline-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // TIMELINE REALITY</span>
        <h2 class="bv-section__title" id="sh-timeline-title">
            What "estimated" <span class="bv-text-gradient">actually means.</span>
        </h2>
        <p class="bv-section__lead">
            We provide estimated completion windows in every proposal. We
            under-promise on purpose. But we want to be clear about what
            those numbers are and aren't — so there are no surprises when
            reality happens.
        </p>
    </div>

    <div class="bv-sh-timeline__grid">
        <?php foreach ($timeline_facts as $f): ?>
            <div class="bv-sh-timeline__fact bv-card">
                <div class="bv-sh-timeline__fact-icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($f['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <div class="bv-sh-timeline__fact-value bv-font-sci-display">
                    <?= htmlspecialchars($f['value'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="bv-sh-timeline__fact-label bv-font-viking-heading">
                    <?= htmlspecialchars($f['label'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <p class="bv-sh-timeline__fact-note">
                    <?= htmlspecialchars($f['note'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bv-sh-timeline__disclaimer">
        <div class="bv-sh-timeline__disclaimer-icon" aria-hidden="true">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="bv-sh-timeline__disclaimer-body">
            <h3 class="bv-sh-timeline__disclaimer-title bv-font-viking-heading">
                A note on timelines
            </h3>
            <p>
                Estimated timeframes are exactly that — <strong>estimates</strong>,
                not contractual deadlines. BVSec is a very small operation,
                often running multiple engagements concurrently alongside
                ongoing in-house projects like MyCitadel. Sometimes we deliver
                early. Sometimes a critical bug bounty disclosure turns into
                a fix that has to ship first, and your timeline shifts by a
                few days. When either happens, you'll know immediately.
            </p>
            <p>
                You will <strong>never</strong> be surprised by our timeline.
                You will always know where your project stands. Weekly demos,
                written progress updates, and direct communication are included
                on every engagement. If you need a contractually guaranteed
                delivery date with penalties attached, we can discuss that —
                but it will affect pricing and scope.
            </p>
        </div>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-sh-cta" aria-labelledby="sh-cta-title">

    <div class="bv-sh-cta__inner">

        <span class="bv-sh-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-sh-cta__title bv-font-viking-display" id="sh-cta-title">
            Still not sure which service fits?
        </h2>

        <p class="bv-sh-cta__lead">
            That's what the scoping call is for. Describe what you're trying
            to accomplish — no jargon required. We'll tell you honestly
            which service line fits, which engagement model makes sense,
            and what the realistic timeline looks like. Free, NDA-friendly,
            no obligation.
        </p>

        <div class="bv-sh-cta__actions">
            <a href="/contact?engagement=scoping" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Schedule Scoping Call</span>
            </a>
            <a href="#services" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
                <span>Revisit the Services</span>
            </a>
        </div>

        <div class="bv-sh-cta__meta">
            <span class="bv-sh-cta__meta-item">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>PGP: security@beardedviking.org</span>
            </span>
            <span class="bv-sh-cta__meta-item">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <span>Response within 72 hours</span>
            </span>
            <span class="bv-sh-cta__meta-item">
                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                <span>NDA-friendly</span>
            </span>
        </div>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>