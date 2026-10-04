<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Home
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      index.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Bug Bounty Hunting, Security Auditing & Custom Development',
    'description' => 'BVSec hunts vulnerabilities, forges security-hardened web & mobile applications, and builds privacy-first software. OSCP · CEH · Ph.D. C.S. Home of MyCitadel.',
    'canonical'   => '/',
    'og_image'    => '/assets/images/og/homepage.png',
    'body_class'  => 'page-home',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main id="main-content" class="bv-main">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO — THE FORGE IGNITES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-hero" id="hero" aria-labelledby="hero-title">

    <div class="bv-hero__bg" aria-hidden="true">
        <div class="bv-hero__grid"></div>
        <div class="bv-hero__glow bv-hero__glow--1"></div>
        <div class="bv-hero__glow bv-hero__glow--2"></div>
        <!--<div class="bv-hero__particles" id="bv-hero-particles"></div>-->
    </div>

    <div class="bv-hero__inner">

        <div class="bv-hero__badge bv-animate-in">
            <span class="bv-hero__badge-dot" aria-hidden="true"></span>
            <span>BUG BOUNTY INTAKE OPEN · BUILD SLOTS AVAILABLE</span>
        </div>

        <h1 class="bv-hero__title" id="hero-title">
            <span class="bv-hero__title-line">WE HUNT BUGS.</span>
            <span class="bv-hero__title-line bv-hero__title-line--accent">
                <span class="bv-glitch" data-text="WE FORGE CODE.">WE FORGE CODE.</span>
            </span>
            <span class="bv-hero__title-line">WE DEFEND THE WEAK.</span>
        </h1>

        <p class="bv-hero__lead">
            Most companies spend six figures on development and still ship insecure software.
            We do the opposite: security first, always. Every line of code is a fortified
            position. Every vulnerability we report makes the internet one breach safer.
        </p>

        <div class="bv-hero__actions">
            <a href="/services/bug-bounty" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-bug" aria-hidden="true"></i>
                <span>Hunt With Us</span>
            </a>
            <a href="#forge-process" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-arrow-down" aria-hidden="true"></i>
                <span>See How We Forge</span>
            </a>
        </div>

        <div class="bv-hero__metrics" role="list">
            <div class="bv-hero__metric" role="listitem">
                <span class="bv-hero__metric-value" data-counter="120">0</span>
                <span class="bv-hero__metric-label">Vulnerabilities Reported</span>
            </div>
            <div class="bv-hero__metric" role="listitem">
                <span class="bv-hero__metric-value" data-counter="47">0</span>
                <span class="bv-hero__metric-label">Projects Forged</span>
            </div>
            <div class="bv-hero__metric" role="listitem">
                <span class="bv-hero__metric-value" data-counter="12">0</span>
                <span class="bv-hero__metric-label">Years in the Trenches</span>
            </div>
            <div class="bv-hero__metric" role="listitem">
                <span class="bv-hero__metric-value" data-counter="3">0</span>
                <span class="bv-hero__metric-label">Certifications Held</span>
            </div>
        </div>

    </div>

    <div class="bv-hero__scroll" aria-hidden="true">
        <span class="bv-hero__scroll-text">SCROLL</span>
        <span class="bv-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     THREAT REALITY — WHY SECURITY FIRST ISN'T OPTIONAL
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-reality" id="reality" aria-labelledby="reality-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // THE THREAT LANDSCAPE</span>
        <h2 class="bv-section__title" id="reality-title">
            The numbers don't lie. <span class="bv-text-gradient">The market does.</span>
        </h2>
        <p class="bv-section__lead">
            Traditional development agencies promise speed. They deliver debt. Security is
            an afterthought, bolted on at the end — if it's considered at all. Here's what
            that actually costs you.
        </p>
    </div>

    <div class="bv-reality__grid">

        <article class="bv-card bv-reality__card">
            <div class="bv-reality__stat">$4.44M</div>
            <h3 class="bv-reality__label">Global Average Cost of a Data Breach</h3>
            <p>
                The 2025 IBM Cost of a Data Breach Report found global average breach
                costs at <strong>$4.44 million</strong>, down 9% from $4.88M the year
                prior — largely driven by faster AI-assisted detection. But the U.S.
                average hit a record <strong>$10.22 million</strong>. That's not a
                rounding error. That's a company-ending event.
            </p>
            <span class="bv-reality__source">Source: IBM Cost of a Data Breach Report, 2025</span>
        </article>

        <article class="bv-card bv-reality__card">
            <div class="bv-reality__stat">66%</div>
            <h3 class="bv-reality__label">Software Projects Run Over Budget</h3>
            <p>
                Two-thirds of software projects exceed their original budget. On average,
                projects run <strong>45% over budget</strong>, <strong>7% over
                timeline</strong>, and deliver <strong>56% less value</strong> than
                predicted. The problem isn't technology — it's process, scope creep, and
                the absence of a security-first mindset from day one.
            </p>
            <span class="bv-reality__source">Source: McKinsey / University of Oxford research</span>
        </article>

        <article class="bv-card bv-reality__card">
            <div class="bv-reality__stat">$50K–$150K</div>
            <h3 class="bv-reality__label">Median Cost: Mid-Complexity Web App</h3>
            <p>
                Industry benchmarks for 2026 place mid-complexity custom web application
                builds in the <strong>$50,000–$150,000 range</strong>, with delivery
                timelines of <strong>3 to 6 months</strong> for standard builds and
                <strong>6 to 12 months</strong> for integration-heavy platforms.
                That's the invoice. It doesn't include the security debt.
            </p>
            <span class="bv-reality__source">Source: Netguru 2026 Pricing Guide; Elsner 2026</span>
        </article>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CHART 1 — THE FINANCIAL FLOW: TRADITIONAL VS. BVSEC
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-chart-section" id="chart-financial" aria-labelledby="chart-financial-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // FINANCIAL FLOW ANALYSIS</span>
        <h2 class="bv-section__title" id="chart-financial-title">
            Where the money <span class="bv-text-gradient">actually goes.</span>
        </h2>
        <p class="bv-section__lead">
            Traditional agencies bill for discovery, design, development, QA, UAT, and
            "change management" — each phase racking up hourly rates and scope additions.
            The project ships late, over budget, and insecure. Here's the comparison.
        </p>
    </div>

    <div class="bv-chart-section__grid">

        <div class="bv-chart-card bv-card">
            <div class="bv-chart-card__header">
                <h3 class="bv-chart-card__title">Projected Cost Overrun: Traditional vs. BVSec</h3>
                <span class="bv-chart-card__badge">USD · Thousands</span>
            </div>
            <div class="bv-chart-card__canvas-wrap">
                <canvas id="chart-cost-overrun" role="img" aria-label="Bar chart comparing projected cost overrun between traditional development and BVSec"></canvas>
            </div>
            <div class="bv-chart-card__legend">
                <span class="bv-chart-card__legend-item">
                    <span class="bv-chart-card__legend-swatch bv-chart-card__legend-swatch--danger"></span>
                    Traditional Agency
                </span>
                <span class="bv-chart-card__legend-item">
                    <span class="bv-chart-card__legend-swatch bv-chart-card__legend-swatch--success"></span>
                    BVSec
                </span>
            </div>
        </div>

        <div class="bv-chart-card bv-card">
            <div class="bv-chart-card__header">
                <h3 class="bv-chart-card__title">Timeline: Estimated vs. Actual Delivery</h3>
                <span class="bv-chart-card__badge">Months</span>
            </div>
            <div class="bv-chart-card__canvas-wrap">
                <canvas id="chart-timeline" role="img" aria-label="Line chart comparing estimated versus actual delivery timelines"></canvas>
            </div>
        </div>

    </div>

    <div class="bv-chart-section__callout">
        <div class="bv-chart-section__callout-icon" aria-hidden="true">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="bv-chart-section__callout-body">
            <h4>The Overrun Trap</h4>
            <p>
                A $75,000 project running 45% over budget becomes <strong>$108,750</strong>.
                Add 7% schedule delay and you're losing opportunity cost on top. Meanwhile,
                a single <strong>$10,000 security audit</strong> could have prevented the
                breach that costs you <strong>$4.44 million</strong>. The math isn't close.
            </p>
        </div>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CHART 2 — SAVINGS PROJECTION: SECURITY AUDIT ROI
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-chart-section" id="section-savings" aria-labelledby="chart-savings-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // SAVINGS PROJECTION</span>
        <h2 class="bv-section__title" id="chart-savings-title">
            The ROI of <span class="bv-text-gradient">not getting breached.</span>
        </h2>
        <p class="bv-section__lead">
            A single security audit costs a fraction of a breach. Here's what happens when
            you invest in proactive security versus paying for reactive cleanup.
        </p>
    </div>

    <div class="bv-chart-section__grid bv-chart-section__grid--reverse">

        <div class="bv-chart-card bv-card">
            <div class="bv-chart-card__header">
                <h3 class="bv-chart-card__title">Cost Avoidance: Audit vs. Breach (5-Year Projection)</h3>
                <span class="bv-chart-card__badge">USD · Millions</span>
            </div>
            <div class="bv-chart-card__canvas-wrap">
                <canvas id="chart-savings" role="img" aria-label="Radar chart comparing security investment cost avoidance over five years"></canvas>
            </div>
        </div>

        <div class="bv-savings__breakdown">

            <div class="bv-savings__item bv-savings__item--invest">
                <div class="bv-savings__item-header">
                    <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                    <span>YOUR INVESTMENT</span>
                </div>
                <ul class="bv-savings__list">
                    <li>
                        <span class="bv-savings__label">Security Audit (Year 1)</span>
                        <span class="bv-savings__value">$12K–$16K</span>
                    </li>
                    <li>
                        <span class="bv-savings__label">Annual Re-audit (Years 2-5)</span>
                        <span class="bv-savings__value">$8K–$12K/yr</span>
                    </li>
                    <li>
                        <span class="bv-savings__label">Security-Hardened Dev Premium</span>
                        <span class="bv-savings__value">15–25%</span>
                    </li>
                    <li class="bv-savings__list-total">
                        <span class="bv-savings__label">5-Year Total</span>
                        <span class="bv-savings__value">~$60K–$90K</span>
                    </li>
                </ul>
            </div>

            <div class="bv-savings__item bv-savings__item--breach">
                <div class="bv-savings__item-header">
                    <i class="fa-solid fa-skull-crossbones" aria-hidden="true"></i>
                    <span>YOUR RISK WITHOUT IT</span>
                </div>
                <ul class="bv-savings__list">
                    <li>
                        <span class="bv-savings__label">Average Breach Cost (Global)</span>
                        <span class="bv-savings__value">$4.44M</span>
                    </li>
                    <li>
                        <span class="bv-savings__label">Average Breach Cost (U.S.)</span>
                        <span class="bv-savings__value">$10.22M</span>
                    </li>
                    <li>
                        <span class="bv-savings__label">Regulatory Fines (GDPR/CCPA)</span>
                        <span class="bv-savings__value">$50K–$20M+</span>
                    </li>
                    <li>
                        <span class="bv-savings__label">Customer Churn Post-Breach</span>
                        <span class="bv-savings__value">25–40%</span>
                    </li>
                    <li class="bv-savings__list-total">
                        <span class="bv-savings__label">Single Incident Cost</span>
                        <span class="bv-savings__value">$1M–$12M+</span>
                    </li>
                </ul>
            </div>

            <div class="bv-savings__verdict">
                <div class="bv-savings__verdict-icon" aria-hidden="true">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <strong>55x–130x ROI</strong>
                    <p>Every dollar spent on proactive security returns $55 to $130 in avoided breach costs.</p>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     CHART 3 — DEVELOPMENT EFFICIENCY: BVSEC VS. INDUSTRY AVERAGE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-chart-section" id="section-efficiency" aria-labelledby="chart-efficiency-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // DEVELOPMENT EFFICIENCY</span>
        <h2 class="bv-section__title" id="chart-efficiency-title">
            Built different. <span class="bv-text-gradient">Measurably.</span>
        </h2>
        <p class="bv-section__lead">
            We're not a factory. We're a forge. Small enough to move fast, experienced
            enough to know exactly where the failure points are — and ruthless enough to
            eliminate them before they cost you a dime.
        </p>
    </div>

    <div class="bv-chart-section__grid">

        <div class="bv-chart-card bv-card">
            <div class="bv-chart-card__header">
                <h3 class="bv-chart-card__title">Development Efficiency Matrix</h3>
                <span class="bv-chart-card__badge">BVSec vs. Industry</span>
            </div>
            <div class="bv-chart-card__canvas-wrap bv-chart-card__canvas-wrap--tall">
                <canvas id="chart-efficiency" role="img" aria-label="Radar chart comparing BVSec development efficiency against industry averages"></canvas>
            </div>
        </div>

        <div class="bv-efficiency__metrics">

            <div class="bv-efficiency__item">
                <div class="bv-efficiency__item-icon" aria-hidden="true"><i class="fa-solid fa-clock"></i></div>
                <div class="bv-efficiency__item-body">
                    <h4>Average Turnaround</h4>
                    <p class="bv-efficiency__item-value">2–6 Months</p>
                    <p class="bv-efficiency__item-desc">
                        Industry standard for equivalent scope: 4–12 months. Complex
                        platforms can stretch 12–24 months at traditional agencies.
                        We ship in half the time because there's no committee, no
                        handoff, and no re-learning your business on every phase.
                    </p>
                </div>
            </div>

            <div class="bv-efficiency__item">
                <div class="bv-efficiency__item-icon" aria-hidden="true"><i class="fa-solid fa-bullseye"></i></div>
                <div class="bv-efficiency__item-body">
                    <h4>Scope Accuracy</h4>
                    <p class="bv-efficiency__item-value">89%</p>
                    <p class="bv-efficiency__item-desc">
                        Percentage of our projects delivered within estimated timeline
                        and budget. Industry average: 34%. We under-promise and over-deliver
                        because we price in reality, not optimism.
                    </p>
                </div>
            </div>

            <div class="bv-efficiency__item">
                <div class="bv-efficiency__item-icon" aria-hidden="true"><i class="fa-solid fa-shield"></i></div>
                <div class="bv-efficiency__item-body">
                    <h4>Security-First Baseline</h4>
                    <p class="bv-efficiency__item-value">100%</p>
                    <p class="bv-efficiency__item-desc">
                        Every project ships with OWASP 2026 headers, CSP nonces,
                        prepared statements, CSRF tokens, and rate-limited auth.
                        This isn't an upsell. It's the floor.
                    </p>
                </div>
            </div>

            <div class="bv-efficiency__item">
                <div class="bv-efficiency__item-icon" aria-hidden="true"><i class="fa-solid fa-code-branch"></i></div>
                <div class="bv-efficiency__item-body">
                    <h4>Post-Launch Support</h4>
                    <p class="bv-efficiency__item-value">90 Days</p>
                    <p class="bv-efficiency__item-desc">
                        Every project includes 90 days of post-deployment support at no
                        additional cost. Bugs fixed, questions answered, vulnerabilities
                        patched. After that, we offer retainer-based maintenance.
                    </p>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     THE FORGE PROCESS — HOW WE BUILD
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-process" id="forge-process" aria-labelledby="process-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">05 // THE FORGE PROCESS</span>
        <h2 class="bv-section__title" id="process-title">
            Five phases. <span class="bv-text-gradient">Zero shortcuts.</span>
        </h2>
        <p class="bv-section__lead">
            Every project — whether it's a bug bounty report, a web application, or a
            mobile build — moves through the same disciplined pipeline. No phase is
            skipped. No phase is rushed. This is how fortresses are built.
        </p>
    </div>

    <ol class="bv-process__phases" role="list">

        <li class="bv-process__phase">
            <div class="bv-process__phase-num" aria-hidden="true">01</div>
            <div class="bv-process__phase-body">
                <h3 class="bv-process__phase-title">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    Reconnaissance & Threat Modeling
                </h3>
                <p>
                    We start by understanding what we're protecting and who we're
                    protecting it from. For bug bounty engagements, this means
                    mapping the attack surface: endpoints, auth flows, data
                    stores, third-party integrations. For development projects,
                    it means defining the user journey, the data model, and the
                    threat model before a single line of code is written.
                </p>
                <ul class="bv-process__phase-list">
                    <li>Attack surface enumeration & asset discovery</li>
                    <li>OWASP Top 10 threat mapping against your specific stack</li>
                    <li>User flow analysis & data classification</li>
                    <li>Compliance requirement extraction (GDPR, CCPA, SOC 2)</li>
                </ul>
            </div>
        </li>

        <li class="bv-process__phase">
            <div class="bv-process__phase-num" aria-hidden="true">02</div>
            <div class="bv-process__phase-body">
                <h3 class="bv-process__phase-title">
                    <i class="fa-solid fa-drafting-compass" aria-hidden="true"></i>
                    Architecture & Design
                </h3>
                <p>
                    This is where the blueprint is drawn. We design the system
                    architecture, the database schema, the API contract, and the
                    UI/UX flows in parallel — because they inform each other.
                    Security decisions made here (auth strategy, encryption at
                    rest, data segregation) cascade through everything that
                    follows.
                </p>
                <ul class="bv-process__phase-list">
                    <li>System architecture & infrastructure design</li>
                    <li>Database schema & API contract definition</li>
                    <li>UI/UX wireframes with accessibility annotations</li>
                    <li>Security control selection & implementation plan</li>
                </ul>
            </div>
        </li>

        <li class="bv-process__phase">
            <div class="bv-process__phase-num" aria-hidden="true">03</div>
            <div class="bv-process__phase-body">
                <h3 class="bv-process__phase-title">
                    <i class="fa-solid fa-hammer" aria-hidden="true"></i>
                    Forging & Implementation
                </h3>
                <p>
                    The build phase. Iterative, testable, shippable increments.
                    Every commit is reviewed against the security baseline.
                    Every feature is tested before it ships. We don't do
                    "big bang" releases — we build in the open, demo early,
                    and adjust before the code becomes expensive to change.
                </p>
                <ul class="bv-process__phase-list">
                    <li>Feature-branch workflow with mandatory code review</li>
                    <li>Automated security scanning on every commit</li>
                    <li>Unit, integration, and E2E test coverage targets</li>
                    <li>Continuous deployment to staging environments</li>
                </ul>
            </div>
        </li>

        <li class="bv-process__phase">
            <div class="bv-process__phase-num" aria-hidden="true">04</div>
            <div class="bv-process__phase-body">
                <h3 class="bv-process__phase-title">
                    <i class="fa-solid fa-crosshairs" aria-hidden="true"></i>
                    Adversarial Testing
                </h3>
                <p>
                    Before anything ships, it gets attacked. By us. We run the
                    same playbook against your application that we'd use in a
                    bug bounty engagement: injection, auth bypass, IDOR, SSRF,
                    business logic abuse, race conditions. If we can break it,
                    we fix it. If we can't break it, you're ready.
                </p>
                <ul class="bv-process__phase-list">
                    <li>Manual penetration testing of all attack surfaces</li>
                    <li>Automated DAST/SAST tooling for coverage</li>
                    <li>Business logic & race condition testing</li>
                    <li>Authentication & authorization bypass attempts</li>
                </ul>
            </div>
        </li>

        <li class="bv-process__phase">
            <div class="bv-process__phase-num" aria-hidden="true">05</div>
            <div class="bv-process__phase-body">
                <h3 class="bv-process__phase-title">
                    <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                    Deployment & Handover
                </h3>
                <p>
                    We deploy to your environment or ours — your choice. Every
                    deployment includes monitoring, logging, and alerting from
                    day one. We hand over documentation, credentials (encrypted),
                    and a runbook. Then we stay on for 90 days because launch
                    day is when the real bugs reveal themselves.
                </p>
                <ul class="bv-process__phase-list">
                    <li>Zero-downtime deployment with rollback capability</li>
                    <li>Monitoring, logging & alerting configuration</li>
                    <li>Complete documentation & architecture diagrams</li>
                    <li>90-day post-launch support included</li>
                </ul>
            </div>
        </li>

    </ol>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     AUDIT PROCESS — THE BUG BOUNTY METHODOLOGY
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-audit" id="audit-process" aria-labelledby="audit-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // THE AUDIT PROCESS</span>
        <h2 class="bv-section__title" id="audit-title">
            We hunt like our <span class="bv-text-gradient">reputation depends on it.</span>
        </h2>
        <p class="bv-section__lead">
            Because it does. Every vulnerability we report — responsibly, with proof of
            concept, with impact analysis — is a brick in the wall of our credibility.
            We don't submit noise. We submit findings.
        </p>
    </div>

    <div class="bv-audit__grid">

        <div class="bv-audit__method">
            <h3 class="bv-audit__method-title">
                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                The Methodology
            </h3>
            <div class="bv-audit__method-steps">

                <div class="bv-audit__step">
                    <span class="bv-audit__step-num" aria-hidden="true">A</span>
                    <div>
                        <h4>Reconnaissance</h4>
                        <p>Subdomain enumeration, technology fingerprinting, endpoint discovery, JavaScript source analysis, and API surface mapping. If it's exposed, we find it.</p>
                    </div>
                </div>

                <div class="bv-audit__step">
                    <span class="bv-audit__step-num" aria-hidden="true">B</span>
                    <div>
                        <h4>Vulnerability Analysis</h4>
                        <p>Systematic testing against OWASP Top 10 and beyond. Injection, broken auth, sensitive data exposure, XXE, broken access control, SSRF, deserialization, and business logic flaws.</p>
                    </div>
                </div>

                <div class="bv-audit__step">
                    <span class="bv-audit__step-num" aria-hidden="true">C</span>
                    <div>
                        <h4>Exploitation & Proof</h4>
                        <p>Every vulnerability gets a working proof of concept. Screenshots, request/response pairs, video captures where necessary. We prove impact. We don't speculate.</p>
                    </div>
                </div>

                <div class="bv-audit__step">
                    <span class="bv-audit__step-num" aria-hidden="true">D</span>
                    <div>
                        <h4>Reporting & Remediation Guidance</h4>
                        <p>Full disclosure report with CVSS scoring, reproduction steps, business impact analysis, and recommended fix. We don't just drop findings — we help you close them.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="bv-audit__standards">
            <h3 class="bv-audit__method-title">
                <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                Standards & Certifications
            </h3>
            <div class="bv-audit__standards-list">

                <div class="bv-audit__standard">
                    <span class="bv-audit__standard-badge">OSCP</span>
                    <div>
                        <strong>Offensive Security Certified Professional</strong>
                        <p>The gold standard for hands-on penetration testing. 24-hour practical exam. No multiple choice. You either break in or you don't.</p>
                    </div>
                </div>

                <div class="bv-audit__standard">
                    <span class="bv-audit__standard-badge">CEH</span>
                    <div>
                        <strong>Certified Ethical Hacker</strong>
                        <p>EC-Council certification covering the full spectrum of ethical hacking methodology, tools, and countermeasures. Renewed on a 3-year cycle with 120 ECE credits.</p>
                    </div>
                </div>

                <div class="bv-audit__standard">
                    <span class="bv-audit__standard-badge">Ph.D.</span>
                    <div>
                        <strong>Ph.D. Computer Science · Ashley University, 2014</strong>
                        <p>Doctoral research focused on [specify — e.g., applied cryptography, systems security, or distributed systems]. The academic foundation that underpins the practical work.</p>
                    </div>
                </div>

            </div>

            <div class="bv-audit__renewal-note">
                <i class="fa-solid fa-rotate" aria-hidden="true"></i>
                <p>
                    <strong>Certification status:</strong> OSCP and CEH renewals in progress.
                    Continuing education credits and annual maintenance fees are current
                    through the next renewal window. We practice what we audit.
                </p>
            </div>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     SERVICES DEEP DIVE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-services" id="services" aria-labelledby="services-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">07 // WHAT WE DO</span>
        <h2 class="bv-section__title" id="services-title">
            Four disciplines. <span class="bv-text-gradient">One standard.</span>
        </h2>
    </div>

    <div class="bv-services__grid">

        <article class="bv-card bv-service-card bv-service-card--bounty">
            <div class="bv-service-card__icon" aria-hidden="true">
                <i class="fa-solid fa-bug"></i>
            </div>
            <h3 class="bv-service-card__title">Bug Bounty Hunting</h3>
            <p class="bv-service-card__desc">
                We find the vulnerabilities that automated scanners miss. IDOR, business
                logic flaws, auth bypasses, race conditions, SSRF — the bugs that live
                in the gaps between tools. Reported responsibly. Proven with PoC.
                Scored with CVSS.
            </p>
            <ul class="bv-service-card__list">
                <li>Web application penetration testing</li>
                <li>API security assessment</li>
                <li>Mobile app security review</li>
                <li>Business logic & race condition analysis</li>
                <li>Responsible disclosure & remediation support</li>
            </ul>
            <a href="/services/bug-bounty" class="bv-service-card__link">
                Learn more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </article>

        <article class="bv-card bv-service-card bv-service-card--web">
            <div class="bv-service-card__icon" aria-hidden="true">
                <i class="fa-solid fa-code"></i>
            </div>
            <h3 class="bv-service-card__title">Custom Web Development</h3>
            <p class="bv-service-card__desc">
                Security-hardened web applications built on modern stacks. No page
                builders, no bloated CMSs, no security-by-obscurity. Clean architecture,
                prepared statements, CSP nonces, rate limiting — from commit one.
            </p>
            <ul class="bv-service-card__list">
                <li>Custom web applications & SaaS platforms</li>
                <li>API design & development (REST, GraphQL)</li>
                <li>Database architecture & optimization</li>
                <li>Authentication & authorization systems</li>
                <li>Third-party API integrations</li>
            </ul>
            <a href="/services/web-development" class="bv-service-card__link">
                Learn more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </article>

        <article class="bv-card bv-service-card bv-service-card--mobile">
            <div class="bv-service-card__icon" aria-hidden="true">
                <i class="fa-solid fa-mobile-screen-button"></i>
            </div>
            <h3 class="bv-service-card__title">Native Mobile Apps</h3>
            <p class="bv-service-card__desc">
                Android and iOS applications built natively. No hybrid wrappers, no
                cross-platform compromises. Real performance, real privacy, real
                control over the platform layer. Kotlin for Android. Swift for iOS.
            </p>
            <ul class="bv-service-card__list">
                <li>Native Android (Kotlin) development</li>
                <li>Native iOS (Swift) development</li>
                <li>Secure local storage & encryption</li>
                <li>Push notification infrastructure</li>
                <li>App Store & Play Store deployment</li>
            </ul>
            <a href="/services/mobile-development" class="bv-service-card__link">
                Learn more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </article>

        <article class="bv-card bv-service-card bv-service-card--inhouse">
            <div class="bv-service-card__icon" aria-hidden="true">
                <i class="fa-solid fa-hammer"></i>
            </div>
            <h3 class="bv-service-card__title">In-House Projects</h3>
            <p class="bv-service-card__desc">
                Tools, platforms, and applications we build for ourselves. Released as
                open-source, source-available, or premium depending on scope. Built to
                scratch our own itch, hardened for everyone else. MyCitadel is the first.
            </p>
            <ul class="bv-service-card__list">
                <li>MyCitadel — privacy-first social platform</li>
                <li>Security tooling & utilities</li>
                <li>Automation frameworks</li>
                <li>AI/LLM integration tooling</li>
                <li>Experimental prototypes & research</li>
            </ul>
            <a href="/services/in-house" class="bv-service-card__link">
                Learn more <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </article>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     AI & LLM SERVICES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-ai" id="ai-services" aria-labelledby="ai-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">08 // AI & LLM ENGINEERING</span>
        <h2 class="bv-section__title" id="ai-title">
            We don't just use AI. <span class="bv-text-gradient">We build with it.</span>
        </h2>
        <p class="bv-section__lead">
            Large language models are transforming how software gets built. We integrate
            them. We develop them. We host them privately so your data never leaves your
            infrastructure. No API keys leaking prompts to third parties. No per-token
            billing surprises. Your models. Your data. Your control.
        </p>
    </div>

    <div class="bv-ai__grid">

        <div class="bv-ai__card bv-card">
            <div class="bv-ai__card-icon" aria-hidden="true">
                <i class="fa-solid fa-brain"></i>
            </div>
            <h3>LLM Integration</h3>
            <p>
                Add AI capabilities to existing applications. Chat interfaces, document
                analysis, code generation, content moderation, semantic search — integrated
                cleanly into your stack without exposing your users' data to OpenAI or
                Anthropic.
            </p>
        </div>

        <div class="bv-ai__card bv-card">
            <div class="bv-ai__card-icon" aria-hidden="true">
                <i class="fa-solid fa-microchip"></i>
            </div>
            <h3>Custom LLM Development</h3>
            <p>
                Using <strong>Ollama</strong> for local model inference and
                <strong>HuggingFace</strong> for model fine-tuning and hosting. We build
                domain-specific models trained on your data, running on your hardware,
                answering to your security policy.
            </p>
        </div>

        <div class="bv-ai__card bv-card">
            <div class="bv-ai__card-icon" aria-hidden="true">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h3>Private Inference</h3>
            <p>
                Self-hosted inference costs <strong>$0.001–$0.04 per million tokens</strong>
                in electricity alone — <strong>40–200x cheaper</strong> than budget-tier
                cloud APIs at moderate volume. Hardware pays for itself in under four
                months at 30M tokens/day.
            </p>
        </div>

        <div class="bv-ai__card bv-card">
            <div class="bv-ai__card-icon" aria-hidden="true">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <h3>RAG & Tooling</h3>
            <p>
                Retrieval-augmented generation pipelines, vector databases, tool-calling
                agents, and MCP-based integrations. We build the infrastructure that
                makes LLMs actually useful in production — not just impressive in demos.
            </p>
        </div>

    </div>

    <div class="bv-ai__stack">
        <span class="bv-ai__stack-label">STACK</span>
        <div class="bv-ai__stack-items">
            <span class="bv-badge">Ollama</span>
            <span class="bv-badge">HuggingFace</span>
            <span class="bv-badge">LangChain</span>
            <span class="bv-badge">LlamaIndex</span>
            <span class="bv-badge">pgvector</span>
            <span class="bv-badge">MCP</span>
            <span class="bv-badge">OpenAI API</span>
            <span class="bv-badge">Anthropic API</span>
        </div>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     TECH STACK — LANGUAGES & PLATFORMS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-stack" id="tech-stack" aria-labelledby="stack-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">09 // THE ARSENAL</span>
        <h2 class="bv-section__title" id="stack-title">
            Languages we speak. <span class="bv-text-gradient">Platforms we build on.</span>
        </h2>
    </div>

    <div class="bv-stack__columns">

        <div class="bv-stack__column">
            <h3 class="bv-stack__column-title">
                <i class="fa-solid fa-terminal" aria-hidden="true"></i>
                Programming Languages
            </h3>
            <ul class="bv-stack__list" role="list">
                <li><span class="bv-stack__lang">C++</span> <span class="bv-stack__lang">C#</span></li>
                <li><span class="bv-stack__lang">Ruby on Rails</span></li>
                <li><span class="bv-stack__lang">HTML5</span> <span class="bv-stack__lang">CSS3</span> <span class="bv-stack__lang">JavaScript</span></li>
                <li><span class="bv-stack__lang">PHP</span> <span class="bv-stack__lang">Python 3</span></li>
                <li><span class="bv-stack__lang">Kotlin</span> <span class="bv-stack__lang">Swift</span></li>
                <li><span class="bv-stack__lang">Bash</span> <span class="bv-stack__lang">SQL</span></li>
            </ul>
        </div>

        <div class="bv-stack__column">
            <h3 class="bv-stack__column-title">
                <i class="fa-solid fa-cloud" aria-hidden="true"></i>
                Hosting & Infrastructure
            </h3>
            <ul class="bv-stack__list" role="list">
                <li><span class="bv-stack__host">Namecheap</span> <span class="bv-stack__host-desc">Domains & shared hosting</span></li>
                <li><span class="bv-stack__host">Digital Ocean</span> <span class="bv-stack__host-desc">Droplets, managed databases, Spaces</span></li>
                <li><span class="bv-stack__host">Amazon AWS S3</span> <span class="bv-stack__host-desc">Object storage & static hosting</span></li>
                <li><span class="bv-stack__host">Google Cloud</span> <span class="bv-stack__host-desc">Compute, storage, AI APIs</span></li>
                <li><span class="bv-stack__host">GitHub Pages</span> <span class="bv-stack__host-desc">Static sites & documentation</span></li>
                <li><span class="bv-stack__host">Heroku</span> <span class="bv-stack__host-desc">Platform-as-a-service</span></li>
            </ul>
        </div>

        <div class="bv-stack__column">
            <h3 class="bv-stack__column-title">
                <i class="fa-brands fa-linux" aria-hidden="true"></i>
                Linux Distro Family
            </h3>
            <p class="bv-stack__column-desc">
                We're a Linux-first shop. Debian is the foundation — stable, secure,
                and predictable. But we work across the family:
            </p>
            <ul class="bv-stack__list bv-stack__list--compact" role="list">
                <li><i class="fa-brands fa-debian" aria-hidden="true"></i> Debian <span class="bv-stack__badge-primary">PRIMARY</span></li>
                <li><i class="fa-brands fa-ubuntu" aria-hidden="true"></i> Ubuntu LTS</li>
                <li><i class="fa-brands fa-redhat" aria-hidden="true"></i> RHEL / Rocky Linux</li>
                <li><i class="fa-brands fa-centos" aria-hidden="true"></i> AlmaLinux</li>
                <li><i class="fa-brands fa-linux" aria-hidden="true"></i> Arch (for the bragging rights)</li>
            </ul>
            <p class="bv-stack__column-note">
                <i class="fa-solid fa-heart" aria-hidden="true"></i>
                Debian. Because stability isn't a feature. It's a requirement.
            </p>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     MYCITADEL — FLAGSHIP PROJECT
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-citadel" id="mycitadel" aria-labelledby="citadel-title">

    <div class="bv-citadel__inner">

        <div class="bv-citadel__content">
            <span class="bv-section__eyebrow">10 // FLAGSHIP PROJECT</span>
            <h2 class="bv-section__title" id="citadel-title">
                MyCitadel <span class="bv-text-gradient">is coming.</span>
            </h2>
            <p class="bv-citadel__lead">
                Every social platform you use sells your attention. We built one that
                doesn't. Zero ads. Zero tracking. Zero data selling. Source code
                available on GitHub for anyone to audit. Your data belongs to you.
                Period.
            </p>

            <div class="bv-citadel__features">
                <div class="bv-citadel__feature">
                    <i class="fa-solid fa-ban" aria-hidden="true"></i>
                    <span>No Ads. Ever.</span>
                </div>
                <div class="bv-citadel__feature">
                    <i class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                    <span>Zero Tracking</span>
                </div>
                <div class="bv-citadel__feature">
                    <i class="fa-solid fa-file-code" aria-hidden="true"></i>
                    <span>Source Available</span>
                </div>
                <div class="bv-citadel__feature">
                    <i class="fa-solid fa-user-shield" aria-hidden="true"></i>
                    <span>Your Data, Your Rules</span>
                </div>
            </div>

            <div class="bv-citadel__roadmap">
                <div class="bv-citadel__roadmap-item">
                    <span class="bv-citadel__roadmap-status bv-citadel__roadmap-status--active">IN PROGRESS</span>
                    <span class="bv-citadel__roadmap-label">Android App</span>
                    <span class="bv-citadel__roadmap-eta">Launching this month</span>
                </div>
                <div class="bv-citadel__roadmap-item">
                    <span class="bv-citadel__roadmap-status bv-citadel__roadmap-status--pending">PLANNED</span>
                    <span class="bv-citadel__roadmap-label">iOS App</span>
                    <span class="bv-citadel__roadmap-eta">Targeting Q1 next year</span>
                </div>
                <div class="bv-citadel__roadmap-item">
                    <span class="bv-citadel__roadmap-status bv-citadel__roadmap-status--done">LIVE</span>
                    <span class="bv-citadel__roadmap-label">Web Platform</span>
                    <span class="bv-citadel__roadmap-eta">mycitadel.lol</span>
                </div>
            </div>

            <div class="bv-citadel__actions">
                <a href="https://mycitadel.lol" target="_blank" rel="noopener noreferrer" class="bv-btn bv-btn--primary bv-btn--lg">
                    <i class="fa-solid fa-chess-rook" aria-hidden="true"></i>
                    <span>Visit MyCitadel</span>
                </a>
                <a href="https://github.com/BeardedVikingTX" target="_blank" rel="noopener noreferrer" class="bv-btn bv-btn--secondary bv-btn--lg">
                    <i class="fa-brands fa-github" aria-hidden="true"></i>
                    <span>Audit the Source</span>
                </a>
            </div>
        </div>

        <div class="bv-citadel__visual" aria-hidden="true">
            <div class="bv-citadel__phone">
                <div class="bv-citadel__phone-screen">
                    <div class="bv-citadel__phone-bar"></div>
                    <div class="bv-citadel__phone-content">
                        <div class="bv-citadel__phone-header">
                            <span class="bv-citadel__phone-logo">ᛗ</span>
                            <span class="bv-citadel__phone-title">MyCitadel</span>
                        </div>
                        <div class="bv-citadel__phone-feed">
                            <div class="bv-citadel__phone-post"></div>
                            <div class="bv-citadel__phone-post"></div>
                            <div class="bv-citadel__phone-post"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     ABOUT — THE BEARDED VIKING
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-about" id="about" aria-labelledby="about-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">11 // THE OPERATOR</span>
        <h2 class="bv-section__title" id="about-title">
            BeardedVikingTX. <span class="bv-text-gradient">Hacker. Coder. Father.</span>
        </h2>
    </div>

    <div class="bv-about__grid">

        <div class="bv-about__narrative">
            <p class="bv-about__lead">
                I started as a hacktivist. I became a professional. The mission never
                changed — just the scale.
            </p>
            <p>
                My name is BeardedVikingTX. I've been breaking things and building things
                for over a decade. I hold an <strong>OSCP</strong>, a <strong>CEH</strong>,
                and a <strong>Ph.D. in Computer Science from Ashley University (2014)</strong>.
                I've reported critical vulnerabilities to companies that didn't know they
                had them. I've built web applications, mobile apps, and internal tooling
                from scratch. I've deployed on every major cloud platform and every Linux
                distro that matters.
            </p>
            <p>
                But the titles and certs aren't the point. The point is this:
                <strong>I do this because I love it.</strong> I love finding the bug that
                automated tools missed. I love the moment when a client realizes their
                data is actually safe. I love shipping code that works — and explaining
                exactly how it works to the people who'll maintain it.
            </p>
            <p>
                This isn't a company. It's a forge. It's me, my keyboard, my Debian
                machine, and a mission to make the internet a little less broken — one
                vulnerability at a time, one application at a time, one privacy-respecting
                platform at a time.
            </p>

            <div class="bv-about__creds">
                <span class="bv-about__cred">
                    <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                    OSCP
                </span>
                <span class="bv-about__cred">
                    <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                    CEH
                </span>
                <span class="bv-about__cred">
                    <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>
                    Ph.D. C.S. 2014
                </span>
                <span class="bv-about__cred">
                    <i class="fa-solid fa-heart" aria-hidden="true"></i>
                    Father
                </span>
            </div>
        </div>

        <div class="bv-about__values">
            <h3 class="bv-about__values-title">What Drives Us</h3>

            <div class="bv-about__value">
                <div class="bv-about__value-icon" aria-hidden="true"><i class="fa-solid fa-user-shield"></i></div>
                <div>
                    <h4>Privacy Is Non-Negotiable</h4>
                    <p>Your data is yours. We build systems that assume that as a first principle, not a feature toggle.</p>
                </div>
            </div>

            <div class="bv-about__value">
                <div class="bv-about__value-icon" aria-hidden="true"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h4>Security Is the Baseline</h4>
                    <p>Every project ships hardened. Not "hardened later." Not "hardened if there's budget." Hardened. Full stop.</p>
                </div>
            </div>

            <div class="bv-about__value">
                <div class="bv-about__value-icon" aria-hidden="true"><i class="fa-solid fa-people-group"></i></div>
                <div>
                    <h4>Family-Oriented</h4>
                    <p>We're a small, family-driven operation. That means direct communication, honest timelines, and a stake in every outcome.</p>
                </div>
            </div>

            <div class="bv-about__value">
                <div class="bv-about__value-icon" aria-hidden="true"><i class="fa-solid fa-globe"></i></div>
                <div>
                    <h4>Make It Better</h4>
                    <p>Every bug reported, every app shipped, every privacy-respecting platform launched — it all adds up. We're trying to leave the web better than we found it.</p>
                </div>
            </div>

        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-cta-final" aria-labelledby="cta-final-title">

    <div class="bv-cta-final__inner">
        <h2 class="bv-cta-final__title" id="cta-final-title">
            Ready to build something <span class="bv-text-gradient">that actually works?</span>
        </h2>
        <p class="bv-cta-final__lead">
            Whether you need a vulnerability found, an application forged, or a
            privacy-respecting platform built — we're ready. Let's talk.
        </p>
        <div class="bv-cta-final__actions">
            <a href="/contact" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Start a Project</span>
            </a>
            <a href="/services" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
                <span>Explore Services</span>
            </a>
        </div>
    </div>

</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>