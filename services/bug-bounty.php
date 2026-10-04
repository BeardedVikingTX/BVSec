<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Bug Bounty Hunting Services
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      services/bug-bounty.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Bug Bounty Hunting — Vulnerability Research & Responsible Disclosure',
    'description' => 'Professional penetration testing and bug bounty hunting by BeardedVikingTX. OSCP · CEH · Ph.D. C.S. Web, API, and mobile attack surfaces. Responsible disclosure. Proven methodology.',
    'canonical'   => '/services/bug-bounty',
    'og_image'    => '/assets/images/og/bug-bounty.png',
    'body_class'  => 'page-bug-bounty',
];

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  VULNERABILITY CLASSES — organized by attack surface
// ──────────────────────────────────────────────────────────────────────────
$vuln_classes = [
    [
        'icon'  => 'fa-solid fa-syringe',
        'name'  => 'Injection',
        'cwes'  => ['CWE-89', 'CWE-79', 'CWE-78', 'CWE-917'],
        'items' => [
            'SQL injection — boolean, time-based, error-based',
            'Stored, reflected, and DOM-based XSS',
            'OS command injection and template injection',
            'NoSQL injection (MongoDB, CouchDB)',
            'LDAP and XPath injection',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-key',
        'name'  => 'Broken Access Control',
        'cwes'  => ['CWE-639', 'CWE-284', 'CWE-863'],
        'items' => [
            'IDOR and BOLA (Broken Object-Level Authorization)',
            'BOPLA — property-level authorization flaws',
            'Path traversal and forced browsing',
            'Privilege escalation (horizontal & vertical)',
            'Missing function-level access control',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-user-lock',
        'name'  => 'Authentication & Session',
        'cwes'  => ['CWE-287', 'CWE-384', 'CWE-613'],
        'items' => [
            'Auth bypass and credential stuffing defenses',
            'JWT flaws — alg confusion, weak signing, kid injection',
            'OAuth/OIDC misconfigurations and redirect abuse',
            'Session fixation, hijacking, and CSRF',
            'Password reset flow abuse',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-server',
        'name'  => 'Server-Side',
        'cwes'  => ['CWE-918', 'CWE-611', 'CWE-502'],
        'items' => [
            'SSRF — blind, semi-blind, and cloud metadata exploitation',
            'XXE and file inclusion (LFI/RFI)',
            'Insecure deserialization (Java, PHP, .NET)',
            'Server-side template injection (SSTI)',
            'Race conditions and TOCTOU flaws',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-mobile-screen-button',
        'name'  => 'Mobile (Android & iOS)',
        'cwes'  => ['CWE-798', 'CWE-312', 'CWE-295'],
        'items' => [
            'Hardcoded credentials and API keys in APKs/IPAs',
            'Insecure local storage and keychain misuse',
            'Certificate pinning bypass and MITM exposure',
            'Insecure deep links and intent redirection',
            'Exported components and WebView abuse',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-diagram-project',
        'name'  => 'API & GraphQL',
        'cwes'  => ['CWE-200', 'CWE-915', 'CWE-862'],
        'items' => [
            'GraphQL introspection abuse and batching attacks',
            'Mass assignment and parameter pollution',
            'REST API auth bypass and versioning flaws',
            'Rate limiting and resource exhaustion gaps',
            'Excessive data exposure via API responses',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-user-secret',
        'name'  => 'Data Exposure & Privacy',
        'cwes'  => ['CWE-359', 'CWE-209', 'CWE-540'],
        'items' => [
            'PII and sensitive data leaks',
            'Information disclosure via error messages and headers',
            'Source code and config file exposure (.git, .env, backups)',
            'Third-party SDK data harvesting audits',
            'GDPR/CCPA compliance gap identification',
        ],
    ],
    [
        'icon'  => 'fa-solid fa-shield-halved',
        'name'  => 'Business Logic',
        'cwes'  => ['CWE-840', 'CWE-362'],
        'items' => [
            'Workflow bypass and multi-step process abuse',
            'Payment logic flaws and pricing manipulation',
            'Coupon, referral, and loyalty program exploitation',
            'Race conditions in transactions and state changes',
            'Quota bypass and rate limit evasion',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  METHODOLOGY PHASES
// ──────────────────────────────────────────────────────────────────────────
$phases = [
    [
        'num'   => '01',
        'icon'  => 'fa-solid fa-map',
        'title' => 'Reconnaissance',
        'body'  => 'Attack surface mapping before a single payload is fired. Subdomain enumeration, technology fingerprinting, JavaScript source analysis, endpoint discovery, and API surface extraction. If it\'s exposed, it gets documented.',
        'items' => [
            'Subdomain enumeration & asset discovery',
            'Technology stack fingerprinting',
            'JavaScript bundle analysis for hidden endpoints',
            'Wayback/archive crawl for historical routes',
            'Authentication & session flow mapping',
        ],
    ],
    [
        'num'   => '02',
        'icon'  => 'fa-solid fa-crosshairs',
        'title' => 'Vulnerability Analysis',
        'body'  => 'Systematic testing against OWASP Top 10 and beyond. Automated tooling handles breadth; manual analysis handles depth. Every finding is validated by hand — no scanner noise makes it into the report.',
        'items' => [
            'OWASP Top 10 + API Top 10 coverage',
            'Manual testing of every auth flow',
            'Business logic abuse case enumeration',
            'Custom payloads for the specific stack',
            'False-positive elimination before reporting',
        ],
    ],
    [
        'num'   => '03',
        'icon'  => 'fa-solid fa-bomb',
        'title' => 'Exploitation & Proof',
        'body'  => 'Every vulnerability gets a working proof of concept. Request/response pairs, screenshots, video captures where necessary. If I can\'t demonstrate the impact, it doesn\'t go in the report. Chain-of-exploit scenarios are mapped where they exist.',
        'items' => [
            'Reproducible step-by-step PoC',
            'Request/response evidence with redaction',
            'Impact demonstration (data access, privilege escalation)',
            'CVSS 3.1 scoring with justification',
            'Attack chain mapping where applicable',
        ],
    ],
    [
        'num'   => '04',
        'icon'  => 'fa-solid fa-file-shield',
        'title' => 'Reporting & Disclosure',
        'body'  => 'The report is the deliverable. Written for engineers who need to fix the bug, not just executives who need to know it exists. Every finding includes reproduction steps, business impact, and remediation guidance. Coordination with your team on disclosure timing.',
        'items' => [
            'Executive summary + technical deep-dive',
            'Prioritized findings by severity and exploitability',
            'Remediation guidance specific to your stack',
            'Coordinated disclosure timeline',
            'Post-fix verification testing',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  ENGAGEMENT MODELS
// ──────────────────────────────────────────────────────────────────────────
$engagements = [
    [
        'id'      => 'audit',
        'icon'    => 'fa-solid fa-magnifying-glass-chart',
        'name'    => 'One-Shot Security Audit',
        'tagline' => 'Fixed scope. Fixed price. Full report.',
        'price'   => 'Starting at $2,500',
        'desc'    => 'A comprehensive point-in-time audit of a defined scope — web application, API, mobile app, or a specific feature set. Ideal for pre-launch validation, compliance requirements, or post-incident verification.',
        'includes' => [
            'Scoping call & threat model',
            'Full manual + automated testing',
            'Detailed report with PoC evidence',
            '30-day post-delivery Q&A window',
            'Re-test of critical findings after fix',
        ],
        'best_for' => 'Pre-launch apps, compliance audits, investor due diligence',
    ],
    [
        'id'      => 'continuous',
        'icon'    => 'fa-solid fa-rotate',
        'name'    => 'Continuous Hunting Retainer',
        'tagline' => 'Ongoing vulnerability discovery.',
        'price'   => 'From $4,000/mo',
        'desc'    => 'Recurring engagement where I act as your standing external security researcher. New features get tested as they ship, new attack surface gets mapped continuously, and findings get reported as they\'re discovered — not at the end of a project.',
        'includes' => [
            'Monthly attack surface review',
            'Continuous testing of new features',
            'Direct Slack/email channel for criticals',
            'Quarterly written summary report',
            'Priority response for critical findings',
        ],
        'best_for' => 'Companies shipping continuously, SaaS platforms, fintech',
        'featured' => true,
    ],
    [
        'id'      => 'retest',
        'icon'    => 'fa-solid fa-clipboard-check',
        'name'    => 'Remediation Verification',
        'tagline' => 'Did the fix actually fix it?',
        'price'   => 'Starting at $500',
        'desc'    => 'Focused verification engagement. You\'ve already received a report from another auditor or your internal team — now you need independent confirmation that every issue is genuinely closed. Includes regression testing on related surfaces.',
        'includes' => [
            'Re-test of every reported finding',
            'Regression testing on adjacent code paths',
            'Pass/fail determination per finding',
            'Residual risk summary',
            'Updated CVSS re-scoring',
        ],
        'best_for' => 'Post-remediation sign-off, compliance closure',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  TOOLKIT
// ──────────────────────────────────────────────────────────────────────────
$toolkit = [
    'recon' => [
        'label' => 'Reconnaissance',
        'items' => ['Nmap', 'Amass', 'Subfinder', 'httpx', 'ffuf', 'gobuster', 'katana', 'waybackurls'],
    ],
    'web' => [
        'label' => 'Web & API Testing',
        'items' => ['Burp Suite Pro', 'Caido', 'sqlmap', 'Commix', 'Arjun', 'ParamSpider', 'GraphQL Voyager', 'Postman'],
    ],
    'mobile' => [
        'label' => 'Mobile Analysis',
        'items' => ['APKTool', 'jadx', 'Frida', 'Objection', 'MobSF', 'Hopper', 'Ghidra'],
    ],
    'exploit' => [
        'label' => 'Exploitation',
        'items' => ['Metasploit', 'Custom Python tooling', 'Bash automation', 'Responder', 'CrackMapExec', 'Impacket'],
    ],
    'analysis' => [
        'label' => 'Post-Exploitation & Analysis',
        'items' => ['Wireshark', 'tcpdump', 'Hashcat', 'John the Ripper', 'CyberChef', 'Custom parsers'],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  HACKERONE PROFILE DATA (public stats)
// ──────────────────────────────────────────────────────────────────────────
$h1 = [
    'username'    => 'beardedvikingtx',
    'profile_url' => 'https://hackerone.com/beardedvikingtx',
    'reputation'  => 17,
    'resolved'    => 1,
    'vuln_types'  => [
        ['name' => 'Use of Hard-coded Credentials', 'cwe' => 'CWE-798'],
        ['name' => 'Improper Following of Certificate\'s Chain of Trust', 'cwe' => 'CWE-296'],
        ['name' => 'Privacy Violation', 'cwe' => 'CWE-359'],
        ['name' => 'Stored Cross-Site Scripting', 'cwe' => 'CWE-79'],
        ['name' => 'Information Exposure Through Error Message', 'cwe' => 'CWE-209'],
    ],
];
?>

<main id="main-content" class="bv-main bv-bug-bounty">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO — BUG BOUNTY AS A SERVICE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-bb-hero" id="bb-hero" aria-labelledby="bb-hero-title">

    <div class="bv-bb-hero__bg" aria-hidden="true">
        <div class="bv-bb-hero__vignette"></div>
        <div class="bv-bb-hero__aurora"></div>
        <div class="bv-bb-hero__grid"></div>
    </div>

    <div class="bv-bb-hero__runes bv-bb-hero__runes--left" aria-hidden="true">
        <span>ᛒ</span><span>ᚢ</span><span>ᚷ</span>
    </div>
    <div class="bv-bb-hero__runes bv-bb-hero__runes--right" aria-hidden="true">
        <span>ᚺ</span><span>ᚢ</span><span>ᚾ</span><span>ᛏ</span>
    </div>

    <div class="bv-bb-hero__inner">

        <span class="bv-section__eyebrow">᛫ Service Offering · Bug Bounty Hunting ᛫</span>

        <h1 class="bv-bb-hero__title" id="bb-hero-title">
            <span class="bv-bb-hero__title-runes" aria-hidden="true">ᛒᚢᚷ ᚺᚢᚾᛏ</span>
            <span class="bv-bb-hero__title-line bv-bb-hero__title-line--viking">I Find What</span>
            <span class="bv-bb-hero__title-line bv-bb-hero__title-line--accent">
                <span class="bv-glitch" data-text="Scanners Miss.">Scanners Miss.</span>
            </span>
        </h1>

        <p class="bv-bb-hero__lead">
            Automated tools find the easy bugs. The bugs that actually cost you money —
            the ones that require understanding your application's logic, your users'
            workflows, and your business model — those need a human who thinks like an
            attacker. That's what I do.
        </p>

        <div class="bv-bb-hero__actions">
            <a href="#engagement-models" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-file-contract" aria-hidden="true"></i>
                <span>See Engagement Models</span>
            </a>
            <a href="#methodology" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-list-ol" aria-hidden="true"></i>
                <span>The Methodology</span>
            </a>
        </div>

        <div class="bv-bb-hero__metrics" role="list">
            <div class="bv-bb-hero__metric" role="listitem">
                <span class="bv-bb-hero__metric-value" data-counter="8">0</span>
                <span class="bv-bb-hero__metric-label">Years Hunting</span>
            </div>
            <div class="bv-bb-hero__metric" role="listitem">
                <span class="bv-bb-hero__metric-value" data-counter="8">0</span>
                <span class="bv-bb-hero__metric-label">Vuln Classes</span>
            </div>
            <div class="bv-bb-hero__metric" role="listitem">
                <span class="bv-bb-hero__metric-value" data-counter="40">0</span>
                <span class="bv-bb-hero__metric-label">Tools Mastered</span>
            </div>
            <div class="bv-bb-hero__metric" role="listitem">
                <span class="bv-bb-hero__metric-value" data-counter="100">0</span>
                <span class="bv-bb-hero__metric-label">% Responsible</span>
            </div>
        </div>

    </div>

    <div class="bv-bb-hero__scroll" aria-hidden="true">
        <span class="bv-bb-hero__scroll-rune">ᛝ</span>
        <span class="bv-bb-hero__scroll-text">SCROLL FOR INTEL</span>
        <span class="bv-bb-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // THE MISSION
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-mission" id="mission" aria-labelledby="bb-mission-title">

    <div class="bv-bb-mission__inner">

        <div class="bv-bb-mission__content">
            <span class="bv-section__eyebrow">01 // THE MISSION</span>

            <h2 class="bv-section__title" id="bb-mission-title">
                Security is not a product. <span class="bv-text-gradient">It's a practice.</span>
            </h2>

            <p class="bv-bb-mission__lead">
                Most companies think about security once a year — right before an audit,
                a compliance deadline, or a breach. That's backward. The bugs that hurt
                you most are the ones that sat in production for eighteen months while
                everyone assumed someone else was checking.
            </p>

            <p>
                I'm BeardedVikingTX — a penetration tester and bug bounty hunter with
                a background in web design and development. I leverage deep expertise
                in Linux environments alongside custom tooling to uncover complex
                vulnerabilities across diverse attack surfaces. My focus is on
                finding the high-impact security flaws that help organizations
                fortify their digital infrastructure and protect the sensitive
                user data they're trusted with.
            </p>

            <p>
                I hold an <strong>OSCP</strong>, a <strong>CEH</strong>, and a
                <strong>Ph.D. in Computer Science</strong> (Ashley University, 2014).
                I've been breaking into systems professionally for nearly a decade —
                first as a hobbyist, then as a full-time discipline. Every engagement
                is conducted under strict responsible disclosure practices. Every
                finding is reported, documented, and never weaponized.
            </p>

            <div class="bv-bb-mission__values">
                <div class="bv-bb-mission__value">
                    <i class="fa-solid fa-handshake" aria-hidden="true"></i>
                    <div>
                        <strong>Responsible Disclosure. Always.</strong>
                        <p>Every vulnerability is reported to the owner before it goes anywhere else. No exceptions. No gray areas.</p>
                    </div>
                </div>
                <div class="bv-bb-mission__value">
                    <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                    <div>
                        <strong>Your Data Stays Yours.</strong>
                        <p>If I access user data during testing, it's never exfiltrated, stored, or shared. Reports use redacted evidence.</p>
                    </div>
                </div>
                <div class="bv-bb-mission__value">
                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                    <div>
                        <strong>NDA-Friendly by Default.</strong>
                        <p>Comfortable with NDAs, safe harbor agreements, and formal Rules of Engagement. Standard engagements sign both.</p>
                    </div>
                </div>
            </div>

        </div>

        <aside class="bv-bb-mission__aside">
            <div class="bv-bb-mission__profile bv-card">
                <div class="bv-bb-mission__profile-header">
                    <div class="bv-bb-mission__profile-avatar" aria-hidden="true">
                        <i class="fa-solid fa-user-secret"></i>
                    </div>
                    <div>
                        <div class="bv-bb-mission__profile-name">BeardedVikingTX</div>
                        <div class="bv-bb-mission__profile-role bv-font-mono">Penetration Tester · Bug Bounty Hunter</div>
                    </div>
                </div>

                <div class="bv-bb-mission__profile-creds">
                    <span class="bv-bb-mission__profile-cred">
                        <i class="fa-solid fa-certificate" aria-hidden="true"></i> OSCP
                    </span>
                    <span class="bv-bb-mission__profile-cred">
                        <i class="fa-solid fa-certificate" aria-hidden="true"></i> CEH
                    </span>
                    <span class="bv-bb-mission__profile-cred">
                        <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i> Ph.D. C.S.
                    </span>
                </div>

                <a
                    href="<?= htmlspecialchars($h1['profile_url'], ENT_QUOTES, 'UTF-8') ?>"
                    class="bv-bb-mission__profile-link"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    <span>HackerOne Profile</span>
                </a>
            </div>

            <div class="bv-bb-mission__note bv-card">
                <div class="bv-bb-mission__note-icon" aria-hidden="true">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <p>
                    <strong>On the HackerOne account:</strong> This is a new public
                    profile — the stats are building. I've handled numerous
                    vulnerability disclosures through private channels and
                    corporate programs over the years. Public receipts get
                    published as disclosure windows close.
                </p>
            </div>
        </aside>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // VULNERABILITY CLASSES — WHAT I HUNT
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-classes" id="vuln-classes" aria-labelledby="bb-classes-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // THE HUNTING GROUNDS</span>
        <h2 class="bv-section__title" id="bb-classes-title">
            Eight disciplines. <span class="bv-text-gradient">One operator.</span>
        </h2>
        <p class="bv-section__lead">
            These are the vulnerability classes I hunt systematically. Every engagement
            tests against all eight — you don't get to pick which bugs I look for,
            because the attacker doesn't get to pick either.
        </p>
    </div>

    <div class="bv-bb-classes__grid">
        <?php foreach ($vuln_classes as $i => $vc): ?>
            <article class="bv-bb-class bv-card" style="--bv-bb-delay: <?= $i ?>">
                <div class="bv-bb-class__header">
                    <div class="bv-bb-class__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($vc['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div class="bv-bb-class__cwes">
                        <?php foreach ($vc['cwes'] as $cwe): ?>
                            <span class="bv-bb-class__cwe bv-font-mono"><?= htmlspecialchars($cwe, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <h3 class="bv-bb-class__name"><?= htmlspecialchars($vc['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                <ul class="bv-bb-class__list">
                    <?php foreach ($vc['items'] as $item): ?>
                        <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // METHODOLOGY
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-process" id="methodology" aria-labelledby="bb-process-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // THE METHODOLOGY</span>
        <h2 class="bv-section__title" id="bb-process-title">
            Four phases. <span class="bv-text-gradient">Zero guesswork.</span>
        </h2>
        <p class="bv-section__lead">
            Every engagement — from a two-day audit to a year-long retainer — moves
            through the same disciplined pipeline. No phase skipped. No finding
            reported without proof. This is how serious vulnerability research
            is conducted.
        </p>
    </div>

    <ol class="bv-bb-process__phases" role="list">
        <?php foreach ($phases as $phase): ?>
            <li class="bv-bb-process__phase">
                <div class="bv-bb-process__phase-num bv-font-sci-display">
                    <?= htmlspecialchars($phase['num'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="bv-bb-process__phase-body bv-card">
                    <h3 class="bv-bb-process__phase-title">
                        <i class="<?= htmlspecialchars($phase['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                        <span><?= htmlspecialchars($phase['title'], ENT_QUOTES, 'UTF-8') ?></span>
                    </h3>
                    <p class="bv-bb-process__phase-desc"><?= htmlspecialchars($phase['body'], ENT_QUOTES, 'UTF-8') ?></p>
                    <ul class="bv-bb-process__phase-list">
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
     04 // TOOLKIT
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-toolkit" id="toolkit" aria-labelledby="bb-toolkit-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // THE ARSENAL</span>
        <h2 class="bv-section__title" id="bb-toolkit-title">
            The tools of the trade. <span class="bv-text-gradient">Every phase covered.</span>
        </h2>
        <p class="bv-section__lead">
            Tools don't find bugs — but they make the process faster, more systematic,
            and more reproducible. Here's the stack I reach for on every engagement,
            organized by phase of the kill chain.
        </p>
    </div>

    <div class="bv-bb-toolkit__grid">
        <?php foreach ($toolkit as $key => $group): ?>
            <div class="bv-bb-toolkit__column bv-card">
                <div class="bv-bb-toolkit__column-header">
                    <span class="bv-bb-toolkit__column-label bv-font-sci-label">
                        <?= htmlspecialchars($group['label'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                </div>
                <div class="bv-bb-toolkit__items">
                    <?php foreach ($group['items'] as $tool): ?>
                        <span class="bv-bb-toolkit__item bv-font-mono">
                            <?= htmlspecialchars($tool, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     05 // TRACK RECORD — TRANSPARENT
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-record" id="record" aria-labelledby="bb-record-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">05 // THE RECORD</span>
        <h2 class="bv-section__title" id="bb-record-title">
            Public receipts. <span class="bv-text-gradient">Nothing invented.</span>
        </h2>
        <p class="bv-section__lead">
            The bug bounty industry has a noise problem. Too many people inflate
            numbers. Here's the actual public record — with links you can verify
            yourself. My private engagements remain private, but the platform work
            is visible to anyone who wants to check.
        </p>
    </div>

    <div class="bv-bb-record__grid">

        <div class="bv-bb-record__profile bv-card">

            <div class="bv-bb-record__profile-header">
                <div class="bv-bb-record__profile-avatar" aria-hidden="true">
                    <i class="fa-solid fa-user-secret"></i>
                </div>
                <div class="bv-bb-record__profile-meta">
                    <div class="bv-bb-record__profile-username bv-font-mono">
                        @<?= htmlspecialchars($h1['username'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div class="bv-bb-record__profile-platform bv-font-sci-label">HackerOne</div>
                </div>
                <a
                    href="<?= htmlspecialchars($h1['profile_url'], ENT_QUOTES, 'UTF-8') ?>"
                    class="bv-bb-record__profile-link"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="View HackerOne profile"
                >
                    <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
            </div>

            <div class="bv-bb-record__stats">
                <div class="bv-bb-record__stat">
                    <span class="bv-bb-record__stat-value bv-font-sci-display"><?= (int) $h1['reputation'] ?></span>
                    <span class="bv-bb-record__stat-label bv-font-mono">Reputation</span>
                </div>
                <div class="bv-bb-record__stat">
                    <span class="bv-bb-record__stat-value bv-font-sci-display"><?= (int) $h1['resolved'] ?></span>
                    <span class="bv-bb-record__stat-label bv-font-mono">Public Resolved</span>
                </div>
                <div class="bv-bb-record__stat">
                    <span class="bv-bb-record__stat-value bv-font-sci-display">New</span>
                    <span class="bv-bb-record__stat-label bv-font-mono">Account Status</span>
                </div>
            </div>

            <div class="bv-bb-record__banner">
                <i class="fa-solid fa-info-circle" aria-hidden="true"></i>
                <span>
                    Public HackerOne profile is new (2026). Numbers will grow as
                    disclosure windows close. Numerous private disclosures are
                    covered under NDA.
                </span>
            </div>

        </div>

        <div class="bv-bb-record__vulns bv-card">
            <h3 class="bv-bb-record__vulns-title">
                <i class="fa-solid fa-bug" aria-hidden="true"></i>
                Vulnerability Types on Record
            </h3>
            <ul class="bv-bb-record__vulns-list" role="list">
                <?php foreach ($h1['vuln_types'] as $vt): ?>
                    <li class="bv-bb-record__vuln">
                        <span class="bv-bb-record__vuln-name"><?= htmlspecialchars($vt['name'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="bv-bb-record__vuln-cwe bv-font-mono"><?= htmlspecialchars($vt['cwe'], ENT_QUOTES, 'UTF-8') ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="bv-bb-record__vulns-note">
                Each type represents at least one validated, disclosed, and
                (where applicable) resolved finding. Full writeups available
                on request under NDA.
            </p>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     06 // ENGAGEMENT MODELS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-engagements" id="engagement-models" aria-labelledby="bb-engagements-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // ENGAGEMENT MODELS</span>
        <h2 class="bv-section__title" id="bb-engagements-title">
            Three ways to <span class="bv-text-gradient">work together.</span>
        </h2>
        <p class="bv-section__lead">
            Pick the model that fits your stage and budget. Every engagement includes
            full scoping, written Rules of Engagement, and complete reporting —
            no hidden fees, no surprise invoices.
        </p>
    </div>

    <div class="bv-bb-engagements__grid">
        <?php foreach ($engagements as $e): ?>
            <article class="bv-bb-engagement bv-card <?= !empty($e['featured']) ? 'bv-bb-engagement--featured' : '' ?>">
                <?php if (!empty($e['featured'])): ?>
                    <div class="bv-bb-engagement__featured-badge bv-font-sci-label">Most Popular</div>
                <?php endif; ?>

                <div class="bv-bb-engagement__header">
                    <div class="bv-bb-engagement__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($e['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div>
                        <h3 class="bv-bb-engagement__name"><?= htmlspecialchars($e['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="bv-bb-engagement__tagline"><?= htmlspecialchars($e['tagline'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="bv-bb-engagement__price bv-font-sci-display">
                    <?= htmlspecialchars($e['price'], ENT_QUOTES, 'UTF-8') ?>
                </div>

                <p class="bv-bb-engagement__desc"><?= htmlspecialchars($e['desc'], ENT_QUOTES, 'UTF-8') ?></p>

                <ul class="bv-bb-engagement__includes" role="list">
                    <?php foreach ($e['includes'] as $item): ?>
                        <li>
                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                            <span><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="bv-bb-engagement__best-for">
                    <span class="bv-font-sci-label">Best For</span>
                    <span><?= htmlspecialchars($e['best_for'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>

                <a href="/contact?engagement=<?= htmlspecialchars($e['id'], ENT_QUOTES, 'UTF-8') ?>" class="bv-btn bv-btn--primary bv-bb-engagement__cta">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    <span>Start This Engagement</span>
                </a>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     07 // ETHICS & SAFE HARBOR
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-ethics" id="ethics" aria-labelledby="bb-ethics-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">07 // ETHICS & SAFE HARBOR</span>
        <h2 class="bv-section__title" id="bb-ethics-title">
            How I operate <span class="bv-text-gradient">is the point.</span>
        </h2>
        <p class="bv-section__lead">
            The difference between a security researcher and a criminal is a
            written agreement, a code of conduct, and a report filed at the end.
            Here's exactly what governs every engagement.
        </p>
    </div>

    <div class="bv-bb-ethics__grid">

        <div class="bv-bb-ethics__pillar bv-card">
            <div class="bv-bb-ethics__pillar-icon" aria-hidden="true">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <h3 class="bv-bb-ethics__pillar-title">Written Rules of Engagement</h3>
            <p>
                Every engagement starts with a signed ROE document covering scope,
                testing windows, allowed techniques, prohibited actions, and
                emergency contacts. Nothing gets tested until both parties have
                signed.
            </p>
        </div>

        <div class="bv-bb-ethics__pillar bv-card">
            <div class="bv-bb-ethics__pillar-icon" aria-hidden="true">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="bv-bb-ethics__pillar-title">Data Minimization</h3>
            <p>
                If a test requires accessing user data to prove impact, I stop at
                the minimum required — usually one record, screenshot, and move
                on. No bulk exfiltration. No retained copies. Redaction before
                any report leaves my machine.
            </p>
        </div>

        <div class="bv-bb-ethics__pillar bv-card">
            <div class="bv-bb-ethics__pillar-icon" aria-hidden="true">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h3 class="bv-bb-ethics__pillar-title">Encrypted Communications</h3>
            <p>
                Reports are delivered via encrypted channels. PGP key available at
                <code class="bv-font-mono">security@beardedviking.org</code>. Findings
                never travel over unencrypted email — ever.
            </p>
        </div>

        <div class="bv-bb-ethics__pillar bv-card">
            <div class="bv-bb-ethics__pillar-icon" aria-hidden="true">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <h3 class="bv-bb-ethics__pillar-title">Coordinated Disclosure</h3>
            <p>
                Default disclosure window is 90 days from report delivery, in line
                with industry standards. Extensions granted where remediation
                requires. Never disclosed publicly without written client consent.
            </p>
        </div>

    </div>

    <div class="bv-bb-ethics__pledge">
        <span class="bv-bb-ethics__pledge-rune bv-font-runic" aria-hidden="true">ᛝ</span>
        <p class="bv-bb-ethics__pledge-text bv-font-viking-body">
            I hunt bugs because I want the internet to be safer, not because I
            want to weaponize it. If I ever have to choose between a bounty and
            a responsible report, I choose the report. Every time.
        </p>
        <cite class="bv-bb-ethics__pledge-cite bv-font-mono">— BeardedVikingTX</cite>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     08 // FAQ
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-faq" id="faq" aria-labelledby="bb-faq-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">08 // FREQUENT QUESTIONS</span>
        <h2 class="bv-section__title" id="bb-faq-title">
            The questions <span class="bv-text-gradient">everyone asks.</span>
        </h2>
    </div>

    <div class="bv-bb-faq__list" role="list">

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>Do I need to sign an NDA before we even talk?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    Happy to sign your NDA before a scoping call — I have a mutual NDA
                    template ready to go if you don't have one. Either way, everything
                    we discuss during scoping stays confidential, whether or not paper
                    has been exchanged.
                </p>
            </div>
        </details>

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>What's the typical turnaround for a full audit?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    For a scoped web application audit: 5–10 business days of testing
                    plus 2–3 days of reporting. Complex multi-surface engagements
                    (web + API + mobile + infrastructure) typically run 2–4 weeks.
                    Retainers are ongoing by definition.
                </p>
            </div>
        </details>

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>Do you test production or staging?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    Both, depending on the finding. Most testing happens against
                    staging to avoid customer impact, but production-only
                    configurations, WAFs, and CDN behaviors need to be validated
                    live. All production testing is scheduled with you in advance
                    and rate-limited to avoid service degradation.
                </p>
            </div>
        </details>

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>What if I need you to stop mid-engagement?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    The ROE includes a "kill switch" clause — you can call a halt
                    to testing at any time via the emergency contact, and I stop
                    within one hour of receiving the request. You pay only for the
                    days worked. Any findings already discovered get reported
                    anyway, because they're still real.
                </p>
            </div>
        </details>

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>What happens after the report?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    Every engagement includes a 30-day post-delivery Q&A window
                    where you can ask follow-up questions as your team works
                    through remediation. Critical findings get a free re-test
                    once you believe the fix is deployed. Longer support is
                    available under a remediation retainer.
                </p>
            </div>
        </details>

        <details class="bv-bb-faq__item bv-card">
            <summary class="bv-bb-faq__question">
                <span>Can you provide a certificate of insurance or W-9?</span>
                <span class="bv-bb-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
            </summary>
            <div class="bv-bb-faq__answer">
                <p>
                    Yes, on request. W-9 is standard. Professional liability and
                    errors & omissions coverage available through my insurance
                    carrier — certificates issued to your legal entity on request.
                </p>
            </div>
        </details>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-bb-cta" aria-labelledby="bb-cta-title">

    <div class="bv-bb-cta__inner">

        <span class="bv-bb-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-bb-cta__title bv-font-viking-display" id="bb-cta-title">
            Let's find out what's hiding in your attack surface.
        </h2>

        <p class="bv-bb-cta__lead">
            Whether you're pre-launch, mid-audit, or just want to know if your
            security posture is what you think it is — reach out. Scoping call
            is free. NDA-friendly. Encrypted channels available.
        </p>

        <div class="bv-bb-cta__actions">
            <a href="/contact?engagement=scoping" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Schedule Scoping Call</span>
            </a>
            <a href="/portfolio" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span>See Past Work</span>
            </a>
        </div>

        <div class="bv-bb-cta__meta">
            <span class="bv-bb-cta__meta-item">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>PGP: security@beardedviking.org</span>
            </span>
            <span class="bv-bb-cta__meta-item">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <span>Response within 72 hours</span>
            </span>
            <span class="bv-bb-cta__meta-item">
                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                <span>NDA-friendly</span>
            </span>
        </div>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>