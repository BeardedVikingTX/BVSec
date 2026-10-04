<?php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 *  BVSec — Global Footer
 *  Bearded Viking Security Forge
 * ═══════════════════════════════════════════════════════════════════════════
 *
 *  @file      includes/footer.php
 *  @package   BVSec
 *  @author    BeardedVikingTX
 *  @copyright 2026 BeardedVikingTX / BVSec. All Rights Reserved.
 *  @license   Proprietary — Source Available. See LICENSE.md.
 *
 *  PURPOSE:
 *    Global closing block with live server telemetry, terminal widget,
 *    navigation sitemap, and back-to-top control.
 *
 *  SAFETY NOTE:
 *    All server values are sanitized. Paths, usernames, and env vars are
 *    intentionally excluded. Only non-sensitive operational metrics are shown.
 * ═══════════════════════════════════════════════════════════════════════════
 */

declare(strict_types=1);

// Defensive: ensure nonce is available if footer is loaded without header.
$csp_nonce = $GLOBALS['csp_nonce'] ?? '';

// ──────────────────────────────────────────────────────────────────────────
//  HELPERS — formatting + safe telemetry gathering
// ──────────────────────────────────────────────────────────────────────────

if (!function_exists('bv_format_bytes')) {
    /**
     * Convert a byte count to a human-readable string.
     */
    function bv_format_bytes(int|float $bytes, int $precision = 1): string
    {
        if ($bytes <= 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('bv_format_uptime')) {
    /**
     * Convert seconds to a compact human-readable uptime string.
     */
    function bv_format_uptime(int $seconds): string
    {
        if ($seconds <= 0) return '—';
        $days  = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $mins  = intdiv($seconds % 3600, 60);
        if ($days > 0)  return "{$days}d {$hours}h {$mins}m";
        if ($hours > 0) return "{$hours}h {$mins}m";
        return "{$mins}m";
    }
}

if (!function_exists('bv_gather_server_stats')) {
    /**
     * Collect non-sensitive operational telemetry.
     * Returns a normalized array — every key guaranteed to exist.
     */
    function bv_gather_server_stats(): array
    {
        $stats = [
            'php_version'    => PHP_VERSION,
            'server_software'=> 'Unknown',
            'os'             => 'Unknown',
            'arch'           => 'Unknown',
            'hostname'       => 'fortress',
            'load_1'         => null,
            'load_5'         => null,
            'load_15'        => null,
            'cpu_cores'      => null,
            'mem_used'       => 0,
            'mem_limit'      => '—',
            'uptime_sec'     => null,
            'disk_free'      => null,
            'disk_total'     => null,
            'response_ms'    => 0.0,
            'utc_time'       => gmdate('H:i:s'),
            'utc_date'       => gmdate('Y-m-d'),
            'sapi'           => PHP_SAPI,
        ];

        // Server software banner — strip version suffix to avoid fingerprinting.
        $sw = $_SERVER['SERVER_SOFTWARE'] ?? '';
        if ($sw !== '') {
            // Keep the software name, drop the version numbers.
            $stats['server_software'] = preg_replace('/[\/\s][\d.]+.*$/', '', $sw) ?: 'Web';
        }

        // OS + arch — use php_uname() where available.
        if (function_exists('php_uname')) {
            $stats['os']   = trim(php_uname('s') . ' ' . php_uname('r'));
            $stats['arch'] = php_uname('m') ?: '—';
        }

        // Hostname — trimmed, and only the leaf label.
        if (function_exists('gethostname')) {
            $host = gethostname();
            if ($host !== false && $host !== '') {
                $parts = explode('.', $host);
                $stats['hostname'] = strtolower($parts[0] ?: 'fortress');
            }
        }

        // CPU load averages (Linux only; safe fail elsewhere).
        if (function_exists('sys_getloadavg')) {
            $load = @sys_getloadavg();
            if (is_array($load) && count($load) === 3) {
                $stats['load_1']  = round($load[0], 2);
                $stats['load_5']  = round($load[1], 2);
                $stats['load_15'] = round($load[2], 2);
            }
        }

        // CPU core count — try common paths, fall back to null.
        if (is_readable('/proc/cpuinfo')) {
            $cpuinfo = @file_get_contents('/proc/cpuinfo');
            if ($cpuinfo !== false) {
                $count = substr_count($cpuinfo, 'processor');
                if ($count > 0) $stats['cpu_cores'] = $count;
            }
        }
        if ($stats['cpu_cores'] === null && function_exists('shell_exec')) {
            // Disabled in many hosts; silent failure is expected.
            $n = @shell_exec('nproc 2>/dev/null');
            if (is_string($n) && is_numeric(trim($n))) {
                $stats['cpu_cores'] = (int) trim($n);
            }
        }

        // Memory — current page's peak, and configured limit.
        $stats['mem_used'] = memory_get_peak_usage(true);
        $lim = ini_get('memory_limit');
        $stats['mem_limit'] = ($lim !== false && $lim !== '') ? $lim : '—';

        // Uptime — read /proc/uptime on Linux.
        if (is_readable('/proc/uptime')) {
            $u = @file_get_contents('/proc/uptime');
            if ($u !== false) {
                $chunks = explode(' ', trim($u));
                if (isset($chunks[0]) && is_numeric($chunks[0])) {
                    $stats['uptime_sec'] = (int) $chunks[0];
                }
            }
        }

        // Disk — free/total on the webroot partition.
        $df = @disk_free_space(__DIR__);
        $dt = @disk_total_space(__DIR__);
        if ($df !== false && $dt !== false && $dt > 0) {
            $stats['disk_free']  = (int) $df;
            $stats['disk_total'] = (int) $dt;
        }

        // Response time — from REQUEST_TIME_FLOAT (or request start).
        $start = $_SERVER['REQUEST_TIME_FLOAT'] ?? null;
        if (is_numeric($start)) {
            $stats['response_ms'] = round((microtime(true) - (float) $start) * 1000, 2);
        }

        return $stats;
    }
}

$stats = bv_gather_server_stats();

// Compute load percentage (relative to core count) for the gauge bar.
$load_pct = null;
if ($stats['load_1'] !== null && $stats['cpu_cores']) {
    $load_pct = min(100, round(($stats['load_1'] / $stats['cpu_cores']) * 100, 1));
}

// Disk usage percentage.
$disk_pct = null;
if ($stats['disk_free'] !== null && $stats['disk_total']) {
    $used = $stats['disk_total'] - $stats['disk_free'];
    $disk_pct = round(($used / $stats['disk_total']) * 100, 1);
}

// Shortcut for escaped output.
$e = static fn(string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
?>

<!-- ═══════════════════════════════════════════════════════════════════════
     GLOBAL FOOTER
     ═══════════════════════════════════════════════════════════════════════ -->
<footer class="bv-footer" role="contentinfo">

    <!-- ─── Runic divider ────────────────────────────────────────────── -->
    <div class="bv-footer__rune-divider" aria-hidden="true">
        <span class="bv-footer__rune-line"></span>
        <span class="bv-footer__rune">ᛒ</span>
        <span class="bv-footer__rune">ᚹ</span>
        <span class="bv-footer__rune">ᛊ</span>
        <span class="bv-footer__rune">ᛖ</span>
        <span class="bv-footer__rune">ᚲ</span>
        <span class="bv-footer__rune-line"></span>
    </div>

    <div class="bv-footer__main">
        <div class="bv-footer__inner">

            <!-- ─── Brand column ──────────────────────────────────────── -->
            <div class="bv-footer__col bv-footer__col--brand">
                <a href="/" class="bv-footer__brand" aria-label="BVSec — Home">
                    <span class="bv-footer__brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 40 40" width="36" height="36" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="bvFooterLogoGrad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                                    <stop offset="0%" stop-color="var(--bv-color-accent)"/>
                                    <stop offset="100%" stop-color="var(--bv-color-accent-warm)"/>
                                </linearGradient>
                            </defs>
                            <path d="M20 2 L34 8 L34 20 C34 28 27 35 20 38 C13 35 6 28 6 20 L6 8 Z"
                                  stroke="url(#bvFooterLogoGrad)" stroke-width="2" fill="none"/>
                            <path d="M14 14 L14 26 M14 14 L20 14 C22 14 23 15 23 17 C23 18.5 22 19.5 20 19.5 L14 19.5 M14 19.5 L20 19.5 C22.5 19.5 24 20.5 24 23 C24 25 22.5 26 20 26 L14 26"
                                  stroke="url(#bvFooterLogoGrad)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="bv-footer__brand-text">BVSEC</span>
                </a>

                <p class="bv-footer__tagline">
                    Bug bounty hunting. Security-hardened development.
                    Privacy-first engineering. Building fortresses in the digital wastes.
                </p>

                <div class="bv-footer__status">
                    <span class="bv-footer__status-pill" role="status" aria-label="All systems operational">
                        <span class="bv-footer__status-dot" aria-hidden="true"></span>
                        ALL SYSTEMS OPERATIONAL
                    </span>
                </div>

                <div class="bv-footer__brand-meta">
                    <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> TEXAS, USA</span>
                    <span class="bv-footer__meta-divider" aria-hidden="true">᛫</span>
                    <span><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> OSCP · CEH</span>
                </div>
            </div>

            <!-- ─── Navigate ──────────────────────────────────────────── -->
            <nav class="bv-footer__col" aria-labelledby="bv-footer-nav-title">
                <h3 class="bv-footer__col-title" id="bv-footer-nav-title">
                    <span class="bv-footer__col-title-num" aria-hidden="true">01</span>
                    Navigate
                </h3>
                <ul class="bv-footer__list" role="list">
                    <li><a href="/"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Home</a></li>
                    <li><a href="/about.php"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> About</a></li>
                    <li><a href="/services.php"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Services</a></li>
                    <li><a href="/portfolio.php"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Portfolio</a></li>
                    <li><a href="/contact.php"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Contact</a></li>
                </ul>
            </nav>

            <!-- ─── Services ──────────────────────────────────────────── -->
            <nav class="bv-footer__col" aria-labelledby="bv-footer-services-title">
                <h3 class="bv-footer__col-title" id="bv-footer-services-title">
                    <span class="bv-footer__col-title-num" aria-hidden="true">02</span>
                    Services
                </h3>
                <ul class="bv-footer__list" role="list">
                    <li><a href="/services/bug-bounty.php"><i class="fa-solid fa-bug" aria-hidden="true"></i> Bug Bounty</a></li>
                    <li><a href="/services/web-development.php"><i class="fa-solid fa-code" aria-hidden="true"></i> Web Development</a></li>
                    <li><a href="/services/mobile-development.php"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i> Mobile Apps</a></li>
                    <li><a href="/services/in-house/php"><i class="fa-solid fa-hammer" aria-hidden="true"></i> In-House Projects</a></li>
                    <li>
                        <a href="https://mycitadel.lol" target="_blank" rel="noopener noreferrer">
                            <i class="fa-solid fa-chess-rook" aria-hidden="true"></i>
                            MyCitadel
                            <i class="fa-solid fa-arrow-up-right-from-square bv-footer__ext" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- ─── Server Vault ──────────────────────────────────────── -->
            <div class="bv-footer__col bv-footer__col--vault" aria-labelledby="bv-footer-vault-title">
                <h3 class="bv-footer__col-title" id="bv-footer-vault-title">
                    <span class="bv-footer__col-title-num" aria-hidden="true">03</span>
                    Server Vault
                </h3>

                <dl class="bv-footer__stats">

                    <div class="bv-footer__stat">
                        <dt><i class="fa-solid fa-server" aria-hidden="true"></i> Platform</dt>
                        <dd><?= $e($stats['os']) ?></dd>
                    </div>

                    <div class="bv-footer__stat">
                        <dt><i class="fa-brands fa-php" aria-hidden="true"></i> Runtime</dt>
                        <dd>PHP <?= $e($stats['php_version']) ?></dd>
                    </div>

                    <div class="bv-footer__stat">
                        <dt><i class="fa-solid fa-microchip" aria-hidden="true"></i> Cores</dt>
                        <dd><?= $stats['cpu_cores'] !== null ? $e((string)$stats['cpu_cores']) : '—' ?></dd>
                    </div>

                    <?php if ($stats['load_1'] !== null): ?>
                    <div class="bv-footer__stat bv-footer__stat--gauge">
                        <dt><i class="fa-solid fa-gauge-high" aria-hidden="true"></i> Load</dt>
                        <dd>
                            <span class="bv-footer__gauge" role="img" aria-label="Load average <?= $e((string)$stats['load_1']) ?>">
                                <span class="bv-footer__gauge-bar" style="--bv-fill: <?= $e((string)$load_pct) ?>%"></span>
                            </span>
                            <span class="bv-footer__gauge-value"><?= $e((string)$stats['load_1']) ?> / <?= $e((string)$stats['load_5']) ?> / <?= $e((string)$stats['load_15']) ?></span>
                        </dd>
                    </div>
                    <?php endif; ?>

                    <?php if ($stats['uptime_sec'] !== null): ?>
                    <div class="bv-footer__stat">
                        <dt><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i> Uptime</dt>
                        <dd><?= $e(bv_format_uptime($stats['uptime_sec'])) ?></dd>
                    </div>
                    <?php endif; ?>

                    <?php if ($disk_pct !== null): ?>
                    <div class="bv-footer__stat bv-footer__stat--gauge">
                        <dt><i class="fa-solid fa-hard-drive" aria-hidden="true"></i> Disk</dt>
                        <dd>
                            <span class="bv-footer__gauge" role="img" aria-label="Disk usage <?= $e((string)$disk_pct) ?>%">
                                <span class="bv-footer__gauge-bar" style="--bv-fill: <?= $e((string)$disk_pct) ?>%"></span>
                            </span>
                            <span class="bv-footer__gauge-value"><?= $e(bv_format_bytes($stats['disk_free'])) ?> free</span>
                        </dd>
                    </div>
                    <?php endif; ?>

                    <div class="bv-footer__stat">
                        <dt><i class="fa-solid fa-bolt" aria-hidden="true"></i> Response</dt>
                        <dd><span class="bv-footer__response"><?= $e((string)$stats['response_ms']) ?> ms</span></dd>
                    </div>

                    <div class="bv-footer__stat">
                        <dt><i class="fa-solid fa-satellite-dish" aria-hidden="true"></i> UTC</dt>
                        <dd>
                            <span data-bv-utc-date><?= $e($stats['utc_date']) ?></span>
                            <span class="bv-footer__meta-divider" aria-hidden="true">᛫</span>
                            <span data-bv-utc-time class="bv-footer__utc"><?= $e($stats['utc_time']) ?></span>
                        </dd>
                    </div>

                </dl>
            </div>

        </div>

        <!-- ─── Terminal widget ──────────────────────────────────────────── -->
        <div class="bv-footer__terminal" id="bv-footer-terminal" data-terminal>
            <div class="bv-footer__terminal-bar">
                <span class="bv-footer__terminal-dot bv-footer__terminal-dot--red"    aria-hidden="true"></span>
                <span class="bv-footer__terminal-dot bv-footer__terminal-dot--yellow" aria-hidden="true"></span>
                <span class="bv-footer__terminal-dot bv-footer__terminal-dot--green"  aria-hidden="true"></span>
                <span class="bv-footer__terminal-title">
                    bvsec@<?= $e($stats['hostname']) ?>:~$ system_info --verbose
                </span>
                <span class="bv-footer__terminal-tag" aria-hidden="true">[LIVE]</span>
            </div>

            <div class="bv-footer__terminal-body" role="log" aria-live="polite" aria-atomic="false">
                <div class="bv-footer__terminal-line" data-line="0">
                    <span class="bv-prompt">bvsec@<?= $e($stats['hostname']) ?>:~$</span>
                    <span class="bv-cmd">./fortress --status --verbose</span>
                </div>
                <div class="bv-footer__terminal-line" data-line="1">
                    <span class="bv-out-ok">[ OK ]</span> Boot sequence complete. Fortress online.
                </div>
                <div class="bv-footer__terminal-line" data-line="2">
                    <span class="bv-out-ok">[ OK ]</span> Kernel: <span class="bv-out-val"><?= $e($stats['os']) ?></span> · arch <span class="bv-out-val"><?= $e($stats['arch']) ?></span>
                </div>
                <div class="bv-footer__terminal-line" data-line="3">
                    <span class="bv-out-ok">[ OK ]</span> Runtime: <span class="bv-out-val">PHP <?= $e($stats['php_version']) ?></span> · SAPI <span class="bv-out-val"><?= $e($stats['sapi']) ?></span>
                </div>
                <div class="bv-footer__terminal-line" data-line="4">
                    <span class="bv-out-ok">[ OK ]</span> Web: <span class="bv-out-val"><?= $e($stats['server_software']) ?></span>
                </div>
                <?php if ($stats['load_1'] !== null): ?>
                <div class="bv-footer__terminal-line" data-line="5">
                    <span class="bv-out-info">[INFO]</span> Load avg: <span class="bv-out-val"><?= $e((string)$stats['load_1']) ?> / <?= $e((string)$stats['load_5']) ?> / <?= $e((string)$stats['load_15']) ?></span>
                    <?php if ($load_pct !== null): ?>
                        (<span class="bv-out-val"><?= $e((string)$load_pct) ?>%</span>)
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if ($stats['uptime_sec'] !== null): ?>
                <div class="bv-footer__terminal-line" data-line="6">
                    <span class="bv-out-info">[INFO]</span> Uptime: <span class="bv-out-val"><?= $e(bv_format_uptime($stats['uptime_sec'])) ?></span>
                </div>
                <?php endif; ?>
                <div class="bv-footer__terminal-line" data-line="7">
                    <span class="bv-out-info">[INFO]</span> Response: <span class="bv-out-val"><?= $e((string)$stats['response_ms']) ?> ms</span>
                </div>
                <div class="bv-footer__terminal-line" data-line="8">
                    <span class="bv-out-warn">[WARN]</span> Bug bounty intake: <span class="bv-out-val">OPEN</span>
                </div>
                <div class="bv-footer__terminal-line" data-line="9">
                    <span class="bv-out-ok">[ OK ]</span> Awaiting operator input.
                    <span class="bv-cursor" aria-hidden="true">▊</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ─── Bottom bar ──────────────────────────────────────────────────── -->
    <div class="bv-footer__bottom">
        <div class="bv-footer__bottom-inner">

            <p class="bv-footer__copyright">
                <span class="bv-footer__copyright-mark" aria-hidden="true">©</span>
                <span>2026 <strong>BeardedVikingTX</strong> / BVSec / Bearded Viking Security Forge.</span>
                <span class="bv-footer__copyright-tag">All Rights Reserved.</span>
            </p>

            <div class="bv-footer__legal">
                <a href="/LICENSE.md" class="bv-footer__legal-link">
                    <i class="fa-solid fa-scroll" aria-hidden="true"></i> LICENSE
                </a>
                <span class="bv-footer__meta-divider" aria-hidden="true">᛫</span>
                <a href="/SECURITY.md" class="bv-footer__legal-link">
                    <i class="fa-solid fa-shield" aria-hidden="true"></i> SECURITY
                </a>
                <span class="bv-footer__meta-divider" aria-hidden="true">᛫</span>
                <a href="https://github.com/BeardedVikingTX" target="_blank" rel="noopener noreferrer" class="bv-footer__legal-link">
                    <i class="fa-brands fa-github" aria-hidden="true"></i> GITHUB
                </a>
            </div>

            <div class="bv-footer__signature">
                <i class="fa-solid fa-hammer" aria-hidden="true"></i>
                <span>FORGED WITH</span>
                <span class="bv-footer__signature-stack">PHP · TAILWIND · COFFEE</span>
            </div>

        </div>
    </div>

</footer>

<!-- ═══ BACK TO TOP ═══ -->
<button
    type="button"
    class="bv-back-to-top"
    id="bv-back-to-top"
    aria-label="Back to top"
    data-back-to-top
>
    <span class="bv-back-to-top__ring" aria-hidden="true"></span>
    <span class="bv-back-to-top__arrow" aria-hidden="true">
        <i class="fa-solid fa-chevron-up"></i>
    </span>
    <span class="bv-back-to-top__label" aria-hidden="true">TOP</span>
</button>

<?php
// Cleanup — release locals that aren't needed past this point.
unset($stats, $load_pct, $disk_pct);