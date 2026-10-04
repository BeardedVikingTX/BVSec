<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Sales Quote Generator (Internal Tool)
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      tools/sales-quote.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  INTERNAL USE ONLY — Commissioned sales agents only.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Sales Quote Generator',
    'description' => 'Internal sales quote tool for BVSec agents.',
    'canonical'   => '/tools/sales-quote.php',
    'noindex'     => true,
    'body_class'  => 'page-sales-tool',
];

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  CONFIGURATION — Edit here to change commission tiers, agents, etc.
// ──────────────────────────────────────────────────────────────────────────
$agents = [
    'viking'    => 'Aubrey W. Love II BeardedVikingTX (Owner)',
    'son'       => 'Aubrey W. Love III Halfling',
    'friend'    => 'Patrick James Ahern-Hooper',
];

// Package catalog — single source of truth. JS reads this too.
$packages = [
    'web' => [
        'starter'    => ['label' => 'Starter Website',      'base' => 500,   'days' => 5,   'tag' => 'informational'],
        'small'      => ['label' => 'Small Build',          'base' => 3500,  'days' => 21,  'tag' => 'landing + features'],
        'greenfield' => ['label' => 'Greenfield Build',     'base' => 15000, 'days' => 90,  'tag' => 'full application'],
        'enterprise' => ['label' => 'Enterprise Platform',  'base' => 35000, 'days' => 180, 'tag' => 'complex platform'],
        'rescue'     => ['label' => 'Rescue Mission',       'base' => 5000,  'days' => 30,  'tag' => 'fix existing code'],
    ],
    'android' => [
        'mvp'        => ['label' => 'Android MVP',          'base' => 8000,  'days' => 45,  'tag' => 'validate concept'],
        'native'     => ['label' => 'Android Native Build', 'base' => 25000, 'days' => 120, 'tag' => 'full-featured'],
        'enterprise' => ['label' => 'Android Enterprise',   'base' => 45000, 'days' => 200, 'tag' => 'complex platform'],
    ],
    'ios' => [
        'mvp'        => ['label' => 'iOS MVP',              'base' => 8000,  'days' => 45,  'tag' => 'validate concept'],
        'native'     => ['label' => 'iOS Native Build',     'base' => 25000, 'days' => 120, 'tag' => 'full-featured'],
        'enterprise' => ['label' => 'iOS Enterprise',       'base' => 45000, 'days' => 200, 'tag' => 'complex platform'],
    ],
    'pentest' => [
        'basic'      => ['label' => 'Basic Security Audit', 'base' => 2500,  'days' => 10,  'tag' => 'single target'],
        'standard'   => ['label' => 'Standard Pentest',     'base' => 7500,  'days' => 21,  'tag' => 'multi-surface'],
        'enterprise' => ['label' => 'Enterprise Audit',     'base' => 20000, 'days' => 45,  'tag' => 'full scope + compliance'],
        'retainer'   => ['label' => 'Continuous Retainer',  'base' => 4000,  'days' => 30,  'tag' => 'monthly'],
    ],
];

// Payment plans
$payment_plans = [
    'upfront' => ['label' => 'Full Upfront',        'split' => [100],           'discount' => 0.08],
    'half'    => ['label' => 'Fifty / Fifty',       'split' => [50, 50],        'discount' => 0.00],
    'thirds'  => ['label' => 'Three-Payment Split', 'split' => [33, 33, 34],    'discount' => -0.02],
];
?>

<main id="main-content" class="bv-main bv-sales-tool">

<!-- ═══════════════════════════════════════════════════════════════════════
     TOOL HEADER
     ═══════════════════════════════════════════════════════════════════════ -->
<header class="bv-st-header">

    <div class="bv-st-header__inner">

        <div class="bv-st-header__brand">
            <div class="bv-st-header__logo" aria-hidden="true">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <div>
                <span class="bv-st-header__eyebrow bv-font-mono">᛫ Internal Tool · Sales Quote Generator ᛫</span>
                <h1 class="bv-st-header__title bv-font-viking-display">
                    Engagement Quotation System
                </h1>
            </div>
        </div>

        <div class="bv-st-header__actions">
            <div class="bv-st-field bv-st-field--inline">
                <label for="agent_name" class="bv-st-label bv-st-label--inline">
                    <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                    Agent
                </label>
                <select id="agent_name" name="agent_name" class="bv-st-select bv-st-select--agent" form="bv-sales-form">
                    <option value="">— Select agent —</option>
                    <?php foreach ($agents as $id => $label): ?>
                        <option value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="button" class="bv-st-icon-btn" id="st-save-draft" title="Save draft locally">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span class="bv-st-icon-btn__label">Save</span>
            </button>

            <button type="button" class="bv-st-icon-btn" id="st-print" title="Print summary">
                <i class="fa-solid fa-print" aria-hidden="true"></i>
                <span class="bv-st-icon-btn__label">Print</span>
            </button>

            <button type="button" class="bv-st-icon-btn bv-st-icon-btn--danger" id="st-reset" title="Reset form">
                <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                <span class="bv-st-icon-btn__label">Reset</span>
            </button>
        </div>

    </div>

    <!-- Progress bar -->
    <div class="bv-st-progress" aria-hidden="true">
        <div class="bv-st-progress__bar" id="st-progress-bar"></div>
    </div>

</header>


<!-- ═══════════════════════════════════════════════════════════════════════
     MAIN GRID — FORM + LIVE SUMMARY
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="bv-st-grid">

    <!-- ═══════════════════════════════════════════════════════════════
         LEFT: THE FORM
         ═══════════════════════════════════════════════════════════════ -->
    <form class="bv-st-form" id="bv-sales-form" method="post" action="/tools/sales-quote-handler.php" novalidate>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($GLOBALS['csp_nonce'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="recommended_package" id="st-rec-package-hidden" value="">
        <input type="hidden" name="recommended_price"   id="st-rec-price-hidden"   value="0">
        <input type="hidden" name="final_price"         id="st-final-price-hidden" value="0">
        <input type="hidden" name="payment_plan"        id="st-payment-plan-hidden" value="half">

        <!-- ═══════════════════════════════════════════════════════════
             SECTION 01 — CLIENT INFORMATION
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section" data-section="client">
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">01</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Client Information</h2>
                    <p class="bv-st-section__desc">Who are we quoting?</p>
                </div>
            </div>

            <div class="bv-st-grid-inner bv-st-grid-inner--2">
                <div class="bv-st-field bv-st-field--required">
                    <label for="client_name" class="bv-st-label">Full Name *</label>
                    <input type="text" id="client_name" name="client_name" class="bv-st-input" required maxlength="120" autocomplete="off" placeholder="Jane Doe">
                </div>
                <div class="bv-st-field">
                    <label for="client_company" class="bv-st-label">Company</label>
                    <input type="text" id="client_company" name="client_company" class="bv-st-input" maxlength="160" autocomplete="off" placeholder="Acme Corp">
                </div>
                <div class="bv-st-field">
                    <label for="client_position" class="bv-st-label">Position / Title</label>
                    <input type="text" id="client_position" name="client_position" class="bv-st-input" maxlength="120" autocomplete="off" placeholder="CEO, CTO, Owner">
                </div>
                <div class="bv-st-field bv-st-field--required">
                    <label for="client_email" class="bv-st-label">Email *</label>
                    <input type="email" id="client_email" name="client_email" class="bv-st-input" required maxlength="254" autocomplete="off" placeholder="jane@company.com">
                </div>
                <div class="bv-st-field bv-st-field--required">
                    <label for="client_phone" class="bv-st-label">Phone *</label>
                    <input type="tel" id="client_phone" name="client_phone" class="bv-st-input" required maxlength="40" autocomplete="off" placeholder="+1 (555) 123-4567">
                </div>
                <div class="bv-st-field">
                    <label for="client_years" class="bv-st-label">Years in Business</label>
                    <select id="client_years" name="client_years" class="bv-st-select">
                        <option value="">Select…</option>
                        <option value="new">Starting up (0–1 years)</option>
                        <option value="young">2–5 years</option>
                        <option value="established">6–10 years</option>
                        <option value="veteran">11+ years</option>
                    </select>
                </div>
                <div class="bv-st-field bv-st-field--full">
                    <label for="client_location" class="bv-st-label">Location (City, State/Country)</label>
                    <input type="text" id="client_location" name="client_location" class="bv-st-input" maxlength="120" placeholder="Fort Worth, TX">
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 02 — SERVICES IN SCOPE
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section" data-section="services">
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">02</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Services In Scope</h2>
                    <p class="bv-st-section__desc">What are they interested in? Select all that apply.</p>
                </div>
            </div>

            <div class="bv-st-services-select">
                <label class="bv-st-service-pick bv-st-service-pick--web">
                    <input type="checkbox" name="service_web" id="service_web" value="1">
                    <span class="bv-st-service-pick__box"><i class="fa-solid fa-check"></i></span>
                    <span class="bv-st-service-pick__icon"><i class="fa-solid fa-code"></i></span>
                    <span class="bv-st-service-pick__text">
                        <strong>Website</strong>
                        <small>Custom web application or site</small>
                    </span>
                </label>

                <label class="bv-st-service-pick bv-st-service-pick--android">
                    <input type="checkbox" name="service_android" id="service_android" value="1">
                    <span class="bv-st-service-pick__box"><i class="fa-solid fa-check"></i></span>
                    <span class="bv-st-service-pick__icon"><i class="fa-brands fa-android"></i></span>
                    <span class="bv-st-service-pick__text">
                        <strong>Android App</strong>
                        <small>Native Kotlin app</small>
                    </span>
                </label>

                <label class="bv-st-service-pick bv-st-service-pick--ios">
                    <input type="checkbox" name="service_ios" id="service_ios" value="1">
                    <span class="bv-st-service-pick__box"><i class="fa-solid fa-check"></i></span>
                    <span class="bv-st-service-pick__icon"><i class="fa-brands fa-apple"></i></span>
                    <span class="bv-st-service-pick__text">
                        <strong>iOS App</strong>
                        <small>Native Swift app</small>
                    </span>
                </label>

                <label class="bv-st-service-pick bv-st-service-pick--pentest">
                    <input type="checkbox" name="service_pentest" id="service_pentest" value="1">
                    <span class="bv-st-service-pick__box"><i class="fa-solid fa-check"></i></span>
                    <span class="bv-st-service-pick__icon"><i class="fa-solid fa-shield-halved"></i></span>
                    <span class="bv-st-service-pick__text">
                        <strong>Pentest / Audit</strong>
                        <small>Security review</small>
                    </span>
                </label>
            </div>

            <div class="bv-st-field">
                <label for="service_summary" class="bv-st-label">Client's Own Words — What Do They Want?</label>
                <textarea id="service_summary" name="service_summary" class="bv-st-textarea" rows="3" maxlength="2000"
                    placeholder="e.g. 'I need an app where my customers can order custom furniture and pay online. Also want a dashboard.'"></textarea>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 03 — WEBSITE (conditional)
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section bv-st-section--conditional" data-section="website" id="section-website" hidden>
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">03</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Website Details</h2>
                    <p class="bv-st-section__desc">Web-specific scope questions</p>
                </div>
            </div>

            <div class="bv-st-field">
                <label for="web_description" class="bv-st-label">What should the website do?</label>
                <textarea id="web_description" name="web_description" class="bv-st-textarea" rows="3" maxlength="2000"
                    placeholder="Describe the core purpose and any specific functionality."></textarea>
            </div>

            <div class="bv-st-grid-inner bv-st-grid-inner--2">
                <div class="bv-st-field">
                    <label for="web_pages" class="bv-st-label">Estimated Number of Pages</label>
                    <select id="web_pages" name="web_pages" class="bv-st-select">
                        <option value="">Select…</option>
                        <option value="1-3">1–3 pages (single-page / small site)</option>
                        <option value="4-6">4–6 pages</option>
                        <option value="7-12">7–12 pages</option>
                        <option value="13-25">13–25 pages</option>
                        <option value="25+">25+ pages</option>
                    </select>
                    <small class="bv-st-hint">Excludes articles, blog posts, product listings.</small>
                </div>
                <div class="bv-st-field">
                    <label for="web_article_count" class="bv-st-label">Approx. Articles / Products (if any)</label>
                    <input type="number" id="web_article_count" name="web_article_count" class="bv-st-input" min="0" max="10000" placeholder="e.g. 50">
                </div>
            </div>

            <div class="bv-st-field">
                <span class="bv-st-label">Features Needed</span>
                <div class="bv-st-chips-grid">
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="api"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">API Integration</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="payment"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Payment Portal</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="admin"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Admin Panel</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="auth"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">User Login + Dashboard</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="ecommerce"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">E-commerce</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="cms"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Blog / CMS</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="multilang"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Multi-language</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="realtime"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Real-time Features</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="custom"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Custom Logic / Workflows</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="web_features[]" value="integration"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Third-party Integration</span></label>
                </div>
            </div>

            <div class="bv-st-field bv-st-field--radio">
                <span class="bv-st-label">Is this a new build or fixing an existing site?</span>
                <div class="bv-st-radio-row">
                    <label class="bv-st-radio"><input type="radio" name="web_build_type" value="new" checked><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">New Build</span></label>
                    <label class="bv-st-radio"><input type="radio" name="web_build_type" value="rescue"><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">Fix / Rescue Existing</span></label>
                    <label class="bv-st-radio"><input type="radio" name="web_build_type" value="redesign"><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">Redesign / Rebuild</span></label>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 04 — ANDROID APP (conditional)
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section bv-st-section--conditional" data-section="android" id="section-android" hidden>
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">04</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Android App Details</h2>
                    <p class="bv-st-section__desc">Kotlin-native scope</p>
                </div>
            </div>

            <div class="bv-st-field">
                <label for="android_description" class="bv-st-label">What should the app do?</label>
                <textarea id="android_description" name="android_description" class="bv-st-textarea" rows="3" maxlength="2000" placeholder="Core functionality and any specific interactions."></textarea>
            </div>

            <div class="bv-st-field">
                <label for="android_screens" class="bv-st-label">Estimated Number of Screens</label>
                <select id="android_screens" name="android_screens" class="bv-st-select">
                    <option value="">Select…</option>
                    <option value="1-5">1–5 screens (single-purpose utility)</option>
                    <option value="6-10">6–10 screens (focused app)</option>
                    <option value="11-20">11–20 screens (full-featured)</option>
                    <option value="20+">20+ screens (complex platform)</option>
                </select>
            </div>

            <div class="bv-st-field">
                <span class="bv-st-label">Features Needed</span>
                <div class="bv-st-chips-grid">
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="auth"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">User Accounts</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="backend"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Backend API</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="push"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Push Notifications</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="payments"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">In-App Payments</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="offline"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Offline Mode</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="camera"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Camera / Photos</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="gps"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">GPS / Maps</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="hardware"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Bluetooth / Hardware</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="realtime"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Real-time Chat</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="android_features[]" value="biometric"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Biometric Auth</span></label>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 05 — iOS APP (conditional)
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section bv-st-section--conditional" data-section="ios" id="section-ios" hidden>
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">05</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">iOS App Details</h2>
                    <p class="bv-st-section__desc">Swift-native scope</p>
                </div>
            </div>

            <div class="bv-st-field">
                <label for="ios_description" class="bv-st-label">What should the app do?</label>
                <textarea id="ios_description" name="ios_description" class="bv-st-textarea" rows="3" maxlength="2000" placeholder="Core functionality and any specific interactions."></textarea>
            </div>

            <div class="bv-st-field">
                <label for="ios_screens" class="bv-st-label">Estimated Number of Screens</label>
                <select id="ios_screens" name="ios_screens" class="bv-st-select">
                    <option value="">Select…</option>
                    <option value="1-5">1–5 screens (single-purpose utility)</option>
                    <option value="6-10">6–10 screens (focused app)</option>
                    <option value="11-20">11–20 screens (full-featured)</option>
                    <option value="20+">20+ screens (complex platform)</option>
                </select>
            </div>

            <div class="bv-st-field">
                <span class="bv-st-label">Features Needed</span>
                <div class="bv-st-chips-grid">
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="auth"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">User Accounts</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="backend"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Backend API</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="push"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Push Notifications</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="payments"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">In-App Payments</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="offline"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Offline Mode</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="camera"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Camera / Photos</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="gps"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">GPS / Maps</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="hardware"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Bluetooth / Hardware</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="realtime"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Real-time Chat</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="ios_features[]" value="biometric"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Face / Touch ID</span></label>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 06 — PEN TEST / SECURITY AUDIT (conditional)
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section bv-st-section--conditional" data-section="pentest" id="section-pentest" hidden>
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">06</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Pentest / Security Audit Details</h2>
                    <p class="bv-st-section__desc">Scope, targets, and compliance requirements</p>
                </div>
            </div>

            <div class="bv-st-field">
                <label for="pentest_description" class="bv-st-label">What systems should be tested?</label>
                <textarea id="pentest_description" name="pentest_description" class="bv-st-textarea" rows="3" maxlength="2000" placeholder="e.g. Our customer-facing web app, the mobile API, and the admin dashboard."></textarea>
            </div>

            <div class="bv-st-field">
                <span class="bv-st-label">Testing Scope (select all that apply)</span>
                <div class="bv-st-chips-grid">
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="web"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Web Application</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="api"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">API Endpoints</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="mobile"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Mobile Apps</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="infrastructure"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Infrastructure / Network</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="cloud"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Cloud Configuration</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_scope[]" value="social"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">Social Engineering</span></label>
                </div>
            </div>

            <div class="bv-st-field">
                <span class="bv-st-label">Compliance Requirements (if any)</span>
                <div class="bv-st-chips-grid">
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="gdpr"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">GDPR</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="ccpa"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">CCPA</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="hipaa"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">HIPAA</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="pci"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">PCI-DSS</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="soc2"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">SOC 2</span></label>
                    <label class="bv-st-chip"><input type="checkbox" name="pentest_compliance[]" value="iso"><span class="bv-st-chip__box"><i class="fa-solid fa-check"></i></span><span class="bv-st-chip__label">ISO 27001</span></label>
                </div>
            </div>

            <div class="bv-st-field bv-st-field--radio">
                <span class="bv-st-label">Engagement Type</span>
                <div class="bv-st-radio-row">
                    <label class="bv-st-radio"><input type="radio" name="pentest_type" value="oneshot" checked><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">One-Shot Audit</span></label>
                    <label class="bv-st-radio"><input type="radio" name="pentest_type" value="retainer"><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">Continuous Retainer</span></label>
                    <label class="bv-st-radio"><input type="radio" name="pentest_type" value="verify"><span class="bv-st-radio__marker"></span><span class="bv-st-radio__label">Verify Prior Fixes</span></label>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 07 — BUDGET & TIMELINE
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section" data-section="budget">
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">07</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Budget & Timeline</h2>
                    <p class="bv-st-section__desc">Reality check — what can they actually spend?</p>
                </div>
            </div>

            <div class="bv-st-grid-inner bv-st-grid-inner--2">
                <div class="bv-st-field">
                    <label for="budget_type" class="bv-st-label">Budget Flexibility</label>
                    <select id="budget_type" name="budget_type" class="bv-st-select">
                        <option value="fixed">Fixed — specific number</option>
                        <option value="flexible">Flexible — open to proposals</option>
                        <option value="unsure">Not sure yet — help us figure it out</option>
                    </select>
                </div>
                <div class="bv-st-field">
                    <label for="budget_total" class="bv-st-label">Total Budget (USD)</label>
                    <div class="bv-st-input-wrap">
                        <span class="bv-st-input-prefix">$</span>
                        <input type="number" id="budget_total" name="budget_total" class="bv-st-input bv-st-input--with-prefix" min="0" step="100" placeholder="15000">
                    </div>
                </div>
                <div class="bv-st-field bv-st-field--full">
                    <span class="bv-st-label">Budget Breakdown (optional)</span>
                    <div class="bv-st-budget-row">
                        <label class="bv-st-budget-mini">
                            <span class="bv-st-budget-mini__label"><i class="fa-solid fa-code"></i> Web</span>
                            <div class="bv-st-input-wrap">
                                <span class="bv-st-input-prefix">$</span>
                                <input type="number" name="budget_web" class="bv-st-input bv-st-input--with-prefix" min="0" step="100" placeholder="0">
                            </div>
                        </label>
                        <label class="bv-st-budget-mini">
                            <span class="bv-st-budget-mini__label"><i class="fa-brands fa-android"></i> Android</span>
                            <div class="bv-st-input-wrap">
                                <span class="bv-st-input-prefix">$</span>
                                <input type="number" name="budget_android" class="bv-st-input bv-st-input--with-prefix" min="0" step="100" placeholder="0">
                            </div>
                        </label>
                        <label class="bv-st-budget-mini">
                            <span class="bv-st-budget-mini__label"><i class="fa-brands fa-apple"></i> iOS</span>
                            <div class="bv-st-input-wrap">
                                <span class="bv-st-input-prefix">$</span>
                                <input type="number" name="budget_ios" class="bv-st-input bv-st-input--with-prefix" min="0" step="100" placeholder="0">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="bv-st-field">
                    <label for="timeline_start" class="bv-st-label">When can they start?</label>
                    <select id="timeline_start" name="timeline_start" class="bv-st-select">
                        <option value="">Select…</option>
                        <option value="asap">ASAP — ready now</option>
                        <option value="2-weeks">In 2 weeks</option>
                        <option value="1-month">In 1 month</option>
                        <option value="3-months">In 3 months</option>
                        <option value="exploring">Just exploring</option>
                    </select>
                </div>
                <div class="bv-st-field">
                    <label for="timeline_complete" class="bv-st-label">When do they need it done?</label>
                    <select id="timeline_complete" name="timeline_complete" class="bv-st-select">
                        <option value="">Select…</option>
                        <option value="asap">ASAP</option>
                        <option value="1-month">Within 1 month</option>
                        <option value="3-months">Within 3 months</option>
                        <option value="6-months">Within 6 months</option>
                        <option value="flexible">Flexible</option>
                    </select>
                </div>
            </div>
        </section>


        <!-- ═══════════════════════════════════════════════════════════
             SECTION 08 — AGENT NOTES
             ═══════════════════════════════════════════════════════════ -->
        <section class="bv-st-section" data-section="notes">
            <div class="bv-st-section__header">
                <span class="bv-st-section__num bv-font-sci-display">08</span>
                <div>
                    <h2 class="bv-st-section__title bv-font-viking-heading">Agent Notes</h2>
                    <p class="bv-st-section__desc">Anything else the team should know?</p>
                </div>
            </div>

            <div class="bv-st-field">
                <label for="agent_notes" class="bv-st-label">Internal Notes (not sent to client)</label>
                <textarea id="agent_notes" name="agent_notes" class="bv-st-textarea" rows="4" maxlength="3000" placeholder="e.g. Client is aggressive on timeline. Son of a friend — be patient. Wants to see references."></textarea>
            </div>

            <div class="bv-st-field">
                <label for="client_notes" class="bv-st-label">Message to Client (goes in their email)</label>
                <textarea id="client_notes" name="client_notes" class="bv-st-textarea" rows="3" maxlength="1500" placeholder="e.g. Looking forward to working with you — we'll follow up within 24 hours."></textarea>
            </div>
        </section>

    </form>


    <!-- ═══════════════════════════════════════════════════════════════
         RIGHT: LIVE SUMMARY PANEL (sticky)
         ═══════════════════════════════════════════════════════════════ -->
    <aside class="bv-st-summary" id="st-summary" aria-live="polite">

        <div class="bv-st-summary__inner">

            <div class="bv-st-summary__header">
                <div class="bv-st-summary__label bv-font-sci-label">
                    <i class="fa-solid fa-calculator" aria-hidden="true"></i>
                    Live Recommendation
                </div>
                <button type="button" class="bv-st-summary__collapse" id="st-summary-collapse" aria-label="Toggle summary">
                    <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Recommended packages list -->
            <div class="bv-st-summary__section" id="st-summary-packages">
                <div class="bv-st-summary__empty">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <p>Select services to see recommendations</p>
                </div>
            </div>

            <!-- Pricing breakdown -->
            <div class="bv-st-summary__section">
                <div class="bv-st-summary__section-title bv-font-sci-label">Pricing Breakdown</div>
                <dl class="bv-st-summary__pricing">
                    <div class="bv-st-summary__row">
                        <dt>Recommended Subtotal</dt>
                        <dd id="st-recommended-total" class="bv-font-mono">$0</dd>
                    </div>
                    <div class="bv-st-summary__row bv-st-summary__row--agent">
                        <dt>
                            Final Price
                            <small>Agent override</small>
                        </dt>
                        <dd>
                            <div class="bv-st-input-wrap bv-st-input-wrap--compact">
                                <span class="bv-st-input-prefix">$</span>
                                <input type="number" id="st-final-price" name="final_price_display" class="bv-st-input bv-st-input--with-prefix bv-st-input--compact" min="0" step="50" placeholder="0">
                            </div>
                        </dd>
                    </div>
                    <div class="bv-st-summary__row" id="st-override-row" hidden>
                        <dt>Override Reason</dt>
                        <dd>
                            <select id="st-override-reason" name="override_reason" class="bv-st-select bv-st-select--compact">
                                <option value="">Select…</option>
                                <option value="budget-constraint">Budget constraint</option>
                                <option value="negotiation">Negotiation tactic</option>
                                <option value="package-adjustment">Package scope reduced</option>
                                <option value="long-term-partner">Long-term partnership</option>
                                <option value="other">Other (see notes)</option>
                            </select>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Payment plan -->
            <div class="bv-st-summary__section">
                <div class="bv-st-summary__section-title bv-font-sci-label">Payment Plan</div>
                <div class="bv-st-payment-plans" id="st-payment-plans">
                    <label class="bv-st-plan">
                        <input type="radio" name="payment_plan_radio" value="upfront">
                        <span class="bv-st-plan__body">
                            <span class="bv-st-plan__name bv-font-viking-heading">Full Upfront</span>
                            <span class="bv-st-plan__split bv-font-mono">100% at kickoff</span>
                            <span class="bv-st-plan__discount bv-font-mono">Save 8%</span>
                        </span>
                    </label>
                    <label class="bv-st-plan">
                        <input type="radio" name="payment_plan_radio" value="half" checked>
                        <span class="bv-st-plan__body">
                            <span class="bv-st-plan__name bv-font-viking-heading">Fifty / Fifty</span>
                            <span class="bv-st-plan__split bv-font-mono">50% · 50%</span>
                            <span class="bv-st-plan__discount bv-st-plan__discount--neutral bv-font-mono">Standard</span>
                        </span>
                    </label>
                    <label class="bv-st-plan">
                        <input type="radio" name="payment_plan_radio" value="thirds">
                        <span class="bv-st-plan__body">
                            <span class="bv-st-plan__name bv-font-viking-heading">Three-Payment</span>
                            <span class="bv-st-plan__split bv-font-mono">33% · 33% · 34%</span>
                            <span class="bv-st-plan__discount bv-st-plan__discount--negative bv-font-mono">+2% markup</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- First installment -->
            <div class="bv-st-summary__section bv-st-summary__section--highlight">
                <div class="bv-st-summary__section-title bv-font-sci-label">First Installment Due</div>
                <div class="bv-st-first-payment">
                    <span class="bv-st-first-payment__amount bv-font-sci-display" id="st-first-payment">$0</span>
                    <span class="bv-st-first-payment__note" id="st-first-payment-note">50% at kickoff</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="bv-st-summary__actions">
                <button type="button" class="bv-btn bv-btn--secondary bv-st-summary__btn" id="st-preview">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                    <span>Preview Email</span>
                </button>
                <button type="button" class="bv-btn bv-btn--primary bv-st-summary__btn bv-st-summary__btn--main" id="st-submit">
                    <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                    <span>Generate Quote</span>
                </button>
            </div>

        </div>

    </aside>

</div>


<!-- ═══════════════════════════════════════════════════════════════════════
     PREVIEW MODAL
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="bv-st-modal" id="st-modal" role="dialog" aria-modal="true" aria-labelledby="st-modal-title" hidden>
    <div class="bv-st-modal__backdrop" data-st-modal-close></div>
    <div class="bv-st-modal__panel">
        <div class="bv-st-modal__bar">
            <span class="bv-st-modal__title bv-font-mono" id="st-modal-title">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                <span id="st-modal-recipient">preview@client.com</span>
            </span>
            <button type="button" class="bv-st-modal__close" data-st-modal-close aria-label="Close">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>
        <div class="bv-st-modal__tabs" role="tablist">
            <button type="button" class="bv-st-modal__tab is-active" data-tab="client" role="tab" aria-selected="true">
                <i class="fa-solid fa-user" aria-hidden="true"></i>
                Client Email
            </button>
            <button type="button" class="bv-st-modal__tab" data-tab="admin" role="tab" aria-selected="false">
                <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                Internal Email
            </button>
        </div>
        <div class="bv-st-modal__body" id="st-modal-body">
            <!-- Filled by JS -->
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════════════
     SUCCESS OVERLAY
     ═══════════════════════════════════════════════════════════════════════ -->
<div class="bv-st-success" id="st-success" role="dialog" aria-modal="true" hidden>
    <div class="bv-st-success__backdrop"></div>
    <div class="bv-st-success__panel">
        <div class="bv-st-success__icon" aria-hidden="true">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <h2 class="bv-st-success__title bv-font-viking-display">Quote Sent.</h2>
        <p class="bv-st-success__lead">
            Emails have been dispatched to both the client and the BVSec inbox.
            Log the reference code below for your records.
        </p>
        <div class="bv-st-success__ref">
            <span class="bv-st-success__ref-label bv-font-sci-label">Reference</span>
            <span class="bv-st-success__ref-value bv-font-mono" id="st-success-ref">—</span>
        </div>
        <div class="bv-st-success__meta">
            <div>
                <span class="bv-font-sci-label">Client Email</span>
                <span class="bv-font-mono" id="st-success-client">—</span>
            </div>
            <div>
                <span class="bv-font-sci-label">Final Price</span>
                <span class="bv-font-mono" id="st-success-price">—</span>
            </div>
        </div>
        <div class="bv-st-success__actions">
            <button type="button" class="bv-btn bv-btn--secondary" id="st-success-new">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                <span>New Quote</span>
            </button>
            <button type="button" class="bv-btn bv-btn--primary" id="st-success-close">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
                <span>Done</span>
            </button>
        </div>
    </div>
</div>

</main>

<script type="application/json" id="st-packages-data" nonce="<?= $csp_nonce ?>">
<?= json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>
<script type="application/json" id="st-plans-data" nonce="<?= $csp_nonce ?>">
<?= json_encode($payment_plans, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>