<?php
/**
 * ONE-TIME ADMIN SETUP — delete after use
 */

$root = dirname(__DIR__);

// Read .env
$env = [];
foreach (file($root . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) continue;
    if (preg_match('/^database\.default\.(\w+)\s*=\s*(.+)/', $line, $m))
        $env[$m[1]] = trim($m[2]);
}

try {
    $pdo = new PDO(
        "mysql:host={$env['hostname']};dbname={$env['database']};charset=utf8mb4",
        $env['username'],
        $env['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('DB connection failed: ' . $e->getMessage());
}

$email    = 'admin@smokey.com';
$username = 'admin';
$password = 'Admin@123';
$now      = date('Y-m-d H:i:s');

// Check if already exists
$exists = $pdo->prepare("SELECT id FROM auth_identities WHERE secret = ? AND type = 'email_password'");
$exists->execute([$email]);
if ($exists->fetchColumn()) {
    echo '<div style="font-family:sans-serif;max-width:500px;margin:80px auto;padding:2rem;border:2px solid orange;border-radius:8px;">
    <h2 style="color:orange;">⚠ Admin already exists</h2>
    <p><strong>Login URL:</strong> <a href="/public/login">https://smokey.osob.in/public/login</a></p>
    <p><strong>Email:</strong> ' . $email . '</p>
    <p><strong>Password:</strong> ' . $password . '</p>
    <p style="color:red;margin-top:1rem;">Delete this file from File Manager now!</p>
    </div>';
    exit;
}

// Insert user
$pdo->prepare("INSERT INTO users (username, active, created_at, updated_at) VALUES (?, 1, ?, ?)")
    ->execute([$username, $now, $now]);
$userId = $pdo->lastInsertId();

// Insert email+password identity (bcrypt hash)
$hash = password_hash($password, PASSWORD_BCRYPT);
$pdo->prepare("INSERT INTO auth_identities (user_id, type, secret, secret2, created_at, updated_at) VALUES (?, 'email_password', ?, ?, ?, ?)")
    ->execute([$userId, $email, $hash, $now, $now]);

// Assign super_admin group
$pdo->prepare("INSERT INTO auth_groups_users (user_id, `group`, created_at) VALUES (?, 'super_admin', ?)")
    ->execute([$userId, $now]);

// Set display name
$pdo->prepare("UPDATE users SET display_name = 'Admin' WHERE id = ?")
    ->execute([$userId]);

echo '<!DOCTYPE html><html><body style="font-family:sans-serif;max-width:500px;margin:80px auto;padding:2rem;border:2px solid #4caf50;border-radius:8px;">
<h2 style="color:#4caf50;">✓ Admin Created Successfully!</h2>
<table style="width:100%;margin-top:1rem;border-collapse:collapse;">
<tr><td style="padding:8px;font-weight:bold;">Login URL</td><td style="padding:8px;"><a href="https://smokey.osob.in/public/login">https://smokey.osob.in/public/login</a></td></tr>
<tr style="background:#f9f9f9;"><td style="padding:8px;font-weight:bold;">Email</td><td style="padding:8px;">' . $email . '</td></tr>
<tr><td style="padding:8px;font-weight:bold;">Password</td><td style="padding:8px;">' . $password . '</td></tr>
</table>
<p style="color:red;font-weight:bold;margin-top:1.5rem;">⚠ DELETE public/setup.php from File Manager immediately!</p>
</body></html>';
