<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Global Header
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      includes/header.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  PURPOSE:
 *    Dynamic <head> + opening <body> for every page. Handles:
 *      - Per-page meta (title, description, canonical, OG, Twitter)
 *      - Security response headers (CSP nonce, HSTS, etc.)
 *      - CDN asset loading (Bootstrap, Tailwind, Font Awesome, Google Fonts)
 *      - Core Web Vitals optimization (preconnect, preload, defer)
 *      - External stylesheet loading with automatic cache busting
 *
 *  USAGE (from any page):
 *      $page = [
 *          'title'       => 'Bug Bounty Hunting Services',
 *          'description' => 'Professional vulnerability research...',
 *          'canonical'   => '/services',
 *          'og_type'     => 'website',
 *          'og_image'    => '/assets/images/og/services.png',
 *          'noindex'     => false,
 *          'body_class'  => 'page-services',
 *      ];
 *      require_once __DIR__ . '/../includes/header.php';
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

// ──────────────────────────────────────────────────────────────────────────
//  0. HARDENING — start session safely, bootstrap config
// ──────────────────────────────────────────────────────────────────────────

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => true,        // HTTPS only
        'httponly' => true,        // No JS access
        'samesite' => 'Lax',       // CSRF mitigation
    ]);
    session_start();
}

// ──────────────────────────────────────────────────────────────────────────
//  1. ASSET VERSIONING — automatic cache busting via filemtime()
// ──────────────────────────────────────────────────────────────────────────

// Absolute path to the stylesheet, relative to this file.
$bvsec_css_abs = __DIR__ . '/../assets/css/bvsec.css';
$bvsec_css_ver = file_exists($bvsec_css_abs) ? filemtime($bvsec_css_abs) : time();

// Path and versioned URL used in the <link> tag below.
$bvsec_css_url = '/assets/css/bvsec.css?v=' . $bvsec_css_ver;

// (Future) Additional asset versioning as we add JS bundles, etc.
// $bvsec_js_abs = __DIR__ . '/../assets/js/bvsec.js';
// $bvsec_js_ver = file_exists($bvsec_js_abs) ? filemtime($bvsec_js_abs) : time();

// ──────────────────────────────────────────────────────────────────────────
//  2. SECURITY RESPONSE HEADERS (OWASP 2026 baseline)
// ──────────────────────────────────────────────────────────────────────────

// Generate a per-request CSP nonce. Must be cryptographically strong.
$csp_nonce = base64_encode(random_bytes(32));

// Core security headers. Ordered: most restrictive first.
$security_headers = [
    // Content-Security-Policy — the heavyweight. Nonce-based, strict-dynamic.
    //
    // ⚠️  TODO (production hardening):
    //   style-src currently includes 'unsafe-inline' because Tailwind's Play
    //   CDN injects <style> elements at runtime without nonces. Once Tailwind
    //   is built locally (see tailwind.config.js + npm run build), remove
    //   'unsafe-inline' from style-src to close this gap.
    //
    // ⚠️  TODO (production hardening):
    //   Replace deprecated 'report-uri' with 'report-to' once the Reporting
    //   API endpoint and Report-To header are wired up.
    'Content-Security-Policy' =>
        "default-src 'self'; " .
        "base-uri 'none'; " .
        "object-src 'none'; " .
        "frame-ancestors 'none'; " .
        "form-action 'self'; " .
        "script-src 'nonce-{$csp_nonce}' 'strict-dynamic' 'unsafe-eval' " .
            "https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
        "style-src 'self' 'nonce-{$csp_nonce}' 'unsafe-inline' " .
            "https://cdn.jsdelivr.net https://cdnjs.cloudflare.com " .
            "https://fonts.googleapis.com; " .
        "font-src 'self' https://cdnjs.cloudflare.com https://fonts.gstatic.com; " .
        "img-src 'self' data: https:; " .
        "connect-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; " .
        "manifest-src 'self'; " .
        "upgrade-insecure-requests; " .
        "block-all-mixed-content; " .
        "report-uri /api/csp-report.php;",

    // Enforce HTTPS for 2 years, include subdomains, eligible for preload.
    'Strict-Transport-Security' => 'max-age=63072000; includeSubDomains; preload',

    // Disable MIME sniffing — browser must trust declared Content-Type.
    'X-Content-Type-Options' => 'nosniff',

    // Legacy XSS filter — set to 0 per OWASP 2026 (the filter is broken & bypassable).
    // CSP is the real defense now.
    'X-XSS-Protection' => '0',

    // Clickjacking defense (CSP frame-ancestors is primary; this is fallback).
    'X-Frame-Options' => 'DENY',

    // Don't leak full URL to third parties.
    'Referrer-Policy' => 'strict-origin-when-cross-origin',

    // Kill unused browser features. Add as needed.
    'Permissions-Policy' =>
        'accelerometer=(), ' .
        'ambient-light-sensor=(), ' .
        'autoplay=(), ' .
        'battery=(), ' .
        'camera=(), ' .
        'display-capture=(), ' .
        'document-domain=(), ' .
        'encrypted-media=(), ' .
        'fullscreen=(self), ' .
        'geolocation=(), ' .
        'gyroscope=(), ' .
        'magnetometer=(), ' .
        'microphone=(), ' .
        'midi=(), ' .
        'payment=(), ' .
        'picture-in-picture=(), ' .
        'publickey-credentials-get=(), ' .
        'screen-wake-lock=(), ' .
        'sync-xhr=(), ' .
        'usb=(), ' .
        'xr-spatial-tracking=()',

    // Isolate browsing context (Spectre mitigation).
    'Cross-Origin-Opener-Policy' => 'same-origin',

    // Block cross-origin reads of your resources (Spectre mitigation).
    'Cross-Origin-Resource-Policy' => 'same-origin',

    // Require same-origin embedding (Spectre mitigation).
    'Cross-Origin-Embedder-Policy' => 'require-corp',

    // Don't cache sensitive pages (override per-page if needed).
    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
    'Pragma'        => 'no-cache',
];

// Strip X-Powered-By (don't advertise PHP version).
header_remove('X-Powered-By');

// Emit headers — only if headers haven't been sent yet.
if (!headers_sent()) {
    foreach ($security_headers as $name => $value) {
        header("{$name}: {$value}", true);
    }
}

// ──────────────────────────────────────────────────────────────────────────
//  3. PAGE META DEFAULTS — merged with $page passed by caller
// ──────────────────────────────────────────────────────────────────────────

$site = [
    'name'        => 'BVSec',
    'full_name'   => 'Bearded Viking Security Forge',
    'domain'      => 'beardedviking.org',
    'base_url'    => 'https://beardedviking.org',
    'author'      => 'BeardedVikingTX',
    'twitter'     => '@BeardedVikingTX',
    'default_desc'=> 'Bug bounty hunting, custom web & mobile development, and privacy-first engineering. Home of MyCitadel.',
    'og_image'    => '/assets/images/og/bvsec-default.png',
    'theme_color' => '#0d1117',
];

// Defaults — every key a page can override.
$defaults = [
    'title'       => $site['full_name'],
    'description' => $site['default_desc'],
    'canonical'   => $_SERVER['REQUEST_URI'] ?? '/',
    'og_type'     => 'website',
    'og_image'    => $site['og_image'],
    'og_image_alt'=> $site['full_name'] . ' — ' . $site['default_desc'],
    'twitter_card'=> 'summary_large_image',
    'noindex'     => false,
    'body_class'  => '',
    'robots'      => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
];

// Merge caller-supplied $page over defaults.
$page = array_merge($defaults, $page ?? []);

// Build absolute canonical URL.
$canonical_url = rtrim($site['base_url'], '/') . '/' . ltrim($page['canonical'], '/');

// Build absolute OG image URL.
$og_image_url = (str_starts_with($page['og_image'], 'http'))
    ? $page['og_image']
    : rtrim($site['base_url'], '/') . '/' . ltrim($page['og_image'], '/');

// Full page title (brand suffix, except on homepage).
$full_title = ($page['canonical'] === '/' || $page['canonical'] === '')
    ? $page['title']
    : $page['title'] . ' | ' . $site['name'];

// robots override.
$robots = $page['noindex']
    ? 'noindex, nofollow'
    : $page['robots'];

// JSON-LD structured data (Organization / WebSite).
$jsonld = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'Organization',
            '@id'         => $site['base_url'] . '/#organization',
            'name'        => $site['full_name'],
            'alternateName'=> $site['name'],
            'url'         => $site['base_url'],
            'logo'        => $site['base_url'] . '/assets/images/bvsec-logo.png',
            'description' => $site['default_desc'],
            'sameAs'      => [
                'https://github.com/BeardedVikingTX',
                'https://mycitadel.lol',
            ],
            'contactPoint' => [
                '@type'       => 'ContactPoint',
                'contactType' => 'Genearl',
                'email'       => 'info@beardedviking.org',
            ],
        ],
        [
            '@type'       => 'WebSite',
            '@id'         => $site['base_url'] . '/#website',
            'url'         => $site['base_url'],
            'name'        => $site['name'],
            'publisher'   => ['@id' => $site['base_url'] . '/#organization'],
            'inLanguage'  => 'en-US',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- ═══ PRIMARY META ═══ -->
<title><?= htmlspecialchars($full_title, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($page['description'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="author" content="<?= htmlspecialchars($site['author'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="robots" content="<?= htmlspecialchars($robots, ENT_QUOTES, 'UTF-8') ?>">
<meta name="theme-color" content="<?= htmlspecialchars($site['theme_color'], ENT_QUOTES, 'UTF-8') ?>">
<link rel="canonical" href="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>">

<!-- ═══ OPEN GRAPH (Facebook, LinkedIn, Discord) ═══ -->
<meta property="og:type" content="<?= htmlspecialchars($page['og_type'], ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:site_name" content="<?= htmlspecialchars($site['full_name'], ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:title" content="<?= htmlspecialchars($full_title, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($page['description'], ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image" content="<?= htmlspecialchars($og_image_url, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:image:alt" content="<?= htmlspecialchars($page['og_image_alt'], ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:locale" content="en_US">

<!-- ═══ TWITTER / X CARD ═══ -->
<meta name="twitter:card" content="<?= htmlspecialchars($page['twitter_card'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:site" content="<?= htmlspecialchars($site['twitter'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:creator" content="<?= htmlspecialchars($site['twitter'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:title" content="<?= htmlspecialchars($full_title, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($page['description'], ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($og_image_url, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image:alt" content="<?= htmlspecialchars($page['og_image_alt'], ENT_QUOTES, 'UTF-8') ?>">

<!-- ═══ PERFORMANCE — DNS + TLS warm-up before any asset request ═══ -->
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

<!-- ═══ FAVICONS ═══ -->
<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/assets/images/safari-pinned-tab.svg" color="#0d1117">

<!-- ═══════════════════════════════════════════════════════════════════
     GOOGLE FONTS — The Viking Arsenal
     10 fonts across three archetypes: Viking, Hacker, Sci-Fi.
     Loaded as a single request. display=swap avoids invisible text.
     ═══════════════════════════════════════════════════════════════════ -->
<link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=
        Cinzel:wght@400;600;700;900&
        Cinzel+Decorative:wght@700;900&
        MedievalSharp&
        Uncial+Antiqua&
        Skranji:wght@400;700&
        Germania+One&
        JetBrains+Mono:wght@400;500;700&
        Fira+Code:wght@400;500;700&
        Orbitron:wght@400;700;900&
        Space+Grotesk:wght@300;400;500;600;700&
        Michroma&
        Rubik+Glitch&
        Noto+Sans+Runic&
        display=swap"
>
<!--
    ┌─────────────────────────────────────────────────────────────────┐
    │  VIKING / NORSE                                                │
    │  Cinzel          → Roman-carved serif. Headlines, nav, authority│
    │  Cinzel Decorative → Ornate variant. Hero titles.              │
    │  MedievalSharp   → Blackletter-inspired. Medieval documents.    │
    │  Uncial Antiqua  → Illuminated-manuscript uncial. Lore sections.│
    │  Skranji         → Norse-god display. Rare, high-impact moments.│
    │  Germania One    → Germanic blackletter. Authentic Viking.      │
    │                                                                 │
    │  HACKER / TERMINAL                                             │
    │  JetBrains Mono  → Code blocks, terminal output, primary mono.  │
    │  Fira Code       → Ligature-rich mono. Security reports.        │
    │  Noto Sans Runic → Actual Unicode runes (U+16A0–U+16FF).        │
    │                                                                 │
    │  SCI-FI / FUTURISTIC                                           │
    │  Orbitron        → Geometric cyberpunk. The sci-fi classic.     │
    │  Space Grotesk   → Technical sans. Body copy, technical text.  │
    │  Michroma        → Wide techno. Badges, labels.                 │
    │  Rubik Glitch    → Glitch/cyberpunk display. Error pages.      │
    └─────────────────────────────────────────────────────────────────┘
-->

<!-- ═══ FONT AWESOME 6.7.2 (latest free) ═══ -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
>

<!-- ═══ BOOTSTRAP 5.3.8 (CSS) ═══ -->
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous"
>

<!-- ═══ BVSEC CORE STYLESHEET (own design system — overrides third-party) ═══ -->
<!-- Loaded after Bootstrap/FontAwesome so our rules win in the cascade.     -->
<!-- Cache-busted automatically via filemtime() in PHP block above.          -->
<link
    rel="stylesheet"
    href="<?= htmlspecialchars($bvsec_css_url, ENT_QUOTES, 'UTF-8') ?>"
>

<!-- ═══ BVSEC NAVIGATION STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_nav.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_nav.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_nav.css') : time() ?>">

<!-- ═══ BVSEC FOOTER STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_footer.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_footer.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_footer.css') : time() ?>">

<!-- ═══ BVSEC MAIN STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_main.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_main.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_main.css') : time() ?>">

<!-- ═══ BVSEC ABOUT PAGE STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_about.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_about.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_about.css') : time() ?>">

<!-- ═══ BVSEC PORTFOLIO STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_portfolio.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_portfolio.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_portfolio.css') : time() ?>">

<!-- ═══ BVSEC BUG BOUNTY STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_bug_bounty.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_bug_bounty.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_bug_bounty.css') : time() ?>">

<!-- ═══ BVSEC WEB DEVELOPMENT STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_web_development.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_web_development.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_web_development.css') : time() ?>">

<!-- ═══ BVSEC MOBILE DEVELOPMENT STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_mobile_development.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_mobile_development.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_mobile_development.css') : time() ?>">

<!-- ═══ BVSEC IN-HOUSE STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_in_house.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_in_house.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_in_house.css') : time() ?>">

<!-- ═══ BVSEC SERVICES HUB STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_services.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_services.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_services.css') : time() ?>">

<!-- ═══ BVSEC CONTACT STYLESHEET ═══ -->
<link rel="stylesheet" href="/assets/css/bvsec_contact.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_contact.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_contact.css') : time() ?>">

<!-- ═══ BVSEC SALES TOOL STYLESHEET (page-scoped) ═══ -->
<?php if (($page['body_class'] ?? '') === 'page-sales-tool'): ?>
<link rel="stylesheet" href="/assets/css/bvsec_sales_tool.css?v=<?= file_exists(__DIR__ . '/../assets/css/bvsec_sales_tool.css') ? filemtime(__DIR__ . '/../assets/css/bvsec_sales_tool.css') : time() ?>">
<script
    src="/assets/js/bvsec_sales_tool.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_sales_tool.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_sales_tool.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>
<?php endif; ?>

<!-- ═══ TAILWIND CSS 4.3.3 (Play CDN — DEV ONLY) ═══ -->
<!-- ⚠️  PRODUCTION: replace with locally built Tailwind. See tailwind.config.js. -->
<!-- ⚠️  After the build, remove 'unsafe-inline' from style-src in the CSP.    -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4.3.3"></script>

<!-- ═══ JSON-LD STRUCTURED DATA ═══ -->
<script type="application/ld+json" nonce="<?= $csp_nonce ?>">
<?= json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
</head>

<body class="<?= htmlspecialchars($page['body_class'], ENT_QUOTES, 'UTF-8') ?>">

<!-- ═══ SKIP LINK (a11y) ═══ -->
<a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>

<!-- ═══ BOOTSTRAP JS (deferred — doesn't block render) ═══ -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC NAVIGATION CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_nav.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_nav.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_nav.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC FOOTER CONTROLLER (deferred) ═══ -->
<script
    src="/assets/js/bvsec_footer.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_footer.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_footer.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC MAIN CONTROLLER (deferred) ═══ -->
<script
    src="/assets/js/bvsec_main.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_main.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_main.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC ABOUT PAGE CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_about.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_about.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_about.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC PORTFOLIO CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_portfolio.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_portfolio.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_portfolio.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC BUG BOUNTY CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_bug_bounty.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_bug_bounty.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_bug_bounty.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC WEB DEVELOPMENT CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_web_development.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_web_development.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_web_development.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC MOBILE DEVELOPMENT CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_mobile_development.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_mobile_development.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_mobile_development.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC IN-HOUSE CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_in_house.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_in_house.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_in_house.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC SERVICES HUB CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_services.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_services.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_services.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ BVSEC CONTACT CONTROLLER ═══ -->
<script
    src="/assets/js/bvsec_contact.js?v=<?= file_exists(__DIR__ . '/../assets/js/bvsec_contact.js') ? filemtime(__DIR__ . '/../assets/js/bvsec_contact.js') : time() ?>"
    defer
    nonce="<?= $csp_nonce ?>"
></script>

<!-- ═══ CSP VIOLATION REPORTER (client-side, non-blocking) ═══ -->
<script nonce="<?= $csp_nonce ?>">
    document.addEventListener('securitypolicyviolation', function (e) {
        if (navigator.sendBeacon) {
            navigator.sendBeacon('/api/csp-report.php', JSON.stringify({
                'csp-report': {
                    'document-uri':        e.documentURI,
                    'violated-directive':  e.violatedDirective,
                    'blocked-uri':         e.blockedURI,
                    'original-policy':     e.originalPolicy,
                    'source-file':         e.sourceFile,
                    'line-number':         e.lineNumber,
                    'column-number':       e.columnNumber,
                }
            }));
        }
    });
</script>

<?php
// ──────────────────────────────────────────────────────────────────────────
//  Expose the nonce to downstream code (inline scripts, form tokens, etc.)
// ──────────────────────────────────────────────────────────────────────────
$GLOBALS['csp_nonce'] = $csp_nonce;