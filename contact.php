<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Contact / Engagement Request
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      contact.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Contact — Start an Engagement',
    'description' => 'Start a project with BVSec. Bug bounty, web development, mobile apps, or in-house work. Tell us about your project and pick up to three call slots. Response within 72 hours.',
    'canonical'   => '/contact.php',
    'og_image'    => '/assets/images/og/contact.png',
    'body_class'  => 'page-contact',
];

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  CSRF + anti-bot tokens
//  Generated per-request; stored in session for validation on submit.
// ──────────────────────────────────────────────────────────────────────────

// Ensure session is available (header.php already starts it).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rotate a fresh CSRF token for every GET of this page.
$csrf_token       = bin2hex(random_bytes(32));
$form_loaded_at   = time();
$form_nonce       = bin2hex(random_bytes(16));

$_SESSION['contact_csrf']        = $csrf_token;
$_SESSION['contact_loaded_at']   = $form_loaded_at;
$_SESSION['contact_nonce']       = $form_nonce;

// Detect pre-fill from query string (e.g. /contact?engagement=scoping)
$prefill_engagement = isset($_GET['engagement'])
    ? preg_replace('/[^a-z0-9_-]/i', '', (string) $_GET['engagement'])
    : '';

// Service options (also used by the backend).
$service_options = [
    'bug-bounty'    => 'Bug Bounty Hunting',
    'web-dev'       => 'Custom Web Development',
    'mobile-dev'    => 'Native Mobile App',
    'in-house'      => 'In-House / Custom Tooling',
    'audit'         => 'Security Audit',
    'other'         => 'Something Else',
];

// Budget ranges.
$budget_ranges = [
    'under-1k'    => 'Under $1,000',
    '1k-5k'       => '$1,000 – $5,000',
    '5k-15k'      => '$5,000 – $15,000',
    '15k-50k'     => '$15,000 – $50,000',
    '50k-100k'    => '$50,000 – $100,000',
    '100k-plus'   => '$100,000+',
    'not-sure'    => 'Not sure yet',
];

// Timeline options.
$timeline_options = [
    'asap'        => 'ASAP (under 1 month)',
    '1-3-months'  => '1–3 months',
    '3-6-months'  => '3–6 months',
    '6-12-months' => '6–12 months',
    '12-plus'     => '12+ months',
    'exploring'   => 'Just exploring',
];

// Timezones we support for scheduling.
$timezones = [
    'America/Chicago'    => 'Central Time (US) — Chicago / Dallas / Fort Worth',
    'America/New_York'   => 'Eastern Time (US) — New York / Boston',
    'America/Denver'     => 'Mountain Time (US) — Denver',
    'America/Los_Angeles'=> 'Pacific Time (US) — Los Angeles',
    'Europe/London'      => 'GMT — London',
    'Europe/Berlin'      => 'CET — Berlin / Paris / Rome',
    'Asia/Tokyo'         => 'JST — Tokyo',
    'Australia/Sydney'   => 'AEST — Sydney',
    'UTC'                => 'UTC — Coordinated Universal Time',
];
?>

<main id="main-content" class="bv-main bv-contact">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-ct-hero" id="ct-hero" aria-labelledby="ct-hero-title">

    <div class="bv-ct-hero__bg" aria-hidden="true">
        <div class="bv-ct-hero__vignette"></div>
        <div class="bv-ct-hero__aurora"></div>
        <div class="bv-ct-hero__grid"></div>
    </div>

    <div class="bv-ct-hero__runes bv-ct-hero__runes--left" aria-hidden="true">
        <span>ᚲ</span><span>ᛟ</span><span>ᚾ</span><span>ᛏ</span><span>ᚨ</span><span>ᚲ</span><span>ᛏ</span>
    </div>
    <div class="bv-ct-hero__runes bv-ct-hero__runes--right" aria-hidden="true">
        <span>ᛊ</span><span>ᛈ</span><span>ᛖ</span><span>ᚨ</span><span>ᚲ</span>
    </div>

    <div class="bv-ct-hero__inner">

        <span class="bv-section__eyebrow">᛫ Engagement Request · Response Within 72 Hours ᛫</span>

        <h1 class="bv-ct-hero__title" id="ct-hero-title">
            <span class="bv-ct-hero__title-runes" aria-hidden="true">ᛊᛈᛖᚨᚲ</span>
            <span class="bv-ct-hero__title-line bv-ct-hero__title-line--viking">Tell Us</span>
            <span class="bv-ct-hero__title-line bv-ct-hero__title-line--accent">
                <span class="bv-glitch" data-text="What You Need.">What You Need.</span>
            </span>
        </h1>

        <p class="bv-ct-hero__lead">
            One form. Complete picture. We'll read every word, respond within
            72 hours, and propose a scoping call at one of the times you
            provide. No auto-responder bots. No sales pressure. Just an
            honest conversation about whether we're the right fit.
        </p>

        <div class="bv-ct-hero__badges">
            <span class="bv-ct-hero__badge">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                PGP Available
            </span>
            <span class="bv-ct-hero__badge">
                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                NDA-Friendly
            </span>
            <span class="bv-ct-hero__badge">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                72h Response
            </span>
            <span class="bv-ct-hero__badge">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                Zero Spam
            </span>
        </div>

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     LOCATIONS BAR
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-ct-locations" aria-label="Our locations">
    <div class="bv-ct-locations__inner">

        <div class="bv-ct-location">
            <div class="bv-ct-location__icon" aria-hidden="true">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="bv-ct-location__body">
                <span class="bv-ct-location__label bv-font-sci-label">Family Base</span>
                <span class="bv-ct-location__name bv-font-viking-heading">Fort Worth, TX</span>
                <span class="bv-ct-location__note">Frequent travel — in-person available by arrangement</span>
            </div>
        </div>

        <div class="bv-ct-location bv-ct-location--primary">
            <div class="bv-ct-location__icon" aria-hidden="true">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="bv-ct-location__body">
                <span class="bv-ct-location__label bv-font-sci-label">Primary Office</span>
                <span class="bv-ct-location__name bv-font-viking-heading">Sullivan, IL</span>
                <span class="bv-ct-location__note">Current location — all remote work operates from here</span>
            </div>
        </div>

    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     THE FORM
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-ct-form-section" id="form" aria-labelledby="ct-form-title">

    <div class="bv-ct-form-section__inner">

        <div class="bv-ct-form-section__intro">
            <span class="bv-section__eyebrow">The Briefing</span>
            <h2 class="bv-section__title" id="ct-form-title">
                Fill in what you can. <span class="bv-text-gradient">Skip what you can't.</span>
            </h2>
            <p class="bv-section__lead">
                Required fields are marked with an asterisk. Everything else
                helps us prepare — but don't stress about the details. The
                scoping call is where we work out the rest.
            </p>
        </div>

        <!-- ═════════ FORM START ═════════ -->
        <form
            class="bv-ct-form"
            id="bv-contact-form"
            method="post"
            action="/api/contact.php"
            novalidate
            autocomplete="on"
        >

            <!-- ── Hidden anti-spam + security fields ── -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="form_nonce" value="<?= htmlspecialchars($form_nonce, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="form_loaded_at" value="<?= (int) $form_loaded_at ?>">
            <input type="hidden" name="js_enabled" id="js-enabled" value="0">
            <input type="hidden" name="referer" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <!-- Honeypot 1: looks like a "website" field, hidden by CSS -->
            <div class="bv-ct-honeypot" aria-hidden="true">
                <label for="website_url">Your Website (leave blank)</label>
                <input
                    type="text"
                    id="website_url"
                    name="website_url"
                    tabindex="-1"
                    autocomplete="off"
                >
            </div>

            <!-- Honeypot 2: looks like email confirmation -->
            <div class="bv-ct-honeypot" aria-hidden="true">
                <label for="email_confirm">Confirm Your Email (leave blank)</label>
                <input
                    type="email"
                    id="email_confirm"
                    name="email_confirm"
                    tabindex="-1"
                    autocomplete="off"
                >
            </div>

            <!-- ═══════════════════════════════════════════════════════════
                 STEP 1 — YOUR IDENTITY
                 ═══════════════════════════════════════════════════════════ -->
            <fieldset class="bv-ct-fieldset">
                <legend class="bv-ct-legend">
                    <span class="bv-ct-legend__num bv-font-mono">01</span>
                    <span class="bv-ct-legend__title bv-font-viking-heading">Your Identity</span>
                    <span class="bv-ct-legend__note">Who's reaching out?</span>
                </legend>

                <div class="bv-ct-grid bv-ct-grid--2">

                    <div class="bv-ct-field bv-ct-field--required">
                        <label for="full_name" class="bv-ct-label">
                            Full Name <span class="bv-ct-required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            class="bv-ct-input"
                            required
                            minlength="2"
                            maxlength="120"
                            autocomplete="name"
                            placeholder="Jane Doe"
                        >
                        <span class="bv-ct-error" data-for="full_name" role="alert"></span>
                    </div>

                    <div class="bv-ct-field">
                        <label for="position" class="bv-ct-label">
                            Position / Title
                        </label>
                        <input
                            type="text"
                            id="position"
                            name="position"
                            class="bv-ct-input"
                            maxlength="120"
                            autocomplete="organization-title"
                            placeholder="CTO, Founder, Product Lead"
                        >
                    </div>

                    <div class="bv-ct-field">
                        <label for="company" class="bv-ct-label">
                            Company / Organization
                        </label>
                        <input
                            type="text"
                            id="company"
                            name="company"
                            class="bv-ct-input"
                            maxlength="160"
                            autocomplete="organization"
                            placeholder="Acme Corp"
                        >
                    </div>

                    <div class="bv-ct-field bv-ct-field--required">
                        <label for="email" class="bv-ct-label">
                            Email <span class="bv-ct-required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="bv-ct-input"
                            required
                            maxlength="254"
                            autocomplete="email"
                            placeholder="jane@company.com"
                        >
                        <span class="bv-ct-error" data-for="email" role="alert"></span>
                    </div>

                    <div class="bv-ct-field bv-ct-field--required">
                        <label for="phone" class="bv-ct-label">
                            Phone <span class="bv-ct-required" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="bv-ct-input"
                            required
                            maxlength="40"
                            autocomplete="tel"
                            placeholder="+1 (555) 123-4567"
                        >
                        <span class="bv-ct-error" data-for="phone" role="alert"></span>
                    </div>

                    <div class="bv-ct-field">
                        <label for="preferred_contact" class="bv-ct-label">
                            Preferred Contact Method
                        </label>
                        <div class="bv-ct-select-wrap">
                            <select
                                id="preferred_contact"
                                name="preferred_contact"
                                class="bv-ct-select"
                            >
                                <option value="email">Email</option>
                                <option value="phone">Phone Call</option>
                                <option value="text">Text Message</option>
                                <option value="any">Any — whatever's fastest</option>
                            </select>
                            <i class="fa-solid fa-chevron-down bv-ct-select-caret" aria-hidden="true"></i>
                        </div>
                    </div>

                </div>
            </fieldset>


            <!-- ═══════════════════════════════════════════════════════════
                 STEP 2 — WHAT YOU NEED
                 ═══════════════════════════════════════════════════════════ -->
            <fieldset class="bv-ct-fieldset">
                <legend class="bv-ct-legend">
                    <span class="bv-ct-legend__num bv-font-mono">02</span>
                    <span class="bv-ct-legend__title bv-font-viking-heading">What You Need</span>
                    <span class="bv-ct-legend__note">Pick all that apply.</span>
                </legend>

                <div class="bv-ct-field bv-ct-field--required">
                    <span class="bv-ct-label" id="services-label">
                        Services of Interest <span class="bv-ct-required" aria-hidden="true">*</span>
                    </span>
                    <div class="bv-ct-services" role="group" aria-labelledby="services-label">
                        <?php foreach ($service_options as $val => $label): ?>
                            <label class="bv-ct-service-chip">
                                <input
                                    type="checkbox"
                                    name="services[]"
                                    value="<?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= $prefill_engagement === $val ? 'checked' : '' ?>
                                >
                                <span class="bv-ct-service-chip__box">
                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                </span>
                                <span class="bv-ct-service-chip__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <span class="bv-ct-error" data-for="services" role="alert"></span>
                </div>

                <div class="bv-ct-field bv-ct-field--required">
                    <label for="project_description" class="bv-ct-label">
                        Project Description <span class="bv-ct-required" aria-hidden="true">*</span>
                    </label>
                    <textarea
                        id="project_description"
                        name="project_description"
                        class="bv-ct-textarea"
                        required
                        minlength="40"
                        maxlength="5000"
                        rows="8"
                        placeholder="Describe what you're building, the problem you're trying to solve, and what success looks like. The more context you give us, the better prepared we'll be for the scoping call."
                    ></textarea>
                    <div class="bv-ct-textarea-meta">
                        <span class="bv-ct-textarea-hint">Minimum 40 characters. Detailed is better.</span>
                        <span class="bv-ct-charcount" data-for="project_description">0 / 5000</span>
                    </div>
                    <span class="bv-ct-error" data-for="project_description" role="alert"></span>
                </div>

                <div class="bv-ct-grid bv-ct-grid--2">

                    <div class="bv-ct-field">
                        <span class="bv-ct-label" id="budget-type-label">Budget Type</span>
                        <div class="bv-ct-radio-group" role="radiogroup" aria-labelledby="budget-type-label">
                            <label class="bv-ct-radio">
                                <input type="radio" name="budget_type" value="fixed" checked>
                                <span class="bv-ct-radio__marker"></span>
                                <span class="bv-ct-radio__label">
                                    <strong>Fixed</strong>
                                    <small>I have a specific number</small>
                                </span>
                            </label>
                            <label class="bv-ct-radio">
                                <input type="radio" name="budget_type" value="flexible">
                                <span class="bv-ct-radio__marker"></span>
                                <span class="bv-ct-radio__label">
                                    <strong>Flexible</strong>
                                    <small>I'm open to proposals</small>
                                </span>
                            </label>
                            <label class="bv-ct-radio">
                                <input type="radio" name="budget_type" value="unsure">
                                <span class="bv-ct-radio__marker"></span>
                                <span class="bv-ct-radio__label">
                                    <strong>Not Sure</strong>
                                    <small>Help me figure it out</small>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="bv-ct-field">
                        <label for="budget_range" class="bv-ct-label">Budget Range</label>
                        <div class="bv-ct-select-wrap">
                            <select id="budget_range" name="budget_range" class="bv-ct-select">
                                <option value="">Select a range (optional)</option>
                                <?php foreach ($budget_ranges as $val => $label): ?>
                                    <option value="<?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fa-solid fa-chevron-down bv-ct-select-caret" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bv-ct-field">
                        <label for="timeline" class="bv-ct-label">Estimated Timeline</label>
                        <div class="bv-ct-select-wrap">
                            <select id="timeline" name="timeline" class="bv-ct-select">
                                <option value="">When do you want this done? (optional)</option>
                                <?php foreach ($timeline_options as $val => $label): ?>
                                    <option value="<?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <i class="fa-solid fa-chevron-down bv-ct-select-caret" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="bv-ct-field">
                        <label for="start_date" class="bv-ct-label">Preferred Start</label>
                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            class="bv-ct-input"
                            min="<?= date('Y-m-d') ?>"
                        >
                    </div>

                </div>

                <div class="bv-ct-field">
                    <label for="referral" class="bv-ct-label">How Did You Hear About Us?</label>
                    <input
                        type="text"
                        id="referral"
                        name="referral"
                        class="bv-ct-input"
                        maxlength="200"
                        placeholder="Google, a friend, HackerOne, GitHub, etc."
                    >
                </div>

            </fieldset>


            <!-- ═══════════════════════════════════════════════════════════
                 STEP 3 — SCHEDULE A CALL
                 ═══════════════════════════════════════════════════════════ -->
            <fieldset class="bv-ct-fieldset">
                <legend class="bv-ct-legend">
                    <span class="bv-ct-legend__num bv-font-mono">03</span>
                    <span class="bv-ct-legend__title bv-font-viking-heading">Schedule a Call</span>
                    <span class="bv-ct-legend__note">Give us up to 3 windows. We'll confirm one.</span>
                </legend>

                <div class="bv-ct-field bv-ct-field--required">
                    <label for="timezone" class="bv-ct-label">
                        Your Timezone <span class="bv-ct-required" aria-hidden="true">*</span>
                    </label>
                    <div class="bv-ct-select-wrap">
                        <select id="timezone" name="timezone" class="bv-ct-select" required>
                            <?php foreach ($timezones as $val => $label): ?>
                                <option value="<?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= $val === 'America/Chicago' ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fa-solid fa-chevron-down bv-ct-select-caret" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="bv-ct-slots">

                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <div class="bv-ct-slot bv-ct-slot--<?= $i ?>">
                            <div class="bv-ct-slot__header">
                                <span class="bv-ct-slot__num bv-font-sci-display">
                                    <?= str_pad((string) $i, 2, '0', STR_PAD_LEFT) ?>
                                </span>
                                <span class="bv-ct-slot__title bv-font-viking-heading">
                                    Slot <?= $i ?>
                                    <?php if ($i === 1): ?>
                                        <span class="bv-ct-required" aria-hidden="true">*</span>
                                    <?php else: ?>
                                        <span class="bv-ct-slot__optional">(optional)</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="bv-ct-slot__inputs">
                                <div class="bv-ct-field">
                                    <label for="call_date_<?= $i ?>" class="bv-ct-label bv-ct-label--small">Date</label>
                                    <input
                                        type="date"
                                        id="call_date_<?= $i ?>"
                                        name="call_date_<?= $i ?>"
                                        class="bv-ct-input"
                                        min="<?= date('Y-m-d') ?>"
                                        <?= $i === 1 ? 'required' : '' ?>
                                    >
                                </div>
                                <div class="bv-ct-field">
                                    <label for="call_time_<?= $i ?>" class="bv-ct-label bv-ct-label--small">Time</label>
                                    <div class="bv-ct-select-wrap">
                                        <select
                                            id="call_time_<?= $i ?>"
                                            name="call_time_<?= $i ?>"
                                            class="bv-ct-select"
                                            <?= $i === 1 ? 'required' : '' ?>
                                        >
                                            <option value="">Select a time</option>
                                            <optgroup label="Morning">
                                                <option value="08:00">8:00 AM</option>
                                                <option value="09:00">9:00 AM</option>
                                                <option value="10:00">10:00 AM</option>
                                                <option value="11:00">11:00 AM</option>
                                            </optgroup>
                                            <optgroup label="Afternoon">
                                                <option value="12:00">12:00 PM</option>
                                                <option value="13:00">1:00 PM</option>
                                                <option value="14:00">2:00 PM</option>
                                                <option value="15:00">3:00 PM</option>
                                                <option value="16:00">4:00 PM</option>
                                            </optgroup>
                                            <optgroup label="Evening">
                                                <option value="17:00">5:00 PM</option>
                                                <option value="18:00">6:00 PM</option>
                                                <option value="19:00">7:00 PM</option>
                                            </optgroup>
                                        </select>
                                        <i class="fa-solid fa-chevron-down bv-ct-select-caret" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                </div>

                <p class="bv-ct-slots-note">
                    <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                    <span>All times interpreted in your selected timezone. We'll send a calendar invite once confirmed.</span>
                </p>

            </fieldset>


            <!-- ═══════════════════════════════════════════════════════════
                 STEP 4 — CONSENT & SUBMIT
                 ═══════════════════════════════════════════════════════════ -->
            <fieldset class="bv-ct-fieldset bv-ct-fieldset--final">
                <legend class="bv-ct-legend">
                    <span class="bv-ct-legend__num bv-font-mono">04</span>
                    <span class="bv-ct-legend__title bv-font-viking-heading">Almost There</span>
                </legend>

                <label class="bv-ct-consent">
                    <input
                        type="checkbox"
                        id="consent"
                        name="consent"
                        value="1"
                        required
                    >
                    <span class="bv-ct-consent__box" aria-hidden="true">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    <span class="bv-ct-consent__text">
                        I consent to BVSec processing this information to respond
                        to my inquiry. I understand this form is not for reporting
                        security vulnerabilities — those should be sent to
                        <code>security@beardedviking.org</code> with PGP.
                        <span class="bv-ct-required" aria-hidden="true">*</span>
                    </span>
                </label>
                <span class="bv-ct-error" data-for="consent" role="alert"></span>

                <div class="bv-ct-submit-wrap">
                    <button type="submit" class="bv-btn bv-btn--primary bv-btn--xl bv-ct-submit" id="bv-ct-submit">
                        <span class="bv-ct-submit__idle">
                            <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                            <span>Send Engagement Request</span>
                        </span>
                        <span class="bv-ct-submit__loading" hidden>
                            <i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
                            <span>Encrypting &amp; Sending...</span>
                        </span>
                    </button>
                    <p class="bv-ct-submit-note">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        <span>Encrypted in transit. Never shared. Never sold.</span>
                    </p>
                </div>

            </fieldset>

            <!-- Form-level alert area -->
            <div class="bv-ct-alert" id="bv-ct-alert" role="alert" hidden></div>

        </form>
        <!-- ═════════ FORM END ═════════ -->

    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     SUCCESS OVERLAY
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="bv-ct-success" id="bv-ct-success" role="dialog" aria-modal="true" aria-labelledby="ct-success-title" hidden>
    <div class="bv-ct-success__backdrop"></div>
    <div class="bv-ct-success__panel">
        <div class="bv-ct-success__icon" aria-hidden="true">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
        <h2 class="bv-ct-success__title bv-font-viking-display" id="ct-success-title">
            Message Received.
        </h2>
        <p class="bv-ct-success__lead">
            Your engagement request has landed in our inbox. Here's what happens next:
        </p>
        <ol class="bv-ct-success__steps">
            <li>
                <span class="bv-ct-success__num bv-font-sci-display">01</span>
                <div>
                    <strong>Review within 72 hours</strong>
                    <p>We read every submission personally. No bots, no templates.</p>
                </div>
            </li>
            <li>
                <span class="bv-ct-success__num bv-font-sci-display">02</span>
                <div>
                    <strong>Confirmation email</strong>
                    <p>A copy of your submission will arrive in your inbox shortly. Check your spam folder if you don't see it within 15 minutes.</p>
                </div>
            </li>
            <li>
                <span class="bv-ct-success__num bv-font-sci-display">03</span>
                <div>
                    <strong>Scoping call scheduled</strong>
                    <p>We'll pick one of your three call windows and send a calendar invite.</p>
                </div>
            </li>
        </ol>
        <div class="bv-ct-success__ref">
            <span class="bv-ct-success__ref-label">Reference Code</span>
            <span class="bv-ct-success__ref-value bv-font-mono" id="ct-success-ref">—</span>
        </div>
        <button type="button" class="bv-btn bv-btn--secondary bv-ct-success__close" id="ct-success-close">
            <i class="fa-solid fa-check" aria-hidden="true"></i>
            <span>Close</span>
        </button>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════════════
     ALTERNATE CONTACT METHODS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-ct-alternates" aria-labelledby="ct-alternates-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">Alternate Channels</span>
        <h2 class="bv-section__title" id="ct-alternates-title">
            Prefer to reach us <span class="bv-text-gradient">another way?</span>
        </h2>
        <p class="bv-section__lead">
            This form is the fastest path to a scoping call. But if you'd
            rather contact us through a different channel — or if you're
            reporting a security vulnerability — use one of these.
        </p>
    </div>

    <div class="bv-ct-alternates__grid">

        <a href="mailto:info@beardedviking.org" class="bv-ct-alt bv-card">
            <div class="bv-ct-alt__icon" aria-hidden="true">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <h3 class="bv-ct-alt__title bv-font-viking-heading">General Inquiries</h3>
            <p class="bv-ct-alt__address bv-font-mono">info@beardedviking.org</p>
            <p class="bv-ct-alt__note">Non-urgent questions, partnerships, media.</p>
        </a>

        <a href="mailto:security@beardedviking.org" class="bv-ct-alt bv-card bv-ct-alt--security">
            <div class="bv-ct-alt__icon" aria-hidden="true">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="bv-ct-alt__title bv-font-viking-heading">Security Reports</h3>
            <p class="bv-ct-alt__address bv-font-mono">security@beardedviking.org</p>
            <p class="bv-ct-alt__note">
                Vulnerability disclosures only. PGP encouraged —
                <a href="/SECURITY.md">see our disclosure policy</a>.
            </p>
        </a>

        <a href="https://github.com/BeardedVikingTX" target="_blank" rel="noopener noreferrer" class="bv-ct-alt bv-card">
            <div class="bv-ct-alt__icon" aria-hidden="true">
                <i class="fa-brands fa-github"></i>
            </div>
            <h3 class="bv-ct-alt__title bv-font-viking-heading">GitHub</h3>
            <p class="bv-ct-alt__address bv-font-mono">@BeardedVikingTX</p>
            <p class="bv-ct-alt__note">Open source projects, issues, pull requests.</p>
        </a>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>