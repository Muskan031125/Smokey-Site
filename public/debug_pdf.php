<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>PHP: " . PHP_VERSION . "</h3>";

$root = dirname(__DIR__);

// Check autoload
echo "<b>autoload.php:</b> " . (file_exists($root.'/vendor/autoload.php') ? '<span style="color:green">EXISTS</span>' : '<span style="color:red">MISSING</span>') . "<br>";

// Check dompdf folders
$checks = [
    'vendor/dompdf/dompdf/src/Dompdf.php',
    'vendor/dompdf/php-font-lib/src/FontLib/Font.php',
    'vendor/dompdf/php-svg-lib/src/Svg/Document.php',
    'vendor/composer/autoload_psr4.php',
];
foreach ($checks as $f) {
    $exists = file_exists($root.'/'.$f);
    echo "<b>$f:</b> " . ($exists ? '<span style="color:green">EXISTS</span>' : '<span style="color:red">MISSING</span>') . "<br>";
}

// Try loading dompdf
echo "<br><b>Loading autoloader...</b><br>";
if (file_exists($root.'/vendor/autoload.php')) {
    require $root.'/vendor/autoload.php';
    echo class_exists('\Dompdf\Dompdf')
        ? '<span style="color:green">Dompdf class OK</span><br>'
        : '<span style="color:red">Dompdf class MISSING — folders uploaded but autoloader not updated</span><br>';
}

// Show last 50 lines of latest log
echo "<br><b>Last log entries:</b><pre style='background:#111;color:#0f0;padding:10px;font-size:11px;max-height:300px;overflow:auto'>";
$logs = glob($root.'/writable/logs/*.log');
if ($logs) {
    $lines = file(end($logs));
    echo htmlspecialchars(implode('', array_slice($lines, -50)));
} else {
    echo "No logs found";
}
echo "</pre>";
