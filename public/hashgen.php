<?php
// Generates bcrypt hash and fixes admin password
// DELETE after use

$password = 'Admin@123';
$hash = password_hash($password, PASSWORD_BCRYPT);

$root = dirname(__DIR__);
$env = [];
foreach (file($root . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (str_starts_with(trim($line), '#')) continue;
    if (preg_match('/^database\.default\.(\w+)\s*=\s*(.+)/', trim($line), $m))
        $env[$m[1]] = trim($m[2]);
}

try {
    $pdo = new PDO(
        "mysql:host={$env['hostname']};dbname={$env['database']};charset=utf8mb4",
        $env['username'], $env['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Check if admin exists
    $stmt = $pdo->prepare("SELECT ai.id, u.id as uid FROM auth_identities ai JOIN users u ON u.id = ai.user_id WHERE ai.secret = ? AND ai.type = 'email_password'");
    $stmt->execute(['admin@smokey.com']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Update existing password
        $pdo->prepare("UPDATE auth_identities SET secret2 = ? WHERE id = ?")
            ->execute([$hash, $row['id']]);
        // Ensure user is active + super_admin
        $pdo->prepare("UPDATE users SET active = 1 WHERE id = ?")->execute([$row['uid']]);
        $groupExists = $pdo->prepare("SELECT id FROM auth_groups_users WHERE user_id = ? AND `group` = 'super_admin'")->execute([$row['uid']]);
        $msg = '✓ Password updated for existing admin';
    } else {
        // Create fresh admin
        $now = date('Y-m-d H:i:s');
        $pdo->prepare("INSERT INTO users (username,active,created_at,updated_at,display_name) VALUES ('admin',1,?,?,'Admin')")
            ->execute([$now,$now]);
        $uid = $pdo->lastInsertId();
        $pdo->prepare("INSERT INTO auth_identities (user_id,type,secret,secret2,created_at,updated_at) VALUES (?,'email_password','admin@smokey.com',?,?,?)")
            ->execute([$uid,$hash,$now,$now]);
        $pdo->prepare("INSERT INTO auth_groups_users (user_id,`group`,created_at) VALUES (?,'super_admin',?)")
            ->execute([$uid,$now]);
        $msg = '✓ Admin created fresh';
    }

    // Also create a test customer
    $custEmail = 'customer@smokey.com';
    $custCheck = $pdo->prepare("SELECT id FROM auth_identities WHERE secret = ? AND type = 'email_password'");
    $custCheck->execute([$custEmail]);
    if (!$custCheck->fetchColumn()) {
        $now = date('Y-m-d H:i:s');
        $custHash = password_hash('Customer@123', PASSWORD_BCRYPT);
        $pdo->prepare("INSERT INTO users (username,active,created_at,updated_at,display_name) VALUES ('customer',1,?,?,'Test Customer')")
            ->execute([$now,$now]);
        $cuid = $pdo->lastInsertId();
        $pdo->prepare("INSERT INTO auth_identities (user_id,type,secret,secret2,created_at,updated_at) VALUES (?,'email_password',?,?,?,?)")
            ->execute([$cuid,$custEmail,$custHash,$now,$now]);
    }

} catch (Exception $e) {
    die('<p style="color:red">DB Error: ' . $e->getMessage() . '</p>');
}

echo '<!DOCTYPE html><html><body style="font-family:sans-serif;max-width:540px;margin:60px auto;padding:2rem;border:2px solid green;border-radius:8px;">
<h2 style="color:green;">' . $msg . '</h2>
<h3>Admin Login</h3>
<table style="width:100%;border-collapse:collapse;margin-bottom:1.5rem;">
<tr><td style="padding:8px;font-weight:bold;">URL</td><td style="padding:8px;"><a href="https://smokey.osob.in/public/login">https://smokey.osob.in/public/login</a></td></tr>
<tr style="background:#f5f5f5;"><td style="padding:8px;font-weight:bold;">Email</td><td style="padding:8px;">admin@smokey.com</td></tr>
<tr><td style="padding:8px;font-weight:bold;">Password</td><td style="padding:8px;">Admin@123</td></tr>
</table>
<h3>Customer Login (for testing)</h3>
<table style="width:100%;border-collapse:collapse;">
<tr><td style="padding:8px;font-weight:bold;">Email</td><td style="padding:8px;">customer@smokey.com</td></tr>
<tr style="background:#f5f5f5;"><td style="padding:8px;font-weight:bold;">Password</td><td style="padding:8px;">Customer@123</td></tr>
</table>
<p style="color:red;font-weight:bold;margin-top:1.5rem;">⚠ DELETE hashgen.php from File Manager now!</p>
</body></html>';
