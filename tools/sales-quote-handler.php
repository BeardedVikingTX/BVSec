<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Sales Quote Handler
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      tools/sales-quote-handler.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

// ──────────────────────────────────────────────────────────────────────────
//  Config
// ──────────────────────────────────────────────────────────────────────────
const BVSEC_ADMIN_EMAIL = 'info@beardedviking.org';
const BVSEC_FROM_EMAIL  = 'quotes@beardedviking.org';
const BVSEC_FROM_NAME   = 'BVSec Sales';
const BVSEC_SITE_URL    = 'https://beardedviking.org';
const BVSEC_LOG_DIR     = __DIR__ . '/../storage';

$AGENTS = [
    'viking' => ['name' => 'BeardedVikingTX', 'role' => 'Owner'],
    'son'    => ['name' => 'BeardedViking Jr.', 'role' => 'Commissioned Agent'],
    'friend' => ['name' => 'Guest Agent', 'role' => 'Commissioned Agent'],
];

// ──────────────────────────────────────────────────────────────────────────
//  Helpers
// ──────────────────────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

if (session_status() === PHP_SESSION_NONE) session_start();

function jout(array $payload, int $code = 200): never {
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
function jerr(string $message, array $errors = [], int $code = 400): never {
    jout(['success' => false, 'message' => $message, 'errors' => $errors], $code);
}
function s(string $v, int $max = 500): string {
    $v = trim($v);
    $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v) ?? '';
    if (mb_strlen($v) > $max) $v = mb_substr($v, 0, $max);
    return $v;
}
function valid_email(string $e): bool {
    return filter_var($e, FILTER_VALIDATE_EMAIL) !== false && mb_strlen($e) <= 254;
}
function ref_code(): string {
    $alphabet = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
    $len = strlen($alphabet) - 1;
    $code = '';
    for ($i = 0; $i < 5; $i++) $code .= $alphabet[random_int(0, $len)];
    return 'Q-' . date('ymd') . '-' . $code;
}

/**
 * Send multipart HTML+text email with custom Reply-To.
 */
function send_email(string $to, string $subject, string $html, string $text, string $replyTo = ''): bool {
    $boundary = 'bvs_' . bin2hex(random_bytes(16));
    $domain = parse_url(BVSEC_SITE_URL, PHP_URL_HOST) ?: 'beardedviking.org';
    $msgId = '<' . bin2hex(random_bytes(12)) . '@' . $domain . '>';

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: multipart/alternative; boundary="' . $boundary . '"',
        'From: ' . BVSEC_FROM_NAME . ' <' . BVSEC_FROM_EMAIL . '>',
        'Message-ID: ' . $msgId,
        'X-Mailer: BVSec-Sales/1.0',
        'X-Priority: 3',
        'Date: ' . date('r'),
    ];
    if ($replyTo !== '' && valid_email($replyTo)) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }

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
    return @mail($to, $subjectHeader, $body, implode("\r\n", $headers), '-f ' . BVSEC_FROM_EMAIL);
}

// ──────────────────────────────────────────────────────────────────────────
//  Method + basic sanity
// ──────────────────────────────────────────────────────────────────────────
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') jerr('Method not allowed.', [], 405);

$ip = $_SERVER['HTTP_CF_CONNECTING_IP']
    ?? $_SERVER['HTTP_X_FORWARDED_FOR']
    ?? $_SERVER['REMOTE_ADDR']
    ?? 'unknown';
$ip = trim(explode(',', (string) $ip)[0]);

// ──────────────────────────────────────────────────────────────────────────
//  Gather + validate
// ──────────────────────────────────────────────────────────────────────────
$errors = [];

$agent_id      = s((string) ($_POST['agent_name'] ?? ''), 30);
$client_name   = s((string) ($_POST['client_name'] ?? ''), 120);
$client_co     = s((string) ($_POST['client_company'] ?? ''), 160);
$client_pos    = s((string) ($_POST['client_position'] ?? ''), 120);
$client_email  = s((string) ($_POST['client_email'] ?? ''), 254);
$client_phone  = s((string) ($_POST['client_phone'] ?? ''), 40);
$client_years  = s((string) ($_POST['client_years'] ?? ''), 30);
$client_loc    = s((string) ($_POST['client_location'] ?? ''), 120);

$summary       = s((string) ($_POST['service_summary'] ?? ''), 2000);

$services = [
    'web'     => !empty($_POST['service_web']),
    'android' => !empty($_POST['service_android']),
    'ios'     => !empty($_POST['service_ios']),
    'pentest' => !empty($_POST['service_pentest']),
];

$budget_type   = s((string) ($_POST['budget_type'] ?? ''), 20);
$budget_total  = (float) ($_POST['budget_total'] ?? 0);
$budget_web    = (float) ($_POST['budget_web'] ?? 0);
$budget_android= (float) ($_POST['budget_android'] ?? 0);
$budget_ios    = (float) ($_POST['budget_ios'] ?? 0);

$timeline_start    = s((string) ($_POST['timeline_start'] ?? ''), 30);
$timeline_complete = s((string) ($_POST['timeline_complete'] ?? ''), 30);

$agent_notes   = s((string) ($_POST['agent_notes'] ?? ''), 3000);
$client_notes  = s((string) ($_POST['client_notes'] ?? ''), 1500);

$rec_package   = s((string) ($_POST['recommended_package'] ?? ''), 60);
$rec_price     = (float) ($_POST['recommended_price'] ?? 0);
$final_price   = (float) ($_POST['final_price'] ?? 0);
$payment_plan  = s((string) ($_POST['payment_plan'] ?? 'half'), 20);
$override_reason = s((string) ($_POST['override_reason'] ?? ''), 60);

// Validate
if (!isset($AGENTS[$agent_id])) $errors['agent_name'] = 'Please select an agent.';
if (mb_strlen($client_name) < 2) $errors['client_name'] = 'Client name is required.';
if (!valid_email($client_email)) $errors['client_email'] = 'A valid email address is required.';
if (strlen(preg_replace('/\D+/', '', $client_phone) ?? '') < 7) $errors['client_phone'] = 'A valid phone number is required.';
if (!$services['web'] && !$services['android'] && !$services['ios'] && !$services['pentest']) {
    $errors['services'] = 'At least one service must be selected.';
}
if ($final_price <= 0) $errors['final_price'] = 'Final price must be greater than zero.';
if (!in_array($payment_plan, ['upfront', 'half', 'thirds'], true)) $payment_plan = 'half';

if (!empty($errors)) jerr('Please correct the highlighted fields.', $errors, 422);

$agent = $AGENTS[$agent_id];

// ──────────────────────────────────────────────────────────────────────────
//  Compute first installment
// ──────────────────────────────────────────────────────────────────────────
$planSplit = [
    'upfront' => ['label' => 'Full Upfront', 'pct' => [100], 'discount' => 0.08],
    'half'    => ['label' => 'Fifty / Fifty', 'pct' => [50, 50], 'discount' => 0.00],
    'thirds'  => ['label' => 'Three-Payment Split', 'pct' => [33, 33, 34], 'discount' => -0.02],
][$payment_plan];

$discountMult = 1 - $planSplit['discount'];
$effectivePrice = $final_price * $discountMult;
$firstPct = $planSplit['pct'][0];
$firstPayment = $effectivePrice * ($firstPct / 100);

// ──────────────────────────────────────────────────────────────────────────
//  Build email HTML
// ──────────────────────────────────────────────────────────────────────────
$reference = ref_code();
$submitted = date('Y-m-d H:i:s T');

$safe = fn(string $v): string => htmlspecialchars($v, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$money = fn(float $v): string => '$' . number_format($v, 0, '.', ',');

// Services list
$servicesList = array_keys(array_filter($services));
$servicesLabels = [
    'web' => 'Custom Web Development',
    'android' => 'Native Android App',
    'ios' => 'Native iOS App',
    'pentest' => 'Security Audit / Penetration Test',
];
$servicesNamed = array_map(fn($s) => $servicesLabels[$s], $servicesList);

// Package decode
$pkgParts = $rec_package ? explode(':', $rec_package) : [];
$pkgDisplay = count($pkgParts) === 2 ? strtoupper($pkgParts[0]) . ' · ' . ucfirst($pkgParts[1]) : '—';

$servicesChipsClient = implode('', array_map(
    fn($s) => '<div style="display:inline-block;margin:3px 5px 3px 0;padding:5px 10px;border-radius:4px;background:#1c2533;color:#f0883e;font-family:monospace;font-size:11px;">' . $safe($s) . '</div>',
    $servicesNamed
));

$overrideNotice = '';
if (abs($final_price - $rec_price) > 0.5) {
    $overrideNotice = '<div style="margin-top:12px;padding:10px 14px;background:#3d1a1a;border:1px solid #f85149;border-radius:6px;color:#f85149;font-size:12px;"><strong>Note:</strong> Final price adjusted from recommended ' . $money($rec_price) . ' at agent\'s discretion.</div>';
}

$clientHtml = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Your BVSec Quote</title></head>
<body style="margin:0;padding:0;background:#0d1117;font-family:-apple-system,'Segoe UI',Helvetica,Arial,sans-serif;color:#e6edf3;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;">
<tr><td align="center" style="padding:32px 16px;">
<table role="presentation" width="620" cellpadding="0" cellspacing="0" style="max-width:620px;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">

<tr><td style="padding:24px 28px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;">
    <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;text-transform:uppercase;">BVSEC // PROPOSAL</div>
    <div style="font-family:Georgia,serif;font-size:24px;font-weight:bold;color:#e6edf3;margin-top:8px;">Hi {$safe($client_name)},</div>
</td></tr>

<tr><td style="padding:28px;">
    <p style="margin:0 0 16px;color:#c9d1d9;font-size:14px;line-height:1.75;">
        Thank you for the opportunity to work with you. Based on our conversation, we've put together a tailored proposal that we believe matches your needs precisely.
    </p>

    <p style="margin:20px 0 10px;color:#e6edf3;font-size:13px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;">Services In Scope</p>
    <div>{$servicesChipsClient}</div>

    <div style="margin-top:24px;padding:16px 18px;background:#0d1117;border:1px solid #30363d;border-radius:6px;">
        <div style="font-family:'Courier New',monospace;font-size:10px;letter-spacing:2px;color:#8b949e;text-transform:uppercase;">TOTAL INVESTMENT</div>
        <div style="font-family:Georgia,serif;font-size:32px;font-weight:bold;color:#f0883e;margin-top:6px;">{$money($final_price)}</div>
        {$overrideNotice}
    </div>

    <div style="margin-top:20px;padding:16px 18px;background:#0d1117;border:1px solid #30363d;border-left:3px solid #f0883e;border-radius:6px;">
        <div style="font-family:'Courier New',monospace;font-size:10px;letter-spacing:2px;color:#8b949e;text-transform:uppercase;">PAYMENT PLAN — {$safe($planSplit['label'])}</div>
        <div style="font-size:13px;color:#c9d1d9;margin-top:6px;line-height:1.6;">
            <strong style="color:#e6edf3;">First Installment: <span style="color:#f0883e;font-family:monospace;">{$money($firstPayment)}</span></strong> ({$firstPct}% at kickoff)
        </div>
    </div>

    <p style="margin:24px 0 12px;color:#e6edf3;font-size:13px;font-weight:bold;letter-spacing:1px;text-transform:uppercase;">Next Steps</p>
    <ol style="margin:0 0 20px;padding-left:22px;color:#c9d1d9;font-size:13px;line-height:1.8;">
        <li>Review the proposal above.</li>
        <li>Reply to this email with any questions or adjustments.</li>
        <li>We'll send a Stripe invoice for the first installment.</li>
        <li>Once paid, we kick off — with the first deliverable within days.</li>
    </ol>

    {$safe($client_notes)}

    <p style="margin:24px 0 0;color:#8b949e;font-size:13px;line-height:1.7;font-style:italic;">
        — {$safe($agent['name'])}<br>
        <span style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:1px;">BVSEC // BEARDED VIKING SECURITY FORGE</span>
    </p>
</td></tr>

<tr><td style="padding:16px 28px;background:#0d1117;border-top:1px solid #30363d;text-align:center;font-family:'Courier New',monospace;font-size:10px;color:#6e7681;letter-spacing:1px;">
    REFERENCE: {$reference} &nbsp;&middot;&nbsp; QUESTIONS: info@beardedviking.org
</td></tr>

</table>
</td></tr>
</table>
</body>
</html>
HTML;

$clientText = "BVSEC — YOUR PROPOSAL\nReference: {$reference}\n"
    . str_repeat("=", 60) . "\n\n"
    . "Hi {$client_name},\n\n"
    . "Thank you for the opportunity to work with you. Here is the tailored proposal we've prepared:\n\n"
    . "SERVICES IN SCOPE:\n" . implode("\n", array_map(fn($s) => "  - {$s}", $servicesNamed)) . "\n\n"
    . "TOTAL INVESTMENT: " . $money($final_price) . "\n"
    . "PAYMENT PLAN: {$planSplit['label']}\n"
    . "FIRST INSTALLMENT: " . $money($firstPayment) . " ({$firstPct}% at kickoff)\n\n"
    . "NEXT STEPS:\n"
    . "  1. Review the proposal.\n"
    . "  2. Reply with questions or adjustments.\n"
    . "  3. We'll send a Stripe invoice for the first installment.\n"
    . "  4. Once paid, work begins.\n\n"
    . ($client_notes !== '' ? "{$client_notes}\n\n" : '')
    . "— {$agent['name']}\n"
    . "BVSEC // BEARDED VIKING SECURITY FORGE\n"
    . "Questions: info@beardedviking.org\n";

// ── Admin email
$adminSubject = "[BVSec Quote] {$client_name} — {$money($final_price)} — Agent: {$agent['name']}";

$adminRows = '';
$row = function (string $label, string $value) use (&$adminRows, $safe): void {
    if ($value === '') return;
    $adminRows .= '<tr><td style="padding:7px 12px;border-bottom:1px solid #30363d;color:#8b949e;font-size:12px;width:180px;vertical-align:top;font-family:monospace;">' . $safe($label) . '</td>'
        . '<td style="padding:7px 12px;border-bottom:1px solid #30363d;color:#e6edf3;font-size:13px;vertical-align:top;">' . $value . '</td></tr>';
};

$row('Reference',     $safe($reference));
$row('Agent',         $safe($agent['name'] . ' (' . $agent['role'] . ')'));
$row('Client',        $safe($client_name));
$row('Company',       $safe($client_co));
$row('Position',      $safe($client_pos));
$row('Email',         '<a href="mailto:' . $safe($client_email) . '" style="color:#58a6ff;">' . $safe($client_email) . '</a>');
$row('Phone',         '<a href="tel:' . $safe($client_phone) . '" style="color:#58a6ff;">' . $safe($client_phone) . '</a>');
$row('Location',      $safe($client_loc));
$row('Years in Biz',  $safe($client_years));

$row('Services',      $servicesChipsClient);
$row('Recommended',   $safe($pkgDisplay . ' — ' . $money($rec_price)));
$row('Final Price',   '<strong style="color:#f0883e;">' . $money($final_price) . '</strong>');
if (abs($final_price - $rec_price) > 0.5) {
    $row('Override', $safe($override_reason ?: 'unspecified'));
}
$row('Payment Plan',  $safe($planSplit['label']));
$row('First Payment', '<strong style="color:#f0883e;">' . $money($firstPayment) . '</strong>');

$row('Budget Type',   $safe($budget_type));
if ($budget_total > 0)   $row('Budget Total', $money($budget_total));
if ($budget_web > 0)     $row('Budget Web',   $money($budget_web));
if ($budget_android > 0) $row('Budget Android', $money($budget_android));
if ($budget_ios > 0)     $row('Budget iOS',   $money($budget_ios));

$row('Timeline Start',    $safe($timeline_start));
$row('Timeline Complete', $safe($timeline_complete));

if ($summary !== '')      $row('Client Summary', '<em style="color:#c9d1d9;">' . nl2br($safe($summary)) . '</em>');
if ($agent_notes !== '')  $row('Agent Notes', '<div style="background:#3d2e0a;border-left:3px solid #f0883e;padding:8px 12px;border-radius:4px;color:#ffd77a;">' . nl2br($safe($agent_notes)) . '</div>');

$adminHtml = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>New Quote</title></head>
<body style="margin:0;padding:0;background:#0d1117;font-family:-apple-system,sans-serif;color:#e6edf3;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;">
<tr><td align="center" style="padding:32px 16px;">
<table role="presentation" width="680" cellpadding="0" cellspacing="0" style="max-width:680px;background:#161b22;border:1px solid #30363d;border-radius:8px;overflow:hidden;">

<tr><td style="padding:20px 28px;background:linear-gradient(135deg,#0d1117,#1c2533);border-bottom:1px solid #30363d;">
    <table width="100%"><tr>
    <td>
        <div style="font-family:'Courier New',monospace;font-size:11px;letter-spacing:3px;color:#f0883e;">BVSEC // NEW QUOTE GENERATED</div>
        <div style="font-family:Georgia,serif;font-size:20px;font-weight:bold;margin-top:6px;">{$safe($client_name)}</div>
    </td>
    <td align="right">
        <div style="font-family:monospace;font-size:16px;font-weight:bold;color:#f0883e;">{$money($final_price)}</div>
        <div style="font-family:monospace;font-size:11px;color:#8b949e;margin-top:4px;">{$reference}</div>
    </td>
    </tr></table>
</td></tr>

<tr><td style="padding:24px 28px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">{$adminRows}</table>

    <div style="margin-top:24px;padding:14px 18px;background:#0d1117;border:1px solid #30363d;border-radius:6px;font-family:monospace;font-size:11px;color:#8b949e;line-height:1.7;">
        <div>SUBMITTED: {$safe($submitted)}</div>
        <div>IP: {$safe($ip)}</div>
    </div>

    <div style="margin-top:20px;">
        <a href="mailto:{$safe($client_email)}?subject=Re%3A%20BVSec%20Quote%20{$reference}" style="display:inline-block;padding:11px 20px;background:#f0883e;color:#0d1117;font-family:monospace;font-size:12px;font-weight:bold;letter-spacing:1px;text-decoration:none;border-radius:6px;text-transform:uppercase;">Reply to Client</a>
    </div>
</td></tr>

<tr><td style="padding:16px 28px;background:#0d1117;border-top:1px solid #30363d;text-align:center;font-family:monospace;font-size:10px;color:#6e7681;letter-spacing:1px;">
    BVSEC SALES // INTERNAL RECORD
</td></tr>

</table>
</td></tr>
</table>
</body>
</html>
HTML;

$adminText = "BVSEC — NEW QUOTE GENERATED\nReference: {$reference}\n"
    . str_repeat("=", 60) . "\n\n"
    . "Agent:         {$agent['name']} ({$agent['role']})\n"
    . "Client:        {$client_name}\n"
    . "Company:       {$client_co}\n"
    . "Position:      {$client_pos}\n"
    . "Email:         {$client_email}\n"
    . "Phone:         {$client_phone}\n"
    . "Location:      {$client_loc}\n\n"
    . "Services:      " . implode(', ', $servicesNamed) . "\n"
    . "Recommended:   {$pkgDisplay} — " . $money($rec_price) . "\n"
    . "Final Price:   " . $money($final_price) . "\n"
    . (abs($final_price - $rec_price) > 0.5 ? "Override:      " . ($override_reason ?: 'unspecified') . "\n" : '')
    . "Payment Plan:  {$planSplit['label']}\n"
    . "First Payment: " . $money($firstPayment) . " ({$firstPct}%)\n\n"
    . "Budget Type:   {$budget_type}\n"
    . ($budget_total > 0 ? "Budget Total:  " . $money($budget_total) . "\n" : '')
    . "Timeline:      Start {$timeline_start} / Complete {$timeline_complete}\n\n"
    . ($summary !== '' ? "CLIENT SUMMARY:\n{$summary}\n\n" : '')
    . ($agent_notes !== '' ? "AGENT NOTES:\n{$agent_notes}\n\n" : '')
    . "Submitted: {$submitted}\nIP: {$ip}\n";

// ──────────────────────────────────────────────────────────────────────────
//  Send
// ──────────────────────────────────────────────────────────────────────────
$clientSubject = "Your BVSec Proposal — {$money($final_price)} — {$reference}";
$clientSent = send_email($client_email, $clientSubject, $clientHtml, $clientText, BVSEC_ADMIN_EMAIL);
$adminSent  = send_email(BVSEC_ADMIN_EMAIL, $adminSubject, $adminHtml, $adminText, $client_email);

if (!$clientSent) error_log("[BVSec quote] client email failed for {$reference}");
if (!$adminSent)  error_log("[BVSec quote] admin email failed for {$reference}");

// ──────────────────────────────────────────────────────────────────────────
//  Log
// ──────────────────────────────────────────────────────────────────────────
if (!is_dir(BVSEC_LOG_DIR)) @mkdir(BVSEC_LOG_DIR, 0750, true);
$logLine = sprintf(
    "[%s] ref=%s agent=%s client=%s email=%s rec=%s final=%s plan=%s first=%s ip=%s\n",
    date('c'),
    $reference,
    $agent_id,
    $client_name,
    $client_email,
    (string) $rec_price,
    (string) $final_price,
    $payment_plan,
    (string) $firstPayment,
    $ip
);
@file_put_contents(BVSEC_LOG_DIR . '/sales-quotes.log', $logLine, FILE_APPEND | LOCK_EX);

// JSON export for later Stripe integration
$stripeJson = [
    'reference'       => $reference,
    'agent_id'        => $agent_id,
    'agent_name'      => $agent['name'],
    'client'          => [
        'name'    => $client_name,
        'company' => $client_co,
        'email'   => $client_email,
        'phone'   => $client_phone,
    ],
    'services'        => $servicesList,
    'recommended'     => ['package' => $rec_package, 'price' => $rec_price],
    'final_price'     => $final_price,
    'payment_plan'    => $payment_plan,
    'first_payment'   => $firstPayment,
    'plan_split'      => $planSplit,
    'submitted_at'    => $submitted,
];
@file_put_contents(
    BVSEC_LOG_DIR . '/quotes/' . $reference . '.json',
    json_encode($stripeJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
    LOCK_EX
);

// ──────────────────────────────────────────────────────────────────────────
//  Respond
// ──────────────────────────────────────────────────────────────────────────
jout([
    'success'       => true,
    'reference'     => $reference,
    'client_email'  => $client_email,
    'final_price'   => $final_price,
    'first_payment' => $firstPayment,
    'plan'          => $planSplit['label'],
    'client_sent'   => $clientSent,
    'admin_sent'    => $adminSent,
    'submitted_at'  => $submitted,
]);