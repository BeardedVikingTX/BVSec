<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Native Mobile Development Services
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      services/mobile-development.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

$page = [
    'title'       => 'Native Mobile Development — Android (Kotlin) & iOS (Swift)',
    'description' => 'Native Android and iOS applications built by BeardedVikingTX. Kotlin + Swift. Hardware-backed encryption, certificate pinning, secure storage. Play Store & App Store deployment.',
    'canonical'   => '/services/mobile-development',
    'og_image'    => '/assets/images/og/mobile-development.png',
    'body_class'  => 'page-mobile-development',
];

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';

// ──────────────────────────────────────────────────────────────────────────
//  PLATFORM COMPARISON
// ──────────────────────────────────────────────────────────────────────────
$platforms = [
    [
        'id'      => 'android',
        'name'    => 'Android',
        'icon'    => 'fa-brands fa-android',
        'color'   => 'android',
        'lang'    => 'Kotlin',
        'lang_alt'=> 'Java (legacy modernization)',
        'ui'      => 'Jetpack Compose',
        'ui_alt'  => 'XML layouts (legacy)',
        'store'   => 'Google Play Store',
        'review'  => '1–3 business days',
        'min_api' => 'API 24 (Android 7.0)',
        'desc'    => 'Native Android apps built with Kotlin and Jetpack Compose. Modern, declarative UI with hardware-backed security, first-class support for background work via WorkManager, and Play Store deployment handled end-to-end.',
        'highlights' => [
            'Kotlin 2.x with Coroutines + Flow',
            'Jetpack Compose for declarative UI',
            'Hilt for dependency injection',
            'Room for local encrypted persistence',
            'WorkManager for reliable background tasks',
            'Play Integrity API for device attestation',
        ],
    ],
    [
        'id'      => 'ios',
        'name'    => 'iOS',
        'icon'    => 'fa-brands fa-apple',
        'color'   => 'ios',
        'lang'    => 'Swift',
        'lang_alt'=> 'SwiftUI + UIKit (interop)',
        'ui'      => 'SwiftUI',
        'ui_alt'  => 'UIKit (legacy support)',
        'store'   => 'Apple App Store',
        'review'  => '1–7 business days',
        'min_api' => 'iOS 15+',
        'desc'    => 'Native iOS apps built with Swift and SwiftUI. Modern declarative UI, tight Keychain integration for secure credential storage, and App Store submission including TestFlight distribution and App Review navigation.',
        'highlights' => [
            'Swift 5.x with async/await + Actors',
            'SwiftUI for declarative interfaces',
            'Combine for reactive data flows',
            'Keychain Services for secure storage',
            'Core Data / SwiftData for persistence',
            'App Attest for device integrity',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  WHAT WE BUILD — service categories
// ──────────────────────────────────────────────────────────────────────────
$services = [
    [
        'icon'    => 'fa-solid fa-mobile-screen-button',
        'name'    => 'Native App Development',
        'tagline' => 'Android & iOS. Written natively. No wrappers.',
        'body'    => 'Fully native applications built in Kotlin (Android) and Swift (iOS). No React Native, no Flutter, no hybrid webview compromises. Native performance, native security primitives, and native UX on each platform — because users can tell the difference.',
        'items'   => [
            'Kotlin + Jetpack Compose (Android)',
            'Swift + SwiftUI (iOS)',
            'Native platform-specific UX patterns',
            'Push notifications (FCM + APNs)',
            'Deep linking and universal links',
            'In-app purchases and subscriptions',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-user-shield',
        'name'    => 'Mobile Security',
        'tagline' => 'The same discipline as our web work.',
        'body'    => 'Mobile apps carry credentials, tokens, PII, and payment data. Every BVSec app ships with hardware-backed encryption, certificate pinning, root/jailbreak detection, and secure storage — plus mobile-specific hardening that stops the OWASP Mobile Top 10 cold.',
        'items'   => [
            'Hardware-backed keystore (Android Keystore / iOS Secure Enclave)',
            'Certificate pinning with rotation strategy',
            'Root / jailbreak detection and RASP integration',
            'Secure local storage (EncryptedSharedPreferences / Keychain)',
            'Anti-tampering and code obfuscation (R8, ProGuard)',
            'OWASP Mobile Top 10 hardening',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-cloud-arrow-up',
        'name'    => 'Backend Integration',
        'tagline' => 'Your API, or ours. Either way, secured.',
        'body'    => 'Every mobile app needs a backend. Whether integrating with your existing API or building a companion REST/GraphQL service from scratch, all communication is authenticated, rate-limited, and encrypted end-to-end with certificate pinning on the client.',
        'items'   => [
            'REST & GraphQL API integration',
            'OAuth 2.0 / OIDC authentication flows',
            'WebSocket real-time features',
            'Offline-first sync with conflict resolution',
            'Push notification infrastructure',
            'Custom backend development if needed',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-rocket',
        'name'    => 'Deployment & Store Submission',
        'tagline' => 'Play Store. App Store. Submitted by us.',
        'body'    => 'Store submission is its own skillset — Apple App Review has rejected more apps than any auditor in the industry. We handle the metadata, screenshots, privacy declarations, and submission — including TestFlight beta distribution and handling any rejection feedback loops.',
        'items'   => [
            'Google Play Store submission (1–3 day review)',
            'Apple App Store submission (1–7 day review)',
            'TestFlight beta distribution',
            'App store optimization (ASO) basics',
            'Privacy manifest & data safety declarations',
            'App rejection response and re-submission',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-gauge-high',
        'name'    => 'Performance & Optimization',
        'tagline' => 'Fast apps get 5-star reviews.',
        'body'    => 'Slow apps get uninstalled. Every BVSec mobile app is profiled for startup time, memory footprint, battery drain, and network efficiency — then optimized until it feels instant. Cold-start under 1.5 seconds is the target for every app we ship.',
        'items'   => [
            'Cold start time optimization',
            'Memory leak detection and profiling',
            'Battery drain analysis',
            'Network efficiency (batching, caching, compression)',
            'APK/IPA size reduction',
            'Frame rate optimization for smooth animations',
        ],
    ],
    [
        'icon'    => 'fa-solid fa-rotate',
        'name'    => 'Maintenance & Updates',
        'tagline' => 'Apps age. We keep them young.',
        'body'    => 'Mobile platforms move fast — new Android versions, new iOS SDK requirements, new privacy rules from Apple and Google. Ongoing maintenance keeps your app compatible, compliant, and secure against new attack techniques discovered after launch.',
        'items'   => [
            'OS version compatibility updates',
            'Dependency and library security patches',
            'Store compliance updates (Apple/Google policy changes)',
            'Bug fixes and minor feature additions',
            'Crash log monitoring and remediation',
            'Security patch response within 48 hours for criticals',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  THE MOBILE BUILD PROCESS — 6 phases
// ──────────────────────────────────────────────────────────────────────────
$phases = [
    [
        'num'   => '01',
        'icon'  => 'fa-solid fa-map',
        'title' => 'Discovery & Platform Strategy',
        'body'  => 'Mobile projects start with questions: Android first? iOS first? Both simultaneously? What\'s the minimum viable feature set for launch? Who\'s the audience? Discovery defines the roadmap before a single screen is designed.',
        'items' => [
            'Platform priority decision (Android, iOS, or both)',
            'Target device and OS version analysis',
            'Minimum viable feature set for launch',
            'User flow mapping and screen inventory',
            'Third-party SDK and API inventory',
        ],
    ],
    [
        'num'   => '02',
        'icon'  => 'fa-solid fa-drafting-compass',
        'title' => 'UX Design & Prototyping',
        'body'  => 'Mobile UX is not web UX. Touch targets, gestures, platform-native navigation patterns, and offline states all need to be designed for mobile-first. Every screen is prototyped and reviewed before development begins.',
        'items' => [
            'Wireframes for every screen and state',
            'Platform-native navigation patterns',
            'Interactive clickable prototypes',
            'Empty, loading, and error state designs',
            'Accessibility annotations (TalkBack, VoiceOver)',
        ],
    ],
    [
        'num'   => '03',
        'icon'  => 'fa-solid fa-hammer',
        'title' => 'Native Development',
        'body'  => 'Kotlin for Android. Swift for iOS. Iterative development in two-week sprints with a build you can install on your own phone at the end of every sprint. No "big reveal" at the end — you watch it grow.',
        'items' => [
            'Two-week sprints with testable builds each cycle',
            'Platform-native code and design language',
            'Continuous security scanning on every commit',
            'Automated UI and unit test coverage',
            'Regular TestFlight / internal track distributions',
        ],
    ],
    [
        'num'   => '04',
        'icon'  => 'fa-solid fa-crosshairs',
        'title' => 'Adversarial Testing',
        'body'  => 'Before submission, the app gets attacked. Static analysis of the compiled binary, dynamic analysis of runtime behavior, storage inspection, network interception, and business logic abuse — all under the same discipline as our bug bounty work.',
        'items' => [
            'Static analysis (APK/IPA decompilation review)',
            'Dynamic analysis (Frida, Objection runtime inspection)',
            'Secure storage verification (keystore, keychain)',
            'Certificate pinning validation',
            'Root/jailbreak detection testing',
            'Business logic and auth bypass attempts',
        ],
    ],
    [
        'num'   => '05',
        'icon'  => 'fa-solid fa-rocket',
        'title' => 'Store Submission & Launch',
        'body'  => 'Play Store and App Store submission handled end-to-end. We prepare every asset, fill out every metadata field, respond to any review feedback, and coordinate the release so both platforms launch together if you\'re going multi-platform.',
        'items' => [
            'Store listing creation (screenshots, descriptions)',
            'Privacy manifest and data safety declarations',
            'App Review / Play Review navigation',
            'TestFlight / internal track final beta',
            'Coordinated launch across platforms',
            'Post-launch monitoring and crash telemetry',
        ],
    ],
    [
        'num'   => '06',
        'icon'  => 'fa-solid fa-rotate',
        'title' => 'Post-Launch Support',
        'body'  => 'Every mobile project includes 90 days of post-launch support at no additional cost. Crash fixes, store compliance issues, hotfixes for critical bugs, and OS version compatibility patches — because launch day is where the real bugs reveal themselves.',
        'items' => [
            'Crash log monitoring and remediation',
            'Critical bug hotfixes (48-hour response)',
            'Store policy compliance updates',
            'OS version compatibility patches',
            'Optional transition to maintenance retainer',
        ],
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  MOBILE SECURITY BASELINE — what every app ships with
// ──────────────────────────────────────────────────────────────────────────
$baseline = [
    [
        'icon'  => 'fa-solid fa-key',
        'title' => 'Hardware-Backed Keystore',
        'desc'  => 'Credentials, tokens, and message keys stored in Android Keystore or iOS Secure Enclave — never in plain SharedPreferences or unencrypted files.',
    ],
    [
        'icon'  => 'fa-solid fa-lock',
        'title' => 'Certificate Pinning',
        'desc'  => 'Every network request pinned to the correct certificate. MITM attacks on untrusted networks fail instantly. Rotation strategy built in for when certs expire.',
    ],
    [
        'icon'  => 'fa-solid fa-user-secret',
        'title' => 'Root / Jailbreak Detection',
        'desc'  => 'Play Integrity API (Android) and App Attest (iOS) verify the device is not compromised. Sensitive operations refuse to run on rooted devices.',
    ],
    [
        'icon'  => 'fa-solid fa-file-shield',
        'title' => 'Secure Local Storage',
        'desc'  => 'EncryptedSharedPreferences (Android) and Keychain Services (iOS) for all persistent data. No plaintext files. No SQLite without encryption.',
    ],
    [
        'icon'  => 'fa-solid fa-code',
        'title'  => 'Code Obfuscation',
        'desc'  => 'R8 / ProGuard for Android, bitcode + symbol stripping for iOS. Reversing your app\'s logic takes weeks instead of minutes.',
    ],
    [
        'icon'  => 'fa-solid fa-bug',
        'title' => 'OWASP Mobile Top 10',
        'desc'  => 'Every app tested against the OWASP Mobile Top 10 — improper credential usage, insecure storage, insecure communication, and all seven others.',
    ],
    [
        'icon'  => 'fa-solid fa-shield-halved',
        'title' => 'Tamper Detection',
        'desc'  => 'Signature verification on launch, integrity checks on critical operations, and automatic response to tampering (session invalidation, crash).',
    ],
    [
        'icon'  => 'fa-solid fa-eye-slash',
        'title' => 'No Third-Party Trackers',
        'desc'  => 'Zero advertising SDKs, zero analytics that phone home, zero crash reporters that leak user data. If we need telemetry, we build it ourselves with full control.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  DEPLOYMENT TIMELINE
// ──────────────────────────────────────────────────────────────────────────
$timeline = [
    [
        'scope'   => 'Simple App',
        'example' => 'Single-purpose utility, calculator, booking widget',
        'weeks'   => '4–8 weeks',
        'features'=> '5–10 screens · local storage · 1 API integration',
    ],
    [
        'scope'   => 'Standard App',
        'example' => 'Multi-feature consumer or business app',
        'weeks'   => '3–5 months',
        'features'=> '15–30 screens · auth · offline sync · push notifications',
    ],
    [
        'scope'   => 'Complex App',
        'example' => 'Full-featured platform, marketplace, or SaaS companion',
        'weeks'   => '6–12 months',
        'features'=> '30+ screens · complex backend · real-time · payments',
    ],
    [
        'scope'   => 'Dual Platform (Android + iOS)',
        'example' => 'Same app on both stores, shipped together',
        'weeks'   => 'Multiply single-platform by 1.6–1.8×',
        'features'=> 'Shared design, native code on each platform',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  ENGAGEMENT MODELS
// ──────────────────────────────────────────────────────────────────────────
$engagements = [
    [
        'id'      => 'mvp',
        'icon'    => 'fa-solid fa-seedling',
        'name'    => 'MVP Build',
        'tagline' => 'Prove the concept. Test the market.',
        'price'   => 'From $8,000',
        'desc'    => 'A minimum viable mobile app for a single platform — Android OR iOS — with the essential features needed to launch and validate the idea. Ideal for founders who need to prove traction before committing to a full build.',
        'includes' => [
            'Single platform (Android or iOS)',
            'Core features for launch (5–10 screens)',
            'Basic backend integration',
            'Store submission handled end-to-end',
            '90-day post-launch support',
        ],
        'best_for' => 'Founders validating a concept, MVPs, internal tools',
    ],
    [
        'id'      => 'native',
        'icon'    => 'fa-solid fa-mobile-screen-button',
        'name'    => 'Native App Build',
        'tagline' => 'Full-featured. Single platform.',
        'price'   => 'From $25,000',
        'desc'    => 'Complete native application for one platform — Android or iOS — with full security hardening, custom backend integration, third-party SDK integration, and comprehensive testing before launch. Timeline: 3–5 months depending on scope.',
        'includes' => [
            'Full native build (Kotlin OR Swift)',
            'Complete security baseline (keystore, pinning, RASP)',
            'Backend API integration or development',
            'Full store submission and launch support',
            '90-day post-launch support',
        ],
        'best_for' => 'Consumer apps, business apps, single-platform launches',
        'featured' => true,
    ],
    [
        'id'      => 'dual',
        'icon'    => 'fa-solid fa-layer-group',
        'name'    => 'Dual Platform Build',
        'tagline' => 'Android AND iOS. Shipped together.',
        'price'   => 'From $40,000',
        'desc'    => 'Full-featured native apps on both Android and iOS, launched simultaneously to both stores. Shared design language and feature parity, but native code on each platform — no cross-platform framework compromises.',
        'includes' => [
            'Native builds for Android AND iOS',
            'Shared design system, native code',
            'Coordinated dual-store launch',
            'Full security baseline on both platforms',
            '90-day post-launch support',
        ],
        'best_for' => 'Funded startups, established businesses, platform launches',
    ],
    [
        'id'      => 'maintenance',
        'icon'    => 'fa-solid fa-rotate',
        'name'    => 'Maintenance Retainer',
        'tagline' => 'Keep the app alive and current.',
        'price'   => 'From $2,000/mo',
        'desc'    => 'Ongoing maintenance for an existing mobile app — whether we built it or someone else did. OS version updates, security patches, bug fixes, and store compliance handled monthly. Priority response for criticals.',
        'includes' => [
            'Monthly OS and dependency updates',
            'Security patches for new CVEs',
            'Store compliance updates as policies change',
            'Bug fixes and minor feature additions',
            '48-hour response for critical issues',
        ],
        'best_for' => 'Existing apps needing a reliable engineering partner',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  FAQ
// ──────────────────────────────────────────────────────────────────────────
$faq = [
    [
        'q' => 'Native or cross-platform — which should I choose?',
        'a' => 'We build native because it\'s better for security, performance, and user experience — full stop. React Native and Flutter are fine for prototypes, but they add an abstraction layer that makes hardware-backed security primitives harder to use, they ship larger binaries, and they always lag behind new platform features. If you want a fast, secure app that feels right on each platform, native is the answer. If you have a very limited budget and are willing to compromise, cross-platform can work — but we don\'t build them, and we\'ll tell you honestly if we think that\'s the right call for you.',
    ],
    [
        'q' => 'How long does it take to build and launch a mobile app?',
        'a' => 'Simple apps (utilities, single-purpose widgets) run 4–8 weeks. Standard feature-rich apps run 3–5 months. Complex platforms run 6–12 months. Store review adds 1–3 days for Google Play and 1–7 days for the Apple App Store — occasionally longer if Apple has questions. We always quote you the timeline in the proposal, and we under-promise on purpose: the number we give is the number we intend to hit.',
    ],
    [
        'q' => 'Should I launch on Android first, iOS first, or both?',
        'a' => 'It depends on your audience. In the US, iOS users tend to spend more on in-app purchases; globally, Android has way more users. If you can only afford one platform, we recommend starting with whichever platform your target audience uses most, then adding the second platform once you\'ve validated the concept. Dual-platform launches are cheaper per-platform since the design work is shared, but they cost more upfront and take longer to ship.',
    ],
    [
        'q' => 'What about Apple App Review? Won\'t they reject us?',
        'a' => 'Apple rejects roughly 40% of submissions on the first pass — usually for metadata issues, missing privacy manifests, or guideline violations that are easy to fix once you know them. We handle store submission end-to-end: metadata, screenshots, privacy declarations, and — critically — the rejection response process. If Apple flags something, we fix it and resubmit. You don\'t have to navigate App Review yourself.',
    ],
    [
        'q' => 'Do I need a backend, or can the app work standalone?',
        'a' => 'Depends on what the app does. Simple utilities can run entirely on-device. Anything with user accounts, syncing, real-time features, or analytics needs a backend. If you already have one, we integrate with it. If you don\'t, we can build a companion REST or GraphQL API as part of the engagement — either on your infrastructure or ours.',
    ],
    [
        'q' => 'What happens after the app launches?',
        'a' => 'Every mobile project includes 90 days of post-launch support at no additional cost. During that window we fix crashes, handle any store compliance issues, and patch critical bugs within 48 hours. After the 90 days, ongoing maintenance is available under a retainer. Mobile apps need regular updates — Android and iOS both move fast, and Apple/Google policy changes can force re-submissions — so most clients continue on the retainer.',
    ],
    [
        'q' => 'Do I own the source code after launch?',
        'a' => 'Yes. Full copyright assignment on delivery — every line of custom code, every design asset, every piece of documentation. Signing keys, store accounts, and certificates are transferred to you or your organization. We retain the right to reference the project in our portfolio unless you request otherwise under NDA. No vendor lock-in, no license games.',
    ],
];

// ──────────────────────────────────────────────────────────────────────────
//  PRINCIPLES
// ──────────────────────────────────────────────────────────────────────────
$principles = [
    [
        'num'   => 'I',
        'title' => 'Native. Not "native-feeling."',
        'body'  => 'Cross-platform frameworks have gotten good at pretending to be native. But users can tell the difference in scroll momentum, keyboard handling, back-button behavior, and animation timing. We build native because native is what your users actually want.',
    ],
    [
        'num'   => 'II',
        'title' => 'Security ships on day one.',
        'body'  => 'Not after launch. Not in a v2 update. The first build that goes to a tester has hardware-backed storage, certificate pinning, and root detection enabled. There is no "we\'ll add security later" phase — because there isn\'t one.',
    ],
    [
        'num'   => 'III',
        'title' => 'You see it working weekly.',
        'body'  => 'Two-week sprints with an installable build at the end of each one. You get the app on your own device, test the new features, file feedback directly, and shape the product as it evolves. No "big reveal" surprises at the end.',
    ],
    [
        'num'   => 'IV',
        'title' => 'You own everything.',
        'body'  => 'Source code, signing keys, store accounts, certificates — all transferred on delivery. No proprietary frameworks, no locked SDKs, no ongoing fees to keep your own app working. It\'s yours, outright, forever.',
    ],
];
?>

<main id="main-content" class="bv-main bv-mobile-dev">

<!-- ═══════════════════════════════════════════════════════════════════════
     HERO
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-md-hero" id="md-hero" aria-labelledby="md-hero-title">

    <div class="bv-md-hero__bg" aria-hidden="true">
        <div class="bv-md-hero__vignette"></div>
        <div class="bv-md-hero__aurora"></div>
        <div class="bv-md-hero__grid"></div>
    </div>

    <div class="bv-md-hero__runes bv-md-hero__runes--left" aria-hidden="true">
        <span>ᛗ</span><span>ᛟ</span><span>ᛒ</span><span>ᛁ</span><span>ᛚ</span><span>ᛖ</span>
    </div>
    <div class="bv-md-hero__runes bv-md-hero__runes--right" aria-hidden="true">
        <span>ᚨ</span><span>ᚾ</span><span>ᛞ</span><span>ᚱ</span><span>ᛟ</span><span>ᛁ</span><span>ᛞ</span>
    </div>

    <div class="bv-md-hero__inner">

        <span class="bv-section__eyebrow">᛫ Service Offering · Native Mobile Development ᛫</span>

        <h1 class="bv-md-hero__title" id="md-hero-title">
            <span class="bv-md-hero__title-runes" aria-hidden="true">ᚾᚨᛏᛁᚢᛖ</span>
            <span class="bv-md-hero__title-line bv-md-hero__title-line--viking">In Your Pocket.</span>
            <span class="bv-md-hero__title-line bv-md-hero__title-line--accent">
                <span class="bv-glitch" data-text="Hardened To Core.">Hardened To Core.</span>
            </span>
        </h1>

        <p class="bv-md-hero__lead">
            Native Android. Native iOS. Kotlin and Swift — no cross-platform wrappers,
            no compromise on security, no compromise on performance. Every app ships
            with hardware-backed keystores, certificate pinning, and RASP integration
            from the very first build.
        </p>

        <div class="bv-md-hero__actions">
            <a href="#engagement-models" class="bv-btn bv-btn--primary bv-btn--lg">
                <i class="fa-solid fa-file-contract" aria-hidden="true"></i>
                <span>See Engagement Models</span>
            </a>
            <a href="#mobile-baseline" class="bv-btn bv-btn--secondary bv-btn--lg">
                <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                <span>Security Baseline</span>
            </a>
        </div>

        <div class="bv-md-hero__metrics" role="list">
            <div class="bv-md-hero__metric" role="listitem">
                <span class="bv-md-hero__metric-value" data-counter="2">0</span>
                <span class="bv-md-hero__metric-label">Native Platforms</span>
            </div>
            <div class="bv-md-hero__metric" role="listitem">
                <span class="bv-md-hero__metric-value" data-counter="90">0</span>
                <span class="bv-md-hero__metric-label">Day Support</span>
            </div>
            <div class="bv-md-hero__metric" role="listitem">
                <span class="bv-md-hero__metric-value" data-counter="100">0</span>
                <span class="bv-md-hero__metric-label">% Native Code</span>
            </div>
            <div class="bv-md-hero__metric" role="listitem">
                <span class="bv-md-hero__metric-value" data-counter="48">0</span>
                <span class="bv-md-hero__metric-label">Hour Critical Response</span>
            </div>
        </div>

    </div>

    <div class="bv-md-hero__scroll" aria-hidden="true">
        <span class="bv-md-hero__scroll-rune">ᛝ</span>
        <span class="bv-md-hero__scroll-text">SCROLL FOR INTEL</span>
        <span class="bv-md-hero__scroll-line"></span>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     01 // PLATFORMS — ANDROID & iOS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-platforms" id="platforms" aria-labelledby="md-platforms-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">01 // THE PLATFORMS</span>
        <h2 class="bv-section__title" id="md-platforms-title">
            Two platforms. <span class="bv-text-gradient">Native on both.</span>
        </h2>
        <p class="bv-section__lead">
            Every BVSec mobile app is written natively for its target platform —
            Kotlin for Android, Swift for iOS. That means native performance,
            native security primitives, and native user experience. Here's exactly
            what that looks like on each side.
        </p>
    </div>

    <div class="bv-md-platforms__grid">
        <?php foreach ($platforms as $p): ?>
            <article class="bv-md-platform bv-card bv-md-platform--<?= htmlspecialchars($p['color'], ENT_QUOTES, 'UTF-8') ?>">
                <div class="bv-md-platform__header">
                    <div class="bv-md-platform__logo" aria-hidden="true">
                        <i class="<?= htmlspecialchars($p['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <h3 class="bv-md-platform__name bv-font-viking-display"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                </div>

                <p class="bv-md-platform__desc"><?= htmlspecialchars($p['desc'], ENT_QUOTES, 'UTF-8') ?></p>

                <dl class="bv-md-platform__specs">
                    <div class="bv-md-platform__spec">
                        <dt>Language</dt>
                        <dd class="bv-font-mono"><?= htmlspecialchars($p['lang'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                    <div class="bv-md-platform__spec">
                        <dt>UI Framework</dt>
                        <dd class="bv-font-mono"><?= htmlspecialchars($p['ui'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                    <div class="bv-md-platform__spec">
                        <dt>Minimum Target</dt>
                        <dd class="bv-font-mono"><?= htmlspecialchars($p['min_api'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                    <div class="bv-md-platform__spec">
                        <dt>Store</dt>
                        <dd class="bv-font-mono"><?= htmlspecialchars($p['store'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                    <div class="bv-md-platform__spec">
                        <dt>Review Window</dt>
                        <dd class="bv-font-mono bv-md-platform__spec-highlight"><?= htmlspecialchars($p['review'], ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                </dl>

                <ul class="bv-md-platform__highlights" role="list">
                    <?php foreach ($p['highlights'] as $h): ?>
                        <li><?= htmlspecialchars($h, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     02 // WHAT WE BUILD
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-services" id="what-we-build" aria-labelledby="md-services-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">02 // WHAT WE BUILD</span>
        <h2 class="bv-section__title" id="md-services-title">
            Six disciplines. <span class="bv-text-gradient">Both platforms.</span>
        </h2>
        <p class="bv-section__lead">
            From the first wireframe to the 90-day post-launch support window,
            every piece of the mobile lifecycle handled by the same operator.
            No handoffs, no "the design team will follow up," no surprises.
        </p>
    </div>

    <div class="bv-md-services__grid">
        <?php foreach ($services as $s): ?>
            <article class="bv-md-service bv-card">
                <div class="bv-md-service__icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($s['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <div class="bv-md-service__header">
                    <h3 class="bv-md-service__name"><?= htmlspecialchars($s['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="bv-md-service__tagline"><?= htmlspecialchars($s['tagline'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <p class="bv-md-service__body"><?= htmlspecialchars($s['body'], ENT_QUOTES, 'UTF-8') ?></p>
                <ul class="bv-md-service__list" role="list">
                    <?php foreach ($s['items'] as $item): ?>
                        <li><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     03 // SECURITY BASELINE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-baseline" id="mobile-baseline" aria-labelledby="md-baseline-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">03 // THE MOBILE SECURITY BASELINE</span>
        <h2 class="bv-section__title" id="md-baseline-title">
            What every app ships with. <span class="bv-text-gradient">No exceptions.</span>
        </h2>
        <p class="bv-section__lead">
            Mobile apps live on untrusted devices in hostile environments. Users
            install them next to malware, connect them to compromised Wi-Fi networks,
            and lose them in taxis. Every BVSec app assumes all of that and defends
            against it — from the first build that reaches a tester.
        </p>
    </div>

    <div class="bv-md-baseline__grid">
        <?php foreach ($baseline as $b): ?>
            <article class="bv-md-baseline__item bv-card">
                <div class="bv-md-baseline__icon" aria-hidden="true">
                    <i class="<?= htmlspecialchars($b['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                </div>
                <h3 class="bv-md-baseline__title"><?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p class="bv-md-baseline__desc"><?= htmlspecialchars($b['desc'], ENT_QUOTES, 'UTF-8') ?></p>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     04 // BUILD PROCESS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-process" id="mobile-process" aria-labelledby="md-process-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">04 // THE MOBILE BUILD PROCESS</span>
        <h2 class="bv-section__title" id="md-process-title">
            Six phases. <span class="bv-text-gradient">Zero guesswork.</span>
        </h2>
        <p class="bv-section__lead">
            Mobile is a different beast from web. Testing happens on real devices,
            submissions go through review gates, and platform versions shift under
            your feet. The process reflects all of that — with checkpoints at every
            stage so nothing slips through.
        </p>
    </div>

    <ol class="bv-md-process__phases" role="list">
        <?php foreach ($phases as $phase): ?>
            <li class="bv-md-process__phase">
                <div class="bv-md-process__phase-num bv-font-sci-display">
                    <?= htmlspecialchars($phase['num'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="bv-md-process__phase-body bv-card">
                    <h3 class="bv-md-process__phase-title">
                        <i class="<?= htmlspecialchars($phase['icon'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
                        <span><?= htmlspecialchars($phase['title'], ENT_QUOTES, 'UTF-8') ?></span>
                    </h3>
                    <p class="bv-md-process__phase-desc"><?= htmlspecialchars($phase['body'], ENT_QUOTES, 'UTF-8') ?></p>
                    <ul class="bv-md-process__phase-list">
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
     05 // DEPLOYMENT TIMELINE
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-timeline" id="timeline" aria-labelledby="md-timeline-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">05 // DEPLOYMENT TIMELINE</span>
        <h2 class="bv-section__title" id="md-timeline-title">
            How long? <span class="bv-text-gradient">Depends on scope.</span>
        </h2>
        <p class="bv-section__lead">
            Mobile timelines vary widely based on feature complexity, platform count,
            and backend integration. Here's an honest breakdown — not a sales pitch.
            Every project gets a firm timeline in the proposal, and we under-promise
            on purpose.
        </p>
    </div>

    <div class="bv-md-timeline__table" role="table" aria-label="Deployment timelines by project scope">

        <div class="bv-md-timeline__row bv-md-timeline__row--header" role="row">
            <div class="bv-md-timeline__cell bv-md-timeline__cell--scope" role="columnheader">Scope</div>
            <div class="bv-md-timeline__cell bv-md-timeline__cell--example" role="columnheader">Examples</div>
            <div class="bv-md-timeline__cell bv-md-timeline__cell--weeks" role="columnheader">Timeline</div>
            <div class="bv-md-timeline__cell bv-md-timeline__cell--features" role="columnheader">Typical Features</div>
        </div>

        <?php foreach ($timeline as $t): ?>
            <div class="bv-md-timeline__row" role="row">
                <div class="bv-md-timeline__cell bv-md-timeline__cell--scope" role="cell">
                    <span class="bv-md-timeline__scope bv-font-viking-heading"><?= htmlspecialchars($t['scope'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="bv-md-timeline__cell bv-md-timeline__cell--example" role="cell">
                    <?= htmlspecialchars($t['example'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="bv-md-timeline__cell bv-md-timeline__cell--weeks" role="cell">
                    <span class="bv-md-timeline__weeks bv-font-sci-display"><?= htmlspecialchars($t['weeks'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="bv-md-timeline__cell bv-md-timeline__cell--features" role="cell">
                    <?= htmlspecialchars($t['features'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="bv-md-timeline__note">
        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
        <p>
            <strong>Store review adds time:</strong> Google Play reviews 1–3 business
            days, Apple App Store 1–7 business days. Plan for at least one rejection
            cycle per platform — it happens to almost everyone, including us. We build
            that buffer into every timeline.
        </p>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     06 // PRINCIPLES
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-principles" id="principles" aria-labelledby="md-principles-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">06 // THE PRINCIPLES</span>
        <h2 class="bv-section__title" id="md-principles-title">
            Four commitments. <span class="bv-text-gradient">Zero compromise.</span>
        </h2>
    </div>

    <div class="bv-md-principles__grid">
        <?php foreach ($principles as $p): ?>
            <article class="bv-md-principle bv-card">
                <span class="bv-md-principle__number bv-font-sci-display"><?= htmlspecialchars($p['num'], ENT_QUOTES, 'UTF-8') ?></span>
                <div class="bv-md-principle__body">
                    <h3 class="bv-md-principle__title"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p><?= htmlspecialchars($p['body'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     07 // ENGAGEMENT MODELS
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-engagements" id="engagement-models" aria-labelledby="md-engagements-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">07 // ENGAGEMENT MODELS</span>
        <h2 class="bv-section__title" id="md-engagements-title">
            Four ways to <span class="bv-text-gradient">work together.</span>
        </h2>
        <p class="bv-section__lead">
            Pick the model that fits your stage and budget. Every engagement
            includes scoping, written proposals with fixed pricing, weekly demos,
            full store submission, and 90 days of post-launch support.
        </p>
    </div>

    <div class="bv-md-engagements__grid">
        <?php foreach ($engagements as $e): ?>
            <article class="bv-md-engagement bv-card <?= !empty($e['featured']) ? 'bv-md-engagement--featured' : '' ?>">
                <?php if (!empty($e['featured'])): ?>
                    <div class="bv-md-engagement__featured-badge bv-font-sci-label">Most Popular</div>
                <?php endif; ?>

                <div class="bv-md-engagement__header">
                    <div class="bv-md-engagement__icon" aria-hidden="true">
                        <i class="<?= htmlspecialchars($e['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                    </div>
                    <div>
                        <h3 class="bv-md-engagement__name"><?= htmlspecialchars($e['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="bv-md-engagement__tagline"><?= htmlspecialchars($e['tagline'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>

                <div class="bv-md-engagement__price bv-font-sci-display">
                    <?= htmlspecialchars($e['price'], ENT_QUOTES, 'UTF-8') ?>
                </div>

                <p class="bv-md-engagement__desc"><?= htmlspecialchars($e['desc'], ENT_QUOTES, 'UTF-8') ?></p>

                <ul class="bv-md-engagement__includes" role="list">
                    <?php foreach ($e['includes'] as $item): ?>
                        <li>
                            <i class="fa-solid fa-check" aria-hidden="true"></i>
                            <span><?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="bv-md-engagement__best-for">
                    <span class="bv-font-sci-label">Best For</span>
                    <span><?= htmlspecialchars($e['best_for'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>

                <a href="/contact?engagement=<?= htmlspecialchars($e['id'], ENT_QUOTES, 'UTF-8') ?>" class="bv-btn bv-btn--primary bv-md-engagement__cta">
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    <span>Start This Engagement</span>
                </a>
            </article>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     08 // FAQ
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-faq" id="faq" aria-labelledby="md-faq-title">

    <div class="bv-section__header">
        <span class="bv-section__eyebrow">08 // FREQUENT QUESTIONS</span>
        <h2 class="bv-section__title" id="md-faq-title">
            The questions <span class="bv-text-gradient">everyone asks.</span>
        </h2>
    </div>

    <div class="bv-md-faq__list" role="list">
        <?php foreach ($faq as $i => $item): ?>
            <details class="bv-md-faq__item bv-card" id="faq-<?= $i ?>">
                <summary class="bv-md-faq__question">
                    <span><?= htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="bv-md-faq__icon" aria-hidden="true"><i class="fa-solid fa-chevron-down"></i></span>
                </summary>
                <div class="bv-md-faq__answer">
                    <p><?= htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </details>
        <?php endforeach; ?>
    </div>

</section>


<!-- ═══════════════════════════════════════════════════════════════════════
     FINAL CTA
     ═══════════════════════════════════════════════════════════════════════ -->
<section class="bv-section bv-md-cta" aria-labelledby="md-cta-title">

    <div class="bv-md-cta__inner">

        <span class="bv-md-cta__rune bv-font-runic" aria-hidden="true">ᛝ</span>

        <h2 class="bv-md-cta__title bv-font-viking-display" id="md-cta-title">
            Ready to ship something your users will actually keep installed?
        </h2>

        <p class="bv-md-cta__lead">
            Whether you're launching your first app or replacing a compromised
            cross-platform build with something native and hardened, reach out.
            Scoping call is free. NDA-friendly. Fixed-price proposals within a week.
        </p>

        <div class="bv-md-cta__actions">
            <a href="/contact?engagement=scoping" class="bv-btn bv-btn--primary bv-btn--xl">
                <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                <span>Schedule Scoping Call</span>
            </a>
            <a href="/portfolio" class="bv-btn bv-btn--ghost bv-btn--xl">
                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                <span>See Past Apps</span>
            </a>
        </div>

        <div class="bv-md-cta__meta">
            <span class="bv-md-cta__meta-item">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>
                <span>PGP: security@beardedviking.org</span>
            </span>
            <span class="bv-md-cta__meta-item">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <span>Response within 72 hours</span>
            </span>
            <span class="bv-md-cta__meta-item">
                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                <span>NDA-friendly</span>
            </span>
        </div>

    </div>

</section>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>