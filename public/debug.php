<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$root = dirname(__DIR__);

echo '<!DOCTYPE html><html><head><style>
*{box-sizing:border-box;margin:0;padding:0;}
body{background:#0d0d0d;color:#e0e0e0;font-family:monospace;font-size:13px;padding:20px;}
h2{color:#ffd966;margin:24px 0 8px;border-bottom:1px solid #333;padding-bottom:6px;}
.ok{color:#4caf50;font-weight:bold;}
.fail{color:#f44336;font-weight:bold;}
.warn{color:#ff9800;font-weight:bold;}
.box{background:#1a1a1a;border:1px solid #333;border-radius:6px;padding:14px;margin:8px 0;overflow-x:auto;white-space:pre-wrap;word-break:break-all;max-height:400px;overflow-y:auto;}
table{width:100%;border-collapse:collapse;margin:8px 0;}
th{background:#222;color:#ffd966;text-align:left;padding:8px 12px;font-size:12px;}
td{padding:7px 12px;border-bottom:1px solid #222;vertical-align:top;}
</style></head><body>';

echo '<h1 style="color:#ffd966;margin-bottom:4px;">🔍 Smokey — Deep Debug</h1>';
echo '<p style="color:#666;margin-bottom:20px;">Generated: ' . date('Y-m-d H:i:s') . ' | PHP ' . PHP_VERSION . ' (' . php_sapi_name() . ')</p>';

// ═══════════════════════════════════════════════════════
// 1. EXACT FILE TREE — vendor/codeigniter4
// ═══════════════════════════════════════════════════════
echo '<h2>1. vendor/codeigniter4/ tree</h2>';
$ci4 = $root . '/vendor/codeigniter4';
if (!is_dir($ci4)) {
    echo '<p class="fail">✗ vendor/codeigniter4/ does not exist at all!</p>';
} else {
    function listDir($dir, $depth = 0, $maxDepth = 3) {
        if ($depth > $maxDepth) return '';
        $out = '';
        foreach (scandir($dir) as $f) {
            if ($f === '.' || $f === '..') continue;
            $path = $dir . '/' . $f;
            $indent = str_repeat('  ', $depth);
            if (is_dir($path)) {
                $count = count(array_diff(scandir($path), ['.','..']));
                $out .= $indent . '📁 ' . $f . '/ (' . $count . " items)\n";
                if ($depth < $maxDepth) $out .= listDir($path, $depth + 1, $maxDepth);
            } else {
                $out .= $indent . '📄 ' . $f . ' (' . number_format(filesize($path)) . " bytes)\n";
            }
        }
        return $out;
    }
    echo '<div class="box">' . htmlspecialchars(listDir($ci4, 0, 2)) . '</div>';
}

// ═══════════════════════════════════════════════════════
// 2. KEY FILE CHECK
// ═══════════════════════════════════════════════════════
echo '<h2>2. Key Files</h2><table>';
echo '<tr><th>File</th><th>Exists</th><th>Size</th></tr>';
$files = [
    $root . '/vendor/autoload.php',
    $root . '/vendor/codeigniter4/framework/system/Boot.php',
    $root . '/vendor/codeigniter4/framework/system/CodeIgniter.php',
    $root . '/vendor/codeigniter4/shield/src/Auth.php',
    $root . '/app/Config/Paths.php',
    $root . '/app/Config/Database.php',
    $root . '/.env',
    __DIR__ . '/index.php',
    __DIR__ . '/.htaccess',
    $root . '/.htaccess',
];
foreach ($files as $f) {
    $e = file_exists($f);
    $sz = $e ? number_format(filesize($f)) . ' B' : '—';
    $short = str_replace($root . '/', '', $f);
    echo '<tr><td>' . $short . '</td><td>' . ($e ? '<span class="ok">✓</span>' : '<span class="fail">✗ MISSING</span>') . '</td><td>' . $sz . '</td></tr>';
}
echo '</table>';

// ═══════════════════════════════════════════════════════
// 3. PATHS CONFIG
// ═══════════════════════════════════════════════════════
echo '<h2>3. Paths Config</h2>';
if (file_exists($root . '/app/Config/Paths.php')) {
    require_once $root . '/app/Config/Paths.php';
    $p = new Config\Paths();
    $sysDir = $p->systemDirectory;
    echo '<table>';
    echo '<tr><th>Setting</th><th>Resolved Path</th><th>Exists?</th></tr>';
    foreach ([
        'systemDirectory'   => $sysDir,
        'appDirectory'      => $p->appDirectory,
        'writableDirectory' => $p->writableDirectory,
    ] as $k => $v) {
        $real = realpath($v) ?: $v;
        $e = file_exists($v);
        echo '<tr><td>' . $k . '</td><td>' . htmlspecialchars($real) . '</td><td>' . ($e ? '<span class="ok">✓</span>' : '<span class="fail">✗ MISSING</span>') . '</td></tr>';
    }
    echo '</table>';

    $bootFile = $sysDir . '/Boot.php';
    echo '<p style="margin-top:10px;">Boot.php at resolved path: ' . ($bootFile) . ' — ' . (file_exists($bootFile) ? '<span class="ok">✓ EXISTS</span>' : '<span class="fail">✗ DOES NOT EXIST</span>') . '</p>';
} else {
    echo '<p class="fail">Cannot check — Paths.php missing</p>';
}

// ═══════════════════════════════════════════════════════
// 4. TRY BOOTING CI4 — CAPTURE EXACT ERROR
// ═══════════════════════════════════════════════════════
echo '<h2>4. CI4 Boot Attempt</h2>';
ob_start();
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
try {
    if (!file_exists($root . '/vendor/autoload.php')) throw new Exception('vendor/autoload.php missing');
    require_once $root . '/vendor/autoload.php';
    echo '<span class="ok">✓ autoload.php loaded</span>' . "\n";

    if (!isset($p)) {
        require_once $root . '/app/Config/Paths.php';
        $p = new Config\Paths();
    }
    echo '<span class="ok">✓ Paths loaded. systemDirectory = ' . htmlspecialchars($p->systemDirectory) . '</span>' . "\n";

    $bootPath = $p->systemDirectory . '/Boot.php';
    if (!file_exists($bootPath)) throw new Exception('Boot.php not found at: ' . $bootPath);
    echo '<span class="ok">✓ Boot.php found</span>' . "\n";

    // Don't actually boot — just confirm the chain works
    echo '<span class="ok">✓ All prerequisites found — CI4 should boot</span>' . "\n";

} catch (Throwable $e) {
    echo '<span class="fail">✗ ERROR: ' . htmlspecialchars($e->getMessage()) . '</span>' . "\n";
    echo '<span class="fail">  File: ' . htmlspecialchars($e->getFile()) . ' line ' . $e->getLine() . '</span>' . "\n";
    echo "\nStack trace:\n" . htmlspecialchars($e->getTraceAsString()) . "\n";
}
restore_error_handler();
$boot_out = ob_get_clean();
echo '<div class="box">' . $boot_out . '</div>';

// ═══════════════════════════════════════════════════════
// 5. DATABASE
// ═══════════════════════════════════════════════════════
echo '<h2>5. Database Connection</h2>';
$env = [];
if (file_exists($root . '/.env')) {
    foreach (file($root . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        if (preg_match('/^database\.default\.(\w+)\s*=\s*(.+)/', trim($line), $m))
            $env[$m[1]] = trim($m[2]);
    }
}
if (!empty($env['hostname'])) {
    try {
        $dsn = "mysql:host={$env['hostname']};dbname={$env['database']};charset=utf8mb4";
        $pdo = new PDO($dsn, $env['username'], $env['password'], [PDO::ATTR_TIMEOUT => 5, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo '<p class="ok">✓ Connected to ' . htmlspecialchars($env['database']) . ' — ' . count($tables) . ' tables</p>';
        echo '<div class="box">' . implode("\n", $tables) . '</div>';
    } catch (Throwable $e) {
        echo '<p class="fail">✗ ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
} else {
    echo '<p class="warn">Could not read DB config</p>';
}

// ═══════════════════════════════════════════════════════
// 6. WRITABLE PERMISSIONS
// ═══════════════════════════════════════════════════════
echo '<h2>6. Writable Permissions</h2><table><tr><th>Directory</th><th>Exists</th><th>Writable</th><th>Permissions</th></tr>';
foreach (['writable','writable/logs','writable/cache','writable/session','writable/uploads'] as $d) {
    $full = $root . '/' . $d;
    $e = is_dir($full);
    $w = $e && is_writable($full);
    $perms = $e ? substr(sprintf('%o', fileperms($full)), -4) : '—';
    echo '<tr><td>' . $d . '</td><td>' . ($e?'<span class="ok">✓</span>':'<span class="fail">✗</span>') . '</td><td>' . ($w?'<span class="ok">✓</span>':'<span class="fail">✗</span>') . '</td><td>' . $perms . '</td></tr>';
}
echo '</table>';

// ═══════════════════════════════════════════════════════
// 7. CI4 ERROR LOG
// ═══════════════════════════════════════════════════════
echo '<h2>7. CI4 Error Log (last 60 lines)</h2>';
$logDir = $root . '/writable/logs/';
$logs = glob($logDir . 'log-*.php');
if ($logs) {
    rsort($logs);
    $content = file_get_contents($logs[0]);
    $content = preg_replace('/<\?php[^?]*\?>/', '', $content);
    $lines = array_slice(array_filter(array_map('trim', explode("\n", $content))), -60);
    echo '<div class="box">' . htmlspecialchars(implode("\n", $lines)) . '</div>';
} else {
    echo '<p class="warn">No log files yet</p>';
}

// ═══════════════════════════════════════════════════════
// 8. PHP ERROR LOG
// ═══════════════════════════════════════════════════════
echo '<h2>8. PHP Error Log</h2>';
$phpLog = ini_get('error_log');
echo '<p>PHP error_log path: <code>' . htmlspecialchars($phpLog ?: 'not set') . '</code></p>';
if ($phpLog && file_exists($phpLog)) {
    $lines = array_slice(file($phpLog), -30);
    echo '<div class="box">' . htmlspecialchars(implode('', $lines)) . '</div>';
} else {
    // Try common Hostinger locations
    $candidates = [
        '/home/' . get_current_user() . '/logs/error.log',
        dirname($root) . '/logs/error.log',
        $root . '/error.log',
        __DIR__ . '/error.log',
    ];
    $found = false;
    foreach ($candidates as $c) {
        if (file_exists($c)) {
            $lines = array_slice(file($c), -30);
            echo '<p>Found at: <code>' . $c . '</code></p>';
            echo '<div class="box">' . htmlspecialchars(implode('', $lines)) . '</div>';
            $found = true; break;
        }
    }
    if (!$found) echo '<p class="warn">No PHP error log found. Errors may be in Hostinger\'s hPanel → Logs.</p>';
}

echo '<hr style="margin-top:30px;border-color:#333;"><p style="color:#555;margin-top:10px;">⚠ Delete debug.php after fixing.</p>';
echo '</body></html>';
