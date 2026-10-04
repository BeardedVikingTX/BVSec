<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Contact Form Handler
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      api/contact.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  SPAM DEFENSES:
 *    1. CSRF token validation (session)
 *    2. Hidden honeypot fields
 *    3. Time gate (3s–2h)
 *    4. JavaScript-enabled token
 *    5. Content heuristics (no links, no Cyrillic-only spam)
 *    6. Rate limiting (session + IP)
 *    7. Header sanity (referrer / user-agent)
 *
 *  RESPONSES (always JSON):
 *    { success: true, reference: "BVS-XXXXX" }
 *    { success: false, errors: { field: message } }
 *    { success: false, message: "..." }
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

// ──────────────────────────────────────────────────────────────────────────
//  Configuration
// ──────────────────────────────────────────────────────────────────────────
const BVSEC_ADMIN_EMAIL    = 'info@beardedviking.org';
const BVSEC_SECURITY_EMAIL = 'security@beardedviking.org';
const BVSEC_FROM_EMAIL     = 'noreply@beardedviking.org';
const BVSEC_FROM_NAME      = 'BVSec Contact';
const BVSEC_SITE_URL       = 'https://beardedviking.org';
const BVSEC_RATE_DIR       = __DIR__ . '/contact-rate';
const BVSEC_MIN_DELAY      = 3;         // seconds
const BVSEC_MAX_DELAY      = 7200;      // 2 hours

// ──────────────────────────────────────────────────────────────────────────
//  Headers — only JSON
// ──────────────────────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store, no-cache, must-revalidate');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ──────────────────────────────────────────────────────────────────────────
//  Helpers
// ──────────────────────────────────────────────────────────────────────────
function bv_json_out(array $payload, int $code = 200): never {
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function bv_json_error(string $message, array $errors = [], int $code = 400): never {
    bv_json_out([
        'success' => false,
        'message' => $message,
        'errors'  => $errors,
    ], $code);
}

function bv_sanitize(string $value, int $maxLen = 500): string {
    $value = trim($value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    if (mb_strlen($value) > $maxLen) {
        $value = mb_substr($value, 0, $maxLen);
    }
    return $value;
}

function bv_valid_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false
        && mb_strlen($email) <= 254;
}

/**
 * Rate limit using a flat-file store keyed by IP or session.
 * Limits: max 3 per hour, max 10 per 24 hours per key.
 */
function bv_rate_limit_check(string $key): array {
    if (!is_dir(BVSEC_RATE_DIR)) {
        @mkdir(BVSEC_RATE_DIR, 0750, true);
    }
    if (!is_dir(BVSEC_RATE_DIR) || !is_writable(BVSEC_RATE_DIR)) {
        return ['ok' => true]; // fail-open if rate dir unavailable
    }

    $file = BVSEC_RATE_DIR . '/' . preg_replace('/[^a-f0-9]/', '', hash('sha256', $key)) . '.json';
    $now  = time();
    $data = ['hour' => [], 'day' => []];

    if (is_file($file)) {
        $raw = @file_get_contents($file);
        if ($raw !== false) {
            $parsed = json_decode($raw, true);
            if (is_array($parsed)) {
                $data['hour'] = array_filter(
                    (array) ($parsed['hour'] ?? []),
                    fn($t) => is_int($t) && ($now - $t) < 3600
                );
                $data['day'] = array_filter(
                    (array) ($parsed['day'] ?? []),
                    fn($t) => is_int($t) && ($now - $t) < 86400
                );
            }
        }
    }

    if (count($data['hour']) >= 3) {
        return ['ok' => false, 'reason' => 'rate_hour'];
    }
    if (count($data['day']) >= 10) {
        return ['ok' => false, 'reason' => 'rate_day'];
    }

    $data['hour'][] = $now;
    $data['day'][]  = $now;

    @file_put_contents($file, json_encode($data), LOCK_EX);

    return ['ok' => true];
}

function bv_reference_code(): string {
    // BVS-XXXXX where X is alphanumeric (no ambiguous chars)
    $alphabet = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
    $len = strlen($alphabet) - 1;
    $code = '';
    for ($i = 0; $i < 5; $i++) {
        $code .= $alphabet[random_int(0, $len)];
    }
    return 'BVS-' . $code;
}

/**
 * Content heuristics — reject obvious spam.
 * Returns null if content is fine, or a reason string.
 */
function bv_content_heuristics(string $name, string $desc): ?string {
    // Link spam: any URL in the first 300 chars of the description
    $firstChunk = mb_substr($desc, 0, 300);
    if (preg_match('#https?://|www\.#i', $firstChunk)) {
        return 'no_links_in_intro';
    }
    // Cyrillic-only text in the name field (legit names rarely are)
    if ($name !== '' && preg_match('/^[\p{Cyrillic}\s]+$/u', $name)) {
        return 'cyrillic_name';
    }
    // Classic spam keywords
    $lower = mb_strtolower($desc);
    foreach (['seo services', 'crypto pump', 'guest post', 'buy backlinks', 'bitcoin mixer', 'casino'] as $kw) {
        if (str_contains($lower, $kw)) return 'keyword_spam';
    }
    return null;
}

// ──────────────────────────────────────────────────────────────────────────
//  1. Method check
// ──────────────────────────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    bv_json_error('Method not allowed.', [], 405);
}

// ──────────────────────────────────────────────────────────────────────────
//  2. Header sanity
// ──────────────────────────────────────────────────────────────────────────
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
if ($ua === '' || mb_strlen($ua) < 10) {
    bv_json_error('Invalid request.', [], 400);
}

$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$siteHost = parse_url(BVSEC_SITE_URL, PHP_URL_HOST) ?: '';

if ($origin !== '' && !str_contains($origin, $siteHost)) {
    bv_json_error('Invalid origin.', [], 403);
}

// ──────────────────────────────────────────────────────────────────────────
//  3. CSRF token
// ──────────────────────────────────────────────────────────────────────────
$posted_csrf = (string) ($_POST['csrf_token'] ?? '');
$session_csrf = (string) ($_SESSION['contact_csrf'] ?? '');

if ($posted_csrf === '' || $session_csrf === '' || !hash_equals($session_csrf, $posted_csrf)) {
    bv_json_error('Session expired. Please reload the page and try again.', [], 403);
}

// Invalidate the token immediately — single-use.
unset($_SESSION['contact_csrf']);

// ──────────────────────────────────────────────────────────────────────────
//  4. Honeypot check
// ──────────────────────────────────────────────────────────────────────────
if (!empty($_POST['website_url']) || !empty($_POST['email_confirm'])) {
    // Fake success to keep bots guessing.
    bv_json_out(['success' => true, 'reference' => bv_reference_code()]);
}

// ──────────────────────────────────────────────────────────────────────────
//  5. JS-enabled token
// ──────────────────────────────────────────────────────────────────────────
if (($_POST['js_enabled'] ?? '0') !== '1') {
    bv_json_error('JavaScript is required to submit this form. Please enable it and try again.', [], 400);
}

// ──────────────────────────────────────────────────────────────────────────
//  6. Time gate
// ──────────────────────────────────────────────────────────────────────────
$loaded_at = (int) ($_POST['form_loaded_at'] ?? 0);
$now = time();
$elapsed = $now - $loaded_at;

if ($loaded_at <= 0 || $elapsed < BVSEC_MIN_DELAY) {
    bv_json_error('The form was submitted too quickly. Please review your entries and try again.', [], 400);
}
if ($elapsed > BVSEC_MAX_DELAY) {
    bv_json_error('This form has been open too long. Please reload the page and try again.', [], 400);
}

// ──────────────────────────────────────────────────────────────────────────
//  7. Rate limiting
// ──────────────────────────────────────────────────────────────────────────
$ip = $_SERVER['HTTP_CF_CONNECTING_IP']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'unknown';
// Use only the first IP if a comma-separated list
$ip = trim(explode(',', (string) $ip)[0]);

$rate = bv_rate_limit_check('ip:' . $ip);
if (!$rate['ok']) {
    $msg = $rate['reason'] === 'rate_hour'
        ? 'Too many submissions from your network. Please wait an hour or email us directly.'
        : 'Daily submission limit reached. Please email us directly at info@beardedviking.org.';
    bv_json_error($msg, [], 429);
}

$rateSession = bv_rate_limit_check('sess:' . session_id());
if (!$rateSession['ok']) {
    bv_json_error('You already submitted recently. Please wait a few minutes.', [], 429);
}

// ──────────────────────────────────────────────────────────────────────────
//  8. Gather + validate fields
// ──────────────────────────────────────────────────────────────────────────
$errors = [];

$full_name   = bv_sanitize((string) ($_POST['full_name'] ?? ''), 120);
$position    = bv_sanitize((string) ($_POST['position'] ?? ''), 120);
$company     = bv_sanitize((string) ($_POST['company'] ?? ''), 160);
$email       = bv_sanitize((string) ($_POST['email'] ?? ''), 254);
$phone       = bv_sanitize((string) ($_POST['phone'] ?? ''), 40);
$preferred   = bv_sanitize((string) ($_POST['preferred_contact'] ?? 'email'), 20);
$description = bv_sanitize((string) ($_POST['project_description'] ?? ''), 5000);
$budget_type = bv_sanitize((string) ($_POST['budget_type'] ?? 'fixed'), 20);
$budget_rng  = bv_sanitize((string) ($_POST['budget_range'] ?? ''), 30);
$timeline    = bv_sanitize((string) ($_POST['timeline'] ?? ''), 30);
$start_date  = bv_sanitize((string) ($_POST['start_date'] ?? ''), 10);
$referral    = bv_sanitize((string) ($_POST['referral'] ?? ''), 200);
$timezone    = bv_sanitize((string) ($_POST['timezone'] ?? 'America/Chicago'), 40);

$services = array_values(array_filter(
    array_map(
        fn($s) => bv_sanitize((string) $s, 30),
        (array) ($_POST['services'] ?? [])
    )
));

// ── Validation
if (mb_strlen($full_name) < 2)  $errors['full_name'] = 'Full name is required.';
if (!bv_valid_email($email))    $errors['email']     = 'A valid email address is required.';

$phoneDigits = preg_replace('/\D+/', '', $phone) ?? '';
if (strlen($phoneDigits) < 7)   $errors['phone']     = 'A valid phone number is required.';

if (empty($services))           $errors['services']  = 'Select at least one service.';
if (mb_strlen($description) < 40) $errors['project_description'] = 'Please provide at least 40 characters.';

// Call slots
$call_slots = [];
for ($i = 1; $i <= 3; $i++) {
    $d = bv_sanitize((string) ($_POST["call_date_{$i}"] ?? ''), 10);
    $t = bv_sanitize((string) ($_POST["call_time_{$i}"] ?? ''), 5);
    if ($d === '' && $t === '' && $i > 1) continue; // empty optional slot is fine

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) {
        $errors["call_date_{$i}"] = 'Please select a valid date.';
        continue;
    }
    if (!preg_match('/^\d{2}:\d{2}$/', $t)) {
        $errors["call_time_{$i}"] = 'Please select a valid time.';
        continue;
    }
    if ($i === 1 && ($d === '' || $t === '')) {
        $errors['call_date_1'] = 'Please provide at least one call slot.';
        continue;
    }

    // Reject past dates
    $slotTs = strtotime($d . ' ' . $t);
    if ($slotTs === false || $slotTs < time() - 3600) {
        $errors["call_date_{$i}"] = 'Please choose a future date.';
        continue;
    }

    $call_slots[] = ['date' => $d, 'time' => $t];
}

// At least one valid slot required
if (empty($call_slots)) {
    $errors['call_date_1'] = 'Please provide at least one call slot.';
}

if (empty($_POST['consent']))   $errors['consent']   = 'Consent is required.';

// ── Content heuristics
$heuristic = bv_content_heuristics($full_name, $description);
if ($heuristic !== null) {
    // Log for review but don't tell the sender why.
    error_log('[BVSec contact] heuristic block: ' . $heuristic . ' ip=' . $ip);
    bv_json_error('Your message could not be processed. Please email info@beardedviking.org directly.', [], 400);
}

if (!empty($errors)) {
    bv_json_error('Please correct the highlighted fields.', $errors, 422);
}

// ──────────────────────────────────────────────────────────────────────────
//  9. Build the reference code
// ──────────────────────────────────────────────────────────────────────────
$reference = bv_reference_code();
$submitted_at = date('Y-m-d H:i:s T');

// Decode label maps for the email body
$service_labels = [
    'bug-bounty' => 'Bug Bounty Hunting',
    'web-dev'    => 'Custom Web Development',
    'mobile-dev' => 'Native Mobile App',
    'in-house'   => 'In-House / Custom Tooling',
    'audit'      => 'Security Audit',
    'other'      => 'Something Else',
];
$services_named = array_map(fn($s) => $service_labels[$s] ?? $s, $services);

// ──────────────────────────────────────────────────────────────────────────
//  10. Compose emails (HTML + plain text)
// ──────────────────────────────────────────────────────────────────────────
$safe = fn(string $s): string => htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

$ip_display  = $safe($ip);
$ref_display = $safe($reference);

// ══════════════════════════════════════════════════════════════════
//  ADMIN EMAIL
// ══════════════════════════════════════════════════════════════════
$adminSubject = "[BVSec] New Engagement Request — {$reference}";

$adminRows = '';
$addRow = function (string $label, string $value) use (&$adminRows, $safe): void {
    if ($value === '') return;
    $adminRows .= '<tr>'
        . '<td style="padding:8px 12px;border-bottom:1px solid #30363d;color:#8b949e;font-size:12px;width:180px;vertical-align:top;">' . $safe($label) . '</td>'
        . '<td style="padding:8px 12px;border-bottom:1px solid #30363d;color:#e6edf3;font-size:13px;vertical-align:top;">' . $value . '</td>'
        . '</tr>';
};

$addRow('Full Name',   $safe($full_name));
$addRow('Position',    $safe($position));
$addRow('Company',     $safe($company));
$addRow('Email',       '<a href="mailto:' . $safe($email) . '" style="color:#58a6ff;text-decoration:none;">' . $safe($email) . '</a>');
$addRow('Phone',       '<a href="tel:' . $safe($phone) . '" style="color:#58a6ff;text-decoration:none;">' . $safe($phone) . '</a>');
$addRow('Preferred Contact', $safe($preferred));
$addRow('Timezone',    $safe($timezone));

$servicesHtml = '';
if (!empty($services_named)) {
    $chips = array_map(fn($s) => '<span style="display:inline-block;margin:2px 4px 2px 0;padding:3px 8px;border-radius:4px;background:#1c2533;color:#58a6ff;font-size:11px;font-family:monospace;">' . $safe($s) . '</span>', $services_named);
    $servicesHtml = implode('', $chips);
}
$addRow('Services', $servicesHtml);

$addRow('Budget Type', $safe($budget_type));
$addRow('Budget Range', $safe($budget_rng ?: '—'));
$addRow('Timeline',    $safe($timeline ?: '—'));
$addRow('Preferred Start', $safe($start_date ?: '—'));
$addRow('Referral',    $safe($referral ?: '—'));

$slotsHtml = '';
if (!empty($call_slots)) {
    $slotsHtml = '<ul style="margin:0;padding-left:20px;color:#e6edf3;font-size:13px;font-family:monospace;line-height:1.7;">';
    foreach ($call_slots as $slot) {
        $ts = strtotime($slot['date'] . ' ' . $slot['time']);
        $display = $ts !== false ? date('D, M j, Y — g:i A', $ts) : ($slot['date'] . ' ' . $slot['time']);
        $slotsHtml .= '<li>' . $safe($display) . ' <span style="color:#8b949e;">(' . $safe($timezone) . ')</span></li>';
    }
    $slotsHtml .= '</ul>';
}
$addRow('Call Slots', $slotsHtml);

// Message body
$messageBody = nl2br($safe($description));

$adminHtml = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>New Engagement Request</title></head>
<body style="margin:0;padding:0;background:#0d1117;font-family:-apple-system,'Segoe UI',Helvetica,Arial,sans-serif;color:#e6edf3;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;">
        <tr><td align="center" style="padding:32px 16px;">
            <table role="presentation" width="640" cellpadding="0" cellspacing="0" style="max-width:640px;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">

                <!-- Header -->
                <tr><td style="padding:20px 28px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;text-transform:uppercase;">BVSEC // ENGAGEMENT REQUEST</div>
                                <div style="font-family:Georgia,serif;font-size:22px;font-weight:bold;color:#e6edf3;margin-top:6px;">New Submission</div>
                            </td>
                            <td align="right" style="font-family:'Courier New',monospace;font-size:14px;color:#f0883e;font-weight:bold;">{$ref_display}</td>
                        </tr>
                    </table>
                </td></tr>

                <!-- Body -->
                <tr><td style="padding:24px 28px;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        {$adminRows}
                    </table>

                    <!-- Message -->
                    <div style="margin-top:24px;padding-top:20px;border-top:1px solid #30363d;">
                        <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:2px;color:#8b949e;text-transform:uppercase;margin-bottom:10px;">PROJECT DESCRIPTION</div>
                        <div style="background:#0d1117;border:1px solid #30363d;border-radius:6px;padding:16px;color:#e6edf3;font-size:14px;line-height:1.7;">
                            {$messageBody}
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div style="margin-top:24px;padding-top:20px;border-top:1px solid #30363d;font-family:'Courier New',monospace;font-size:11px;color:#8b949e;line-height:1.7;">
                        <div>SUBMITTED: {$safe($submitted_at)}</div>
                        <div>IP: {$ip_display}</div>
                        <div>UA: {$safe(mb_substr($ua, 0, 200))}</div>
                    </div>

                    <!-- Reply CTAs -->
                    <div style="margin-top:24px;">
                        <a href="mailto:{$safe($email)}?subject=Re%3A%20Your%20BVSec%20engagement%20request%20{$ref_display}" style="display:inline-block;padding:12px 20px;background:#f0883e;color:#0d1117;font-family:'Courier New',monospace;font-size:12px;font-weight:bold;letter-spacing:1.5px;text-decoration:none;text-transform:uppercase;border-radius:6px;">Reply to {$safe($full_name)}</a>
                    </div>
                </td></tr>

                <!-- Footer -->
                <tr><td style="padding:16px 28px;background:#0d1117;border-top:1px solid #30363d;text-align:center;font-family:'Courier New',monospace;font-size:10px;color:#6e7681;letter-spacing:1px;">
                    BVSEC // BEARDED VIKING SECURITY FORGE // BEARDEDVIKING.ORG
                </td></tr>

            </table>
        </td></tr>
    </table>
</body>
</html>
HTML;

// Plain text version
$adminText = "BVSEC — NEW ENGAGEMENT REQUEST\n"
    . "Reference: {$reference}\n"
    . str_repeat("=", 60) . "\n\n"
    . "Name:              {$full_name}\n"
    . "Position:          {$position}\n"
    . "Company:           {$company}\n"
    . "Email:             {$email}\n"
    . "Phone:             {$phone}\n"
    . "Preferred Contact: {$preferred}\n"
    . "Timezone:          {$timezone}\n\n"
    . "Services:          " . implode(', ', $services_named) . "\n"
    . "Budget Type:       {$budget_type}\n"
    . "Budget Range:      {$budget_range_label}\n"
    . "Timeline:          {$timeline}\n"
    . "Preferred Start:   {$start_date}\n"
    . "Referral:          {$referral}\n\n"
    . "Call Slots:\n";
foreach ($call_slots as $slot) {
    $ts = strtotime($slot['date'] . ' ' . $slot['time']);
    $display = $ts !== false ? date('D, M j, Y — g:i A', $ts) : ($slot['date'] . ' ' . $slot['time']);
    $adminText .= "  - {$display} ({$timezone})\n";
}
$adminText .= "\n" . str_repeat("-", 60) . "\n"
    . "PROJECT DESCRIPTION:\n\n{$description}\n\n"
    . str_repeat("-", 60) . "\n"
    . "Submitted: {$submitted_at}\n"
    . "IP: {$ip}\n";

// ══════════════════════════════════════════════════════════════════
//  USER AUTO-RESPONSE EMAIL
// ══════════════════════════════════════════════════════════════════
$userSubject = "We received your engagement request — {$reference}";

$servicesUserHtml = implode('', array_map(
    fn($s) => '<li style="margin:4px 0;color:#e6edf3;">' . $safe($s) . '</li>',
    $services_named
));

$slotsUserHtml = '';
foreach ($call_slots as $slot) {
    $ts = strtotime($slot['date'] . ' ' . $slot['time']);
    $display = $ts !== false ? date('D, M j, Y — g:i A', $ts) : ($slot['date'] . ' ' . $slot['time']);
    $slotsUserHtml .= '<li style="margin:6px 0;color:#e6edf3;font-family:monospace;"><strong style="color:#f0883e;">' . $safe($display) . '</strong> <span style="color:#8b949e;">(' . $safe($timezone) . ')</span></li>';
}

$userHtml = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>We received your request</title></head>
<body style="margin:0;padding:0;background:#0d1117;font-family:-apple-system,'Segoe UI',Helvetica,Arial,sans-serif;color:#e6edf3;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;">
        <tr><td align="center" style="padding:32px 16px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">

                <tr><td style="padding:24px 28px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;text-align:center;">
                    <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;text-transform:uppercase;">BVSEC // BEARDED VIKING SECURITY FORGE</div>
                    <div style="font-family:Georgia,serif;font-size:26px;font-weight:bold;color:#e6edf3;margin-top:8px;">Message Received.</div>
                </td></tr>

                <tr><td style="padding:28px;">
                    <p style="margin:0 0 16px;color:#e6edf3;font-size:15px;line-height:1.7;">Hi {$safe($full_name)},</p>

                    <p style="margin:0 0 16px;color:#c9d1d9;font-size:14px;line-height:1.7;">
                        Thank you for reaching out. Your engagement request has landed in our inbox and will be reviewed personally within the next <strong style="color:#f0883e;">72 hours</strong>.
                    </p>

                    <div style="background:#0d1117;border:1px solid #30363d;border-left:3px solid #f0883e;border-radius:6px;padding:14px 18px;margin:20px 0;">
                        <div style="font-family:'Courier New',monospace;font-size:10px;letter-spacing:2px;color:#8b949e;text-transform:uppercase;margin-bottom:4px;">YOUR REFERENCE CODE</div>
                        <div style="font-family:'Courier New',monospace;font-size:18px;font-weight:bold;color:#f0883e;letter-spacing:2px;">{$ref_display}</div>
                    </div>

                    <p style="margin:24px 0 12px;color:#e6edf3;font-size:15px;font-weight:bold;">What you told us:</p>

                    <ul style="margin:0 0 20px;padding-left:20px;font-size:13px;line-height:1.7;">
                        <li style="margin:4px 0;color:#c9d1d9;"><strong style="color:#e6edf3;">Services:</strong></li>
                    </ul>
                    <ul style="margin:-12px 0 20px 20px;padding-left:20px;font-size:13px;">
                        {$servicesUserHtml}
                    </ul>

                    <p style="margin:20px 0 8px;color:#e6edf3;font-size:14px;font-weight:bold;">Proposed call windows:</p>
                    <ul style="margin:0 0 20px;padding-left:24px;">
                        {$slotsUserHtml}
                    </ul>

                    <p style="margin:24px 0 12px;color:#e6edf3;font-size:15px;font-weight:bold;">What happens next:</p>
                    <ol style="margin:0 0 20px;padding-left:24px;color:#c9d1d9;font-size:13px;line-height:1.8;">
                        <li>We review your submission personally.</li>
                        <li>We pick one of your proposed call windows and send a calendar invite.</li>
                        <li>We have a scoping call — no sales pressure, just a conversation.</li>
                        <li>You receive a fixed-price proposal within a week.</li>
                    </ol>

                    <div style="background:#0d1117;border:1px solid #30363d;border-radius:6px;padding:14px 18px;margin:20px 0;">
                        <div style="font-family:'Courier New',monospace;font-size:11px;color:#8b949e;line-height:1.6;">
                            <strong style="color:#e6edf3;">Need to reach us sooner?</strong><br>
                            Email: <a href="mailto:info@beardedviking.org" style="color:#58a6ff;text-decoration:none;">info@beardedviking.org</a><br>
                            Security disclosures: <a href="mailto:security@beardedviking.org" style="color:#3fb950;text-decoration:none;">security@beardedviking.org</a> (PGP encouraged)
                        </div>
                    </div>

                    <p style="margin:24px 0 0;color:#8b949e;font-size:13px;line-height:1.7;font-style:italic;">
                        &mdash; BeardedVikingTX<br>
                        <span style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:1px;">BVSEC // BEARDED VIKING SECURITY FORGE</span>
                    </p>
                </td></tr>

                <tr><td style="padding:16px 28px;background:#0d1117;border-top:1px solid #30363d;text-align:center;font-family:'Courier New',monospace;font-size:10px;color:#6e7681;letter-spacing:1px;">
                    Fort Worth, TX &nbsp;&middot;&nbsp; Sullivan, IL &nbsp;&middot;&nbsp; beardedviking.org
                </td></tr>

            </table>
        </td></tr>
    </table>
</body>
</html>
HTML;

$userText = "BVSEC — MESSAGE RECEIVED\n"
    . str_repeat("=", 60) . "\n\n"
    . "Hi {$full_name},\n\n"
    . "Thank you for reaching out. Your engagement request has landed in our inbox and will be reviewed personally within the next 72 hours.\n\n"
    . "YOUR REFERENCE CODE: {$reference}\n\n"
    . "SERVICES YOU SELECTED:\n";
foreach ($services_named as $s) {
    $userText .= "  - {$s}\n";
}
$userText .= "\nPROPOSED CALL WINDOWS:\n";
foreach ($call_slots as $slot) {
    $ts = strtotime($slot['date'] . ' ' . $slot['time']);
    $display = $ts !== false ? date('D, M j, Y — g:i A', $ts) : ($slot['date'] . ' ' . $slot['time']);
    $userText .= "  - {$display} ({$timezone})\n";
}
$userText .= "\nWHAT HAPPENS NEXT:\n"
    . "  1. We review your submission personally.\n"
    . "  2. We pick one of your proposed call windows and send a calendar invite.\n"
    . "  3. We have a scoping call.\n"
    . "  4. You receive a fixed-price proposal within a week.\n\n"
    . "Need to reach us sooner?\n"
    . "  Email: info@beardedviking.org\n"
    . "  Security: security@beardedviking.org (PGP encouraged)\n\n"
    . "— BeardedVikingTX\n"
    . "BVSEC // BEARDED VIKING SECURITY FORGE\n"
    . "Fort Worth, TX · Sullivan, IL · beardedviking.org\n";

// ──────────────────────────────────────────────────────────────────────────
//  11. Send emails via mail() with multipart MIME
// ──────────────────────────────────────────────────────────────────────────
/**
 * Send a multipart HTML+text email.
 */
function bv_send_email(string $to, string $subject, string $html, string $text, string $replyTo = ''): bool {
    $boundary = 'bvs_' . bin2hex(random_bytes(16));
    $domain = parse_url(BVSEC_SITE_URL, PHP_URL_HOST) ?: 'beardedviking.org';
    $msgId = '<' . bin2hex(random_bytes(12)) . '@' . $domain . '>';

    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
    $headers[] = 'From: ' . BVSEC_FROM_NAME . ' <' . BVSEC_FROM_EMAIL . '>';
    if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }
    $headers[] = 'Message-ID: ' . $msgId;
    $headers[] = 'X-Mailer: BVSec-Contact/1.0';
    $headers[] = 'X-Priority: 3';
    $headers[] = 'Date: ' . date('r');

    $body = "--{$boundary}\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: 8bit\r\n\r\n"
        . $text . "\r\n\r\n"
        . "--{$boundary}\r\n"
        . "Content-Type: text/html; charset=UTF-8\r\n"
        . "Content-Transfer-Encoding: 8bit\r\n\r\n"
        . $html . "\r\n\r\n"
        . "--{$boundary}--\r\n";

    $subjectHeader = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $toHeader = $to;

    return @mail(
        $toHeader,
        $subjectHeader,
        $body,
        implode("\r\n", $headers),
        '-f ' . BVSEC_FROM_EMAIL
    );
}

$adminSent = bv_send_email(BVSEC_ADMIN_EMAIL, $adminSubject, $adminHtml, $adminText, $email);
$userSent  = bv_send_email($email, $userSubject, $userHtml, $userText, BVSEC_ADMIN_EMAIL);

// Log the outcome (email failures don't fail the submission)
if (!$adminSent) error_log('[BVSec contact] admin email FAILED for ' . $reference);
if (!$userSent)  error_log('[BVSec contact] user email FAILED for ' . $reference . ' to ' . $email);

// Append to a local log file (audit trail)
$logLine = sprintf(
    "[%s] %s | %s | %s | %s\n",
    date('c'),
    $reference,
    $email,
    $ip,
    implode(',', $services_named)
);
@file_put_contents(
    __DIR__ . '/contact-log.txt',
    $logLine,
    FILE_APPEND | LOCK_EX
);

// ──────────────────────────────────────────────────────────────────────────
//  12. Return success
// ──────────────────────────────────────────────────────────────────────────
bv_json_out([
    'success'     => true,
    'reference'   => $reference,
    'admin_sent'  => $adminSent,
    'user_sent'   => $userSent,
    'submitted'   => $submitted_at,
]);