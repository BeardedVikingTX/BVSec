<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — About the Operator
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      about.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'About — The Operator Behind the Forge',
    'description' => 'BeardedVikingTX: OSCP, CEH, Ph.D. C.S. Bug bounty hunter, full-stack engineer, privacy advocate, father. This is the story behind BVSec.',
    'canonical'   => '/about',
    'og_image'    => '/assets/images/og/about.png',
    'body_class'  => 'page-about',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main id="main-content" class="bv-main bv-about-page">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO — THE MAN BEHIND THE BEARD
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-about-hero" id="about-hero" aria-labelledby="about-hero-title">

    <div class="bv-about-hero__bg" aria-hidden="true">
        <div class="bv-about-hero__vignette"></div>
        <div class="bv-about-hero__aurora"></div>
        <div class="bv-about-hero__grid"></div>
    </div>

    <div class="bv-about-hero__runes bv-about-hero__runes--left" aria-hidden="true">
        <span>ᛒ</span><span>ᛖ</span><span>ᚨ</span><span>ᚱ</span><span>ᛞ</span><span>ᛖ</span><span>ᛞ</span>
    </div>
    <div class="bv-about-hero__runes bv-about-hero__runes--right" aria-hidden="true">
        <span>ᚹ</span><span>ᛁ</span><span>ᚲ</span><span>ᛁ</span><span>ᚾ</span><span>ᚷ</span>
    </div>

    <div class="bv-about-hero__inner">

        <span class="bv-section__eyebrow bv-about-hero__eyebrow">
            ᛫ The Operator · Section 00 ᛫
        </span>

        <h1 class="bv-about-hero__title" id="about-hero-title">
            <span class="bv-about-hero__title-runes" aria-hidden="true">ᛒᚹᛊᛖᚲ</span>
            <span class="bv-about-hero__title-name">BeardedVikingTX</span>
            <span class="bv-about-hero__title-tagline">
                <span class="bv-about-hero__title-word">Hacker.</span>
                <span class="bv-about-hero__title-word">Coder.</span>
                <span class="bv-about-hero__title-word bv-about-hero__title-word--accent">Father.</span>
            </span>
        </h1>

        <p class="bv-about-hero__lead">
            I break things for a living and build things for a reason. This page isn't
            a résumé — it's a confession, a manifesto, and a receipt. If you're going
            to trust me with your code, your data, or your company, you deserve to
            know exactly who I am.
        </p>

        <div class="bv-about-hero__meta">
            <div class="bv-about-hero__meta-item">
                <span class="bv-about-hero__meta-key">LOCATION</span>
                <span class="bv-about-hero__meta-value">Texas, USA</span>
            </div>
            <div class="bv-about-hero__meta-item">
                <span class="bv-about-hero__meta-key">STATUS</span>
                <span class="bv-about-hero__meta-value bv-about-hero__meta-value--live">
                    <span class="bv-about-hero__meta-dot"></span> ACTIVE
                </span>
            </div>
            <div class="bv-about-hero__meta-item">
                <span class="bv-about-hero__meta-key">SINCE</span>
                <span class="bv-about-hero__meta-value">2014</span>
            </div>
            <div class="bv-about-hero__meta-item">
                <span class="bv-about-hero__meta-key">MISSION</span>
                <span class="bv-about-hero__meta-value">Make it harder to break</span>
            </div>
        </div>

        <div class="bv-about-hero__scroll" aria-hidden="true">
            <span class="bv-about-hero__scroll-rune">ᛝ</span>
            <span class="bv-about-hero__scroll-text">READ THE CHRONICLE</span>
            <span class="bv-about-hero__scroll-line"></span>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // ORIGIN — THE MAKING OF A VIKING
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-about-origin" id="origin" aria-labelledby="origin-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // ORIGIN STORY</span>
        <h2 class="bv-section__title" id="origin-title">
            Before the forge, <span class="bv-text-gradient">there was fire.</span>
        </h2>
        <p class="bv-section__lead">
            Every hacker has an origin story. Mine starts with curiosity, a broken
            computer, and a stubborn refusal to accept that "it just works that way."
        </p>
    </div>

    <div class="bv-about-origin__grid">

        <div class="bv-about-origin__narrative">

            <p class="bv-about-origin__dropcap">
                I grew up in a household where things were fixed, not replaced. When
                a computer broke, we didn't buy a new one — we opened it up, learned
                how it worked, and made it work again. That mindset never left me.
                By the time I was a teenager, I'd taught myself more about operating
                systems than most adults I knew. By the time I was in college, I'd
                taught myself more about breaking them.
            </p>

            <p>
                The first vulnerability I ever found was accidental. A login form on a
                school system that accepted empty passwords if you knew which field to
                leave blank. I didn't exploit it — I reported it. The admin told me I
                was wrong. Then I showed him the proof-of-concept. Then he fixed it.
                Then he offered me an internship.
            </p>

            <p>
                That moment shaped everything that followed. <strong>The bug isn't the
                point. The point is the fix. The point is telling the right person so
                it gets closed before someone else finds it and weaponizes it.</strong>
                That's not "hacking." That's responsible disclosure. That's what I've
                built my entire career around.
            </p>

            <div class="bv-about-origin__pullquote bv-font-viking-accent">
                <span class="bv-about-origin__pullquote-mark" aria-hidden="true">ᛝ</span>
                <blockquote>
                    The bug you find and report is worth ten you find and sell.
                    The first makes you a hunter. The second makes you a target.
                </blockquote>
                <cite>— BeardedVikingTX</cite>
            </div>

            <p>
                I didn't come from money. I didn't come from a family of engineers.
                I came from a place where you earned what you had, and you learned
                what you needed, because nobody was going to hand it to you. That's
                still how I operate. If I don't know something, I learn it. If a tool
                doesn't exist, I build it. If a system is broken, I fix it — or I
                tell the people who can.
            </p>

            <p>
                The "Bearded Viking" nickname came later, from a friend who watched
                me spend three days straight reverse-engineering an obfuscated
                JavaScript bundle for a bug bounty. When I finally broke it open,
                he said I looked like a Viking who'd been at sea for a month —
                beard grown out, eyes wild, and absolutely refusing to give up
                the raid. The name stuck. The beard stayed.
            </p>

        </div>

        <aside class="bv-about-origin__side">

            <div class="bv-about-origin__fact bv-card">
                <div class="bv-about-origin__fact-icon" aria-hidden="true">
                    <i class="fa-solid fa-terminal"></i>
                </div>
                <h3 class="bv-font-viking-heading">First Language</h3>
                <p class="bv-about-origin__fact-value bv-font-mono">BASIC</p>
                <p class="bv-about-origin__fact-desc">
                    Learned on a Commodore 64 that a neighbor was throwing away. Wrote
                    my first program — a text adventure game — before I learned to
                    spell "adventure" correctly.
                </p>
            </div>

            <div class="bv-about-origin__fact bv-card">
                <div class="bv-about-origin__fact-icon" aria-hidden="true">
                    <i class="fa-solid fa-bug"></i>
                </div>
                <h3 class="bv-font-viking-heading">First Bug Reported</h3>
                <p class="bv-about-origin__fact-value bv-font-mono">age 16</p>
                <p class="bv-about-origin__fact-desc">
                    Authentication bypass on a school portal. Reported it. Was told I
                    was wrong. Proved it. Was offered a job. The rest is the rest.
                </p>
            </div>

            <div class="bv-about-origin__fact bv-card">
                <div class="bv-about-origin__fact-icon" aria-hidden="true">
                    <i class="fa-brands fa-linux"></i>
                </div>
                <h3 class="bv-font-viking-heading">First Linux Distro</h3>
                <p class="bv-about-origin__fact-value bv-font-mono">Ubuntu 8.04</p>
                <p class="bv-about-origin__fact-desc">
                    2008. "Hardy Heron." Installed it, broke the bootloader, spent a
                    weekend fixing it, fell in love with the terminal, and never
                    looked back.
                </p>
            </div>

            <div class="bv-about-origin__fact bv-card">
                <div class="bv-about-origin__fact-icon" aria-hidden="true">
                    <i class="fa-solid fa-debian"></i>
                </div>
                <h3 class="bv-font-viking-heading">Current Daily Driver</h3>
                <p class="bv-about-origin__fact-value bv-font-mono">Debian Testing</p>
                <p class="bv-about-origin__fact-desc">
                    Because stability isn't a feature. It's the foundation. And Testing
                    is where stability is forged.
                </p>
            </div>

        </aside>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // THE HACKER CHRONICLE — VISUAL TIMELINE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-chronicle" id="chronicle" aria-labelledby="chronicle-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // THE HACKER CHRONICLE</span>
        <h2 class="bv-section__title" id="chronicle-title">
            A decade in the trenches, <span class="bv-text-gradient">year by year.</span>
        </h2>
        <p class="bv-section__lead">
            Not every year was a victory. Not every project shipped on time. But every
            single one taught me something the books couldn't. Here's the timeline of
            the man behind the forge.
        </p>
    </div>

    <ol class="bv-chronicle__timeline" role="list">

        <li class="bv-chronicle__era" data-era="0">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2014</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Beginning</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚠ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    Ph.D. Awarded · The Academic Foundation
                </h3>
                <p>
                    Graduated from Ashley University with a Ph.D. in Computer Science.
                    Four years of research, teaching, and late nights in the lab
                    shaped the rigor that still defines every audit I run. Academia
                    taught me how to read between the lines of a paper. The industry
                    taught me how to read between the lines of a commit log.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">Ph.D. C.S.</span>
                    <span class="bv-badge">Research</span>
                    <span class="bv-badge">Teaching</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era" data-era="1">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2015</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Pivot</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚢ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    First Professional Bug Bounty Payout
                </h3>
                <p>
                    Submitted a critical IDOR to a Fortune 500 retail platform. It
                    leaked customer order data across accounts. The fix went out in
                    72 hours. The bounty check arrived three weeks later. I quit my
                    desk job the day after. This was the moment I knew I could do
                    this for a living — and I've been doing it ever since.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">IDOR</span>
                    <span class="bv-badge">Responsible Disclosure</span>
                    <span class="bv-badge">First Payout</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era" data-era="2">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2017</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Credentials</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚦ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    OSCP + CEH · The Certification Vault
                </h3>
                <p>
                    Passed the OSCP exam on the first attempt — 24 hours, hands-on,
                    five machines to root, no multiple choice. The CEH came the same
                    year. These weren't résumé-padding exercises; they were proof
                    that I could do the work under pressure, with a clock running,
                    and no hints. The certifications opened doors. The skills kept
                    them open.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">OSCP</span>
                    <span class="bv-badge">CEH</span>
                    <span class="bv-badge">Certified</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era" data-era="3">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2019</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Forge</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚨ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    BVSec Founded · Security-First Development
                </h3>
                <p>
                    Bug bounties paid the bills, but clients kept asking: "Can you
                    build it too?" The answer became yes. BVSec started as a
                    one-man operation shipping security-hardened web applications
                    — the kind of code I wished every bug bounty target had been
                    built with. Within two years, the client list filled itself.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">BVSec Founded</span>
                    <span class="bv-badge">Custom Dev</span>
                    <span class="bv-badge">Full-Stack</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era" data-era="4">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2021</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Mobile Era</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚱ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    Native Android & iOS · The Mobile Frontier
                </h3>
                <p>
                    Web wasn't enough. Clients needed native mobile apps with the
                    same security discipline. So I learned Kotlin, then Swift,
                    then how to build for both platforms without ever reaching for
                    a hybrid wrapper. Today every BVSec mobile app ships with
                    hardware-backed keystores, certificate pinning, and full RASP
                    integration from day one.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">Kotlin</span>
                    <span class="bv-badge">Swift</span>
                    <span class="bv-badge">Native Apps</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era" data-era="5">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">2026</span>
                <span class="bv-chronicle__era-dot" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Citadel</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᚲ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    MyCitadel Begins · Privacy Reclaimed
                </h3>
                <p>
                    Started designing a social platform that doesn't sell its users.
                    Zero ads. Zero tracking. Zero data brokers. Source code public
                    for anyone to audit. It seemed impossible until it wasn't.
                    MyCitadel went from idea to prototype to a live web platform
                    in fourteen months — with a mobile launch imminent.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">MyCitadel</span>
                    <span class="bv-badge">Privacy-First</span>
                    <span class="bv-badge">Live Web</span>
                </div>
            </div>
        </li>

        <li class="bv-chronicle__era bv-chronicle__era--present" data-era="6">
            <div class="bv-chronicle__era-marker">
                <span class="bv-chronicle__era-year bv-font-sci-display">NOW</span>
                <span class="bv-chronicle__era-dot bv-chronicle__era-dot--live" aria-hidden="true"></span>
            </div>
            <div class="bv-chronicle__era-body bv-card bv-chronicle__era-body--present">
                <div class="bv-chronicle__era-header">
                    <span class="bv-chronicle__era-label bv-font-sci-label">The Present</span>
                    <span class="bv-chronicle__era-rune bv-font-runic" aria-hidden="true">ᛗ</span>
                </div>
                <h3 class="bv-chronicle__era-title bv-font-viking-heading">
                    Still Hunting · Still Forging · Still Here
                </h3>
                <p>
                    BVSec is a one-man forge by design — no bureaucracy, no
                    handoffs, no account managers between you and the person
                    actually doing the work. Every bug reported, every app
                    shipped, every platform launched comes from the same
                    keyboard. If you hire BVSec, you hire the Viking.
                </p>
                <div class="bv-chronicle__era-tags">
                    <span class="bv-badge">Live</span>
                    <span class="bv-badge">Available</span>
                    <span class="bv-badge">One-Man Forge</span>
                </div>
            </div>
        </li>

    </ol>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // THE CREDENTIALS — DEEP DIVE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-creds" id="credentials" aria-labelledby="creds-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // THE CREDENTIALS</span>
        <h2 class="bv-section__title" id="creds-title">
            Not just paper. <span class="bv-text-gradient">Proof of the work.</span>
        </h2>
        <p class="bv-section__lead">
            Certifications and degrees aren't the point — the work is. But they matter
            because they're external validation that the work was done right. Here's
            what each one actually represents, and why it's still current.
        </p>
    </div>

    <div class="bv-creds__grid">

        <article class="bv-creds__card bv-card bv-creds__card--oscp">
            <div class="bv-creds__card-header">
                <div class="bv-creds__card-badge bv-font-sci-display">OSCP</div>
                <span class="bv-creds__card-status bv-creds__card-status--renewal bv-font-sci-label">
                    ⚠ RENEWAL IN PROGRESS
                </span>
            </div>
            <h3 class="bv-creds__card-title bv-font-viking-heading">
                Offensive Security Certified Professional
            </h3>
            <p class="bv-creds__card-body">
                The gold standard for hands-on penetration testing. A 24-hour practical
                exam where you're given a live network and told to break in. No multiple
                choice. No partial credit. You either root the machines or you don't.
            </p>
            <ul class="bv-creds__card-list">
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Issued by OffSec (formerly Offensive Security)</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Requires 24-hour hands-on lab exam passage</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Recognized globally as the pentest practitioner standard</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Renewal requires continuing education credits</span>
                </li>
            </ul>
        </article>

        <article class="bv-creds__card bv-card bv-creds__card--ceh">
            <div class="bv-creds__card-header">
                <div class="bv-creds__card-badge bv-font-sci-display">CEH</div>
                <span class="bv-creds__card-status bv-creds__card-status--renewal bv-font-sci-label">
                    ⚠ RENEWAL IN PROGRESS
                </span>
            </div>
            <h3 class="bv-creds__card-title bv-font-viking-heading">
                Certified Ethical Hacker
            </h3>
            <p class="bv-creds__card-body">
                EC-Council's flagship certification covering the full spectrum of
                ethical hacking methodology, tooling, and countermeasures. Where OSCP
                proves you can break in, CEH proves you understand the entire discipline
                — reconnaissance through reporting.
            </p>
            <ul class="bv-creds__card-list">
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Issued by EC-Council</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>ANSI-accredited, DoD 8570-compliant</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Requires 120 ECE credits every 3 years to renew</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Covers 20+ attack modules and defensive countermeasures</span>
                </li>
            </ul>
        </article>

        <article class="bv-creds__card bv-card bv-creds__card--phd">
            <div class="bv-creds__card-header">
                <div class="bv-creds__card-badge bv-font-sci-display">Ph.D.</div>
                <span class="bv-creds__card-status bv-creds__card-status--active bv-font-sci-label">
                    ✓ AWARDED 2014
                </span>
            </div>
            <h3 class="bv-creds__card-title bv-font-viking-heading">
                Doctor of Philosophy · Computer Science
            </h3>
            <p class="bv-creds__card-body">
                Ashley University, 2014. Four years of research, publication, teaching,
                and the discipline of defending an original thesis in front of a
                committee of experts. The degree is the paper. The skill is the rigor
                it taught me — how to read a system critically, question assumptions,
                and prove a claim before publishing it.
            </p>
            <ul class="bv-creds__card-list">
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Ashley University · Class of 2014</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Focus: applied cryptography & systems security</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>The academic foundation under the practical work</span>
                </li>
                <li>
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    <span>Peer-reviewed research contributions</span>
                </li>
            </ul>
        </article>

    </div>

    <div class="bv-creds__note">
        <div class="bv-creds__note-icon" aria-hidden="true">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div class="bv-creds__note-body">
            <h4 class="bv-font-viking-heading">A note on renewals</h4>
            <p>
                OSCP and CEH renew on a 3-year cycle with continuing education credits.
                Both renewals are currently in progress — continuing education and
                maintenance fees remain current through the next renewal window.
                If you need certified-status verification for a compliance audit,
                reach out and I'll provide the current credentials on request.
            </p>
        </div>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     04 // PHILOSOPHY — THE PRINCIPLES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-philosophy" id="philosophy" aria-labelledby="philosophy-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // PHILOSOPHY</span>
        <h2 class="bv-section__title" id="philosophy-title">
            The principles I won't <span class="bv-text-gradient">negotiate on.</span>
        </h2>
        <p class="bv-section__lead">
            Everyone has a mission statement. Mine is written in commits, disclosures,
            and design decisions. Here are the values that shape every project — whether
            I'm hunting a bug or building a platform.
        </p>
    </div>

    <div class="bv-philosophy__grid">

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">I</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Security is not a feature. It's a foundation.
                </h3>
                <p>
                    You don't add authentication at the end. You don't "harden later."
                    You don't decide whether to add rate limiting based on budget. Every
                    project ships with the same security baseline — OWASP headers, CSP
                    nonces, prepared statements, CSRF tokens, encrypted secrets, least
                    privilege — because those aren't optional features. They're the
                    floor you build the house on.
                </p>
            </div>
        </article>

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">II</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Your data is not mine to sell.
                </h3>
                <p>
                    Every system I build is designed under the assumption that the user's
                    data belongs to the user. No analytics behind their back. No third-party
                    trackers pretending to be "improvements." No dark patterns. If a
                    feature can't be built without harvesting user data, the feature
                    doesn't get built. Period.
                </p>
            </div>
        </article>

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">III</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Report the bug. Don't sell it.
                </h3>
                <p>
                    There's a fork in every researcher's career: weaponize the vulnerability,
                    or report it responsibly. I chose the second path in 2015 and I've never
                    regretted it. The bug I don't exploit is a breach that never happens.
                    The bug I do report is a fix that ships before anyone gets hurt. That's
                    the whole game.
                </p>
            </div>
        </article>

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">IV</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Under-promise. Over-deliver. Every time.
                </h3>
                <p>
                    I'd rather quote you six weeks and ship in five than quote you four
                    weeks and apologize on day 28. Clients don't hire me for the lowest
                    bid. They hire me because the timeline holds, the budget holds, and
                    the thing actually works when it launches. That's not ambition — it's
                    discipline.
                </p>
            </div>
        </article>

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">V</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Ship it or shut up.
                </h3>
                <p>
                    Ideas are cheap. Prototypes are cheap. A shipped product is the only
                    thing that counts. MyCitadel wasn't a pitch deck — it was a live web
                    platform with a mobile app in development. BVSec wasn't a logo — it
                    was a working website with real bug bounty payouts behind it. If it's
                    not shipped, it doesn't exist.
                </p>
            </div>
        </article>

        <article class="bv-philosophy__principle">
            <span class="bv-philosophy__number bv-font-sci-display">VI</span>
            <div class="bv-philosophy__body">
                <h3 class="bv-philosophy__title bv-font-viking-heading">
                    Leave it better than you found it.
                </h3>
                <p>
                    Whether it's a codebase, a client's security posture, or the entire
                    open web — the goal isn't to extract maximum value. It's to leave the
                    system stronger than it was when I arrived. Every bug I close, every
                    app I ship, every platform I launch is a brick in the wall of a
                    slightly better internet.
                </p>
            </div>
        </article>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     05 // THE FAMILY — THE WHY BEHIND THE WORK
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-family" id="family" aria-labelledby="family-title">

    <div class="bv-family__inner">

        <div class="bv-family__content">
            <span class="bv-section__eyebrow">05 // THE WHY BEHIND THE WORK</span>
            <h2 class="bv-section__title bv-font-viking-display" id="family-title">
                Family first. <span class="bv-text-gradient">Everything else after.</span>
            </h2>

            <p class="bv-family__lead">
                There's a version of the tech industry where founders work 80-hour weeks
                and measure their success by how many zeroes are on their valuation. I
                don't live in that version.
            </p>

            <p>
                BVSec is a family-driven operation. That's not marketing language — it's
                a design decision. It means I don't take on more clients than I can serve
                personally. It means I don't chase the biggest check if it means shipping
                something I'd be embarrassed to put my name on. It means the person who
                answers your email is the same person who writes your code, tests your
                security, and shows up on launch day.
            </p>

            <p>
                It also means I work to live, not the other way around. My family comes
                first. My daughter's soccer games don't get rescheduled because a client
                needs a "quick call." If that means I lose a deal occasionally — fine.
                The clients who stay are the ones who understand that a person with a
                life outside the keyboard is a person who brings better work to the
                keyboard.
            </p>

            <div class="bv-family__values">
                <div class="bv-family__value">
                    <i class="fa-solid fa-people-roof" aria-hidden="true"></i>
                    <span>Family-Owned, Family-Driven</span>
                </div>
                <div class="bv-family__value">
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    <span>Sustainable Hours, Sustainable Output</span>
                </div>
                <div class="bv-family__value">
                    <i class="fa-solid fa-handshake" aria-hidden="true"></i>
                    <span>Long-Term Relationships Over Quick Wins</span>
                </div>
            </div>
        </div>

        <aside class="bv-family__aside">
            <div class="bv-family__quote bv-card">
                <span class="bv-family__quote-mark bv-font-viking-accent" aria-hidden="true">ᛝ</span>
                <blockquote class="bv-font-viking-body">
                    I want my daughter to grow up in a world where the technology
                    around her respects her privacy, protects her data, and doesn't
                    treat her like a product. That's not a business goal. That's a
                    dad's goal. But it happens to be the same one.
                </blockquote>
                <cite>— BeardedVikingTX</cite>
            </div>
        </aside>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     06 // THE ARSENAL — TOOLS OF THE TRADE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-arsenal" id="arsenal" aria-labelledby="arsenal-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // THE ARSENAL</span>
        <h2 class="bv-section__title" id="arsenal-title">
            The tools. <span class="bv-text-gradient">The weapons. The workshop.</span>
        </h2>
        <p class="bv-section__lead">
            You can learn a lot about an engineer by their toolbox. Here's mine —
            the languages I speak, the platforms I build on, the systems I live in,
            and the philosophy behind every choice.
        </p>
    </div>

    <div class="bv-arsenal__grid">

        <div class="bv-arsenal__column bv-card">
            <div class="bv-arsenal__column-header">
                <i class="fa-solid fa-code" aria-hidden="true"></i>
                <h3 class="bv-font-viking-heading">Languages</h3>
            </div>
            <ul class="bv-arsenal__list">
                <li><span class="bv-font-mono">C / C++</span><span class="bv-arsenal__list-note">systems & performance</span></li>
                <li><span class="bv-font-mono">C#</span><span class="bv-arsenal__list-note">.NET services & tooling</span></li>
                <li><span class="bv-font-mono">Ruby / Rails</span><span class="bv-arsenal__list-note">rapid prototyping</span></li>
                <li><span class="bv-font-mono">HTML5 / CSS3 / JS</span><span class="bv-arsenal__list-note">the front end</span></li>
                <li><span class="bv-font-mono">PHP 8.2+</span><span class="bv-arsenal__list-note">hardened web apps</span></li>
                <li><span class="bv-font-mono">Kotlin</span><span class="bv-arsenal__list-note">native Android</span></li>
                <li><span class="bv-font-mono">Swift</span><span class="bv-arsenal__list-note">native iOS</span></li>
                <li><span class="bv-font-mono">Python 3</span><span class="bv-arsenal__list-note">tooling & AI/LLM</span></li>
                <li><span class="bv-font-mono">Bash</span><span class="bv-arsenal__list-note">glue that holds it all</span></li>
                <li><span class="bv-font-mono">SQL</span><span class="bv-arsenal__list-note">the language of data</span></li>
            </ul>
        </div>

        <div class="bv-arsenal__column bv-card">
            <div class="bv-arsenal__column-header">
                <i class="fa-solid fa-cloud" aria-hidden="true"></i>
                <h3 class="bv-font-viking-heading">Infrastructure</h3>
            </div>
            <ul class="bv-arsenal__list">
                <li><span class="bv-font-mono">Debian</span><span class="bv-arsenal__list-note bv-arsenal__list-note--primary">primary</span></li>
                <li><span class="bv-font-mono">Ubuntu LTS</span><span class="bv-arsenal__list-note">server fleet</span></li>
                <li><span class="bv-font-mono">RHEL / Rocky</span><span class="bv-arsenal__list-note">enterprise</span></li>
                <li><span class="bv-font-mono">AlmaLinux</span><span class="bv-arsenal__list-note">CentOS successor</span></li>
                <li><span class="bv-font-mono">Arch</span><span class="bv-arsenal__list-note">for the bragging rights</span></li>
            </ul>
            <div class="bv-arsenal__column-divider"></div>
            <ul class="bv-arsenal__list">
                <li><span class="bv-font-mono">DigitalOcean</span><span class="bv-arsenal__list-note">droplets & apps</span></li>
                <li><span class="bv-font-mono">AWS S3</span><span class="bv-arsenal__list-note">object storage</span></li>
                <li><span class="bv-font-mono">Google Cloud</span><span class="bv-arsenal__list-note">compute & AI</span></li>
                <li><span class="bv-font-mono">GitHub Pages</span><span class="bv-arsenal__list-note">static sites</span></li>
                <li><span class="bv-font-mono">Namecheap</span><span class="bv-arsenal__list-note">domains & DNS</span></li>
                <li><span class="bv-font-mono">Heroku</span><span class="bv-arsenal__list-note">PaaS deploys</span></li>
            </ul>
        </div>

        <div class="bv-arsenal__column bv-card">
            <div class="bv-arsenal__column-header">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                <h3 class="bv-font-viking-heading">Security Tooling</h3>
            </div>
            <ul class="bv-arsenal__list">
                <li><span class="bv-font-mono">Burp Suite Pro</span><span class="bv-arsenal__list-note">web pentesting</span></li>
                <li><span class="bv-font-mono">Nmap</span><span class="bv-arsenal__list-note">network mapping</span></li>
                <li><span class="bv-font-mono">Metasploit</span><span class="bv-arsenal__list-note">exploitation</span></li>
                <li><span class="bv-font-mono">Wireshark</span><span class="bv-arsenal__list-note">traffic analysis</span></li>
                <li><span class="bv-font-mono">ffuf / gobuster</span><span class="bv-arsenal__list-note">content discovery</span></li>
                <li><span class="bv-font-mono">sqlmap</span><span class="bv-arsenal__list-note">injection testing</span></li>
                <li><span class="bv-font-mono">nuclei</span><span class="bv-arsenal__list-note">template scanning</span></li>
                <li><span class="bv-font-mono">Ghidra</span><span class="bv-arsenal__list-note">reverse engineering</span></li>
            </ul>
        </div>

        <div class="bv-arsenal__column bv-card">
            <div class="bv-arsenal__column-header">
                <i class="fa-solid fa-robot" aria-hidden="true"></i>
                <h3 class="bv-font-viking-heading">AI / LLM Stack</h3>
            </div>
            <ul class="bv-arsenal__list">
                <li><span class="bv-font-mono">Ollama</span><span class="bv-arsenal__list-note">local inference</span></li>
                <li><span class="bv-font-mono">HuggingFace</span><span class="bv-arsenal__list-note">fine-tuning & hosting</span></li>
                <li><span class="bv-font-mono">LangChain</span><span class="bv-arsenal__list-note">agent frameworks</span></li>
                <li><span class="bv-font-mono">pgvector</span><span class="bv-arsenal__list-note">vector store</span></li>
                <li><span class="bv-font-mono">MCP</span><span class="bv-arsenal__list-note">tool protocol</span></li>
                <li><span class="bv-font-mono">OpenAI / Anthropic</span><span class="bv-arsenal__list-note">as needed, never by default</span></li>
            </ul>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     07 // VIKING HERITAGE — WHY THE NAME
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-heritage" id="heritage" aria-labelledby="heritage-title">

    <div class="bv-heritage__inner">

        <div class="bv-heritage__ornament bv-font-runic" aria-hidden="true">
            <span>ᛒ</span>
            <span>ᚹ</span>
            <span>ᛊ</span>
            <span>ᛖ</span>
            <span>ᚲ</span>
        </div>

        <span class="bv-section__eyebrow">07 // WHY THE VIKING</span>

        <h2 class="bv-section__title bv-font-viking-display" id="heritage-title">
            The name wasn't a marketing decision.
        </h2>

        <p class="bv-heritage__lead bv-font-viking-body">
            "Bearded Viking" started as a joke between friends. It became a philosophy.
        </p>

        <div class="bv-heritage__story">
            <p>
                The Vikings were many things to many people — raiders, traders, explorers,
                settlers, craftsmen. But the thing that history consistently underrates is
                that they were <strong>builders</strong>. They built ships that crossed
                oceans. They built settlements that lasted centuries. They built legal
                systems, trade networks, and societies that reshaped the map of Europe.
            </p>
            <p>
                The Viking approach to any problem is the same approach I take to every
                line of code: understand the terrain, prepare the tools, move deliberately,
                and refuse to quit until the objective is achieved. No shortcuts. No
                half-measures. No going home until the work is done.
            </p>
            <p>
                When I break into a target during a bug bounty engagement, I'm not "hacking."
                I'm conducting a raid — scouting the perimeter, probing for weaknesses,
                striking fast when the opening appears. When I build an application, I'm
                not "coding." I'm forging — heating raw materials into shape, hardening
                the surface, and testing the edge until it holds.
            </p>
            <p>
                The runes you see throughout this site aren't decoration. They're the
                Elder Futhark — the oldest known runic alphabet, used by Germanic peoples
                from the 2nd century onward. I studied them as a teenager, long before I
                ever wrote a line of code. They represent the same thing now that they
                did then: <strong>the power of symbols to communicate meaning across
                distance and time.</strong> Which is, in its way, what code does too.
            </p>
        </div>

        <div class="bv-heritage__runes-table" role="table" aria-label="Runes used on this site and their meanings">
            <div class="bv-heritage__rune-row" role="row">
                <span class="bv-heritage__rune-char bv-font-runic" role="cell">ᛒ</span>
                <span class="bv-heritage__rune-name bv-font-mono" role="cell">Berkanan</span>
                <span class="bv-heritage__rune-meaning" role="cell">Growth, renewal, the beginning of things</span>
            </div>
            <div class="bv-heritage__rune-row" role="row">
                <span class="bv-heritage__rune-char bv-font-runic" role="cell">ᚹ</span>
                <span class="bv-heritage__rune-name bv-font-mono" role="cell">Wunjo</span>
                <span class="bv-heritage__rune-meaning" role="cell">Joy, harmony, the reward of work well done</span>
            </div>
            <div class="bv-heritage__rune-row" role="row">
                <span class="bv-heritage__rune-char bv-font-runic" role="cell">ᛊ</span>
                <span class="bv-heritage__rune-name bv-font-mono" role="cell">Sowilo</span>
                <span class="bv-heritage__rune-meaning" role="cell">The sun, guidance, clarity in darkness</span>
            </div>
            <div class="bv-heritage__rune-row" role="row">
                <span class="bv-heritage__rune-char bv-font-runic" role="cell">ᛖ</span>
                <span class="bv-heritage__rune-name bv-font-mono" role="cell">Ehwaz</span>
                <span class="bv-heritage__rune-meaning" role="cell">Movement, progress, the trust between rider and horse</span>
            </div>
            <div class="bv-heritage__rune-row" role="row">
                <span class="bv-heritage__rune-char bv-font-runic" role="cell">ᚲ</span>
                <span class="bv-heritage__rune-name bv-font-mono" role="cell">Kenaz</span>
                <span class="bv-heritage__rune-meaning" role="cell">The torch, knowledge, the fire of creation</span>
            </div>
        </div>

        <p class="bv-heritage__closing bv-font-viking-accent">
            ᛒᚹᛊᛖᚲ — Bearded Viking Security Forge. Five runes. One mission.
        </p>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     08 // MANIFESTO — THE DECLARATION
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-manifesto" id="manifesto" aria-labelledby="manifesto-title">

    <div class="bv-manifesto__inner">

        <span class="bv-section__eyebrow">08 // THE MANIFESTO</span>

        <h2 class="bv-manifesto__title bv-font-viking-display" id="manifesto-title">
            This is what I stand for.
        </h2>

        <div class="bv-manifesto__content">

            <p class="bv-manifesto__opening bv-font-viking-body">
                I believe that software should serve the people who use it — not the
                companies that build it. I believe that privacy is not a luxury feature
                for the paranoid, but a fundamental right for everyone. I believe that
                security is not a checkbox on a compliance form, but a discipline that
                must be practiced on every line of every commit.
            </p>

            <p>
                I believe that the biggest tech companies have spent the last two
                decades betraying the trust their users placed in them — selling
                attention, harvesting data, and treating human beings as inventory.
                And I believe that the response isn't to give up on technology. It's
                to build better technology, on different terms, with different values.
            </p>

            <p>
                I believe that a single developer with discipline, integrity, and a
                decade of experience can build things that rival the output of a
                well-funded team. Not because that developer is smarter, but because
                that developer doesn't have to compromise with fifteen stakeholders,
                three departments, and a marketing team that doesn't understand the
                product.
            </p>

            <p>
                I believe that the bugs I report make the internet safer. Not in an
                abstract way — in a concrete, measurable way. Every IDOR I close
                protects real customer data. Every SQL injection I patch prevents
                real financial loss. Every authentication bypass I disclose saves
                a real organization from a real breach.
            </p>

            <p>
                I believe that the best way to honor the people who built the
                foundations of computing — the researchers, the engineers, the
                hobbyists, the ones who gave us open protocols and shared knowledge
                without expecting anything in return — is to do the same. To build
                things that make the next generation's work easier. To leave the
                codebase of the world slightly better than I found it.
            </p>

            <p class="bv-manifesto__closing bv-font-viking-display">
                I believe in the forge. In the discipline of the raid. In the patience
                of the long build. And in the simple, stubborn, unglamorous work of
                making things that actually work.
            </p>

            <p class="bv-manifesto__signature bv-font-viking-accent">
                — BeardedVikingTX
                <span class="bv-manifesto__signature-meta bv-font-mono">Texas · 2026</span>
            </p>

        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-about-cta" aria-labelledby="about-cta-title">

    <div class="bv-about-cta__inner">

        <span class="bv-about-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-about-cta__title bv-font-viking-display" id="about-cta-title">
            Now you know who's behind the keyboard.
        </h2>

        <p class="bv-about-cta__lead">
            If any of this resonates — if you want a vulnerability hunter who
            reports instead of exploits, a developer who ships secure by default,
            or a partner who treats your project like it matters — I'd like to
            hear from you.
        </p>

        <div class="bv-about-cta__actions">
            <a href="/contact" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Start a Project</span>
            </a>
            <a href="/services" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-compass" aria-hidden="true"></i>
                <span>See What I Do</span>
            </a>
        </div>

        <p class="bv-about-cta__footnote bv-font-mono">
            Response time: <span class="bv-about-cta__footnote-val">≤ 72 hours</span> ·
            Availability: <span class="bv-about-cta__footnote-val">Open</span> ·
            Location: <span class="bv-about-cta__footnote-val">Texas, USA</span>
        </p>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>