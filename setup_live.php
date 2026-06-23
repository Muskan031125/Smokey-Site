<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Joharis — Live Server Setup</title>
<style>
  body { font-family: monospace; background: #111; color: #eee; padding: 30px; }
  h1   { color: #f0c040; border-bottom: 1px solid #444; padding-bottom: 10px; }
  h2   { color: #aaa; margin-top: 30px; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; }
  .ok  { color: #4ade80; }
  .skip{ color: #facc15; }
  .err { color: #f87171; }
  .info{ color: #60a5fa; }
  pre  { background: #1a1a1a; padding: 12px; border-left: 3px solid #f0c040; margin: 8px 0; font-size: 12px; }
  .summary { background: #064e3b; border: 1px solid #065f46; padding: 15px; margin-top: 20px; }
  .summary.fail { background: #7f1d1d; border-color: #991b1b; }
</style>
</head>
<body>
<h1>Joharis — Live Server DB Setup</h1>
<p class="info">Creating all tables and seeding default data...</p>

<?php

// ── Load DB config from .env ──────────────────────────────────────────────────
$envFile = __DIR__ . '/.env';
$dbHost = 'localhost'; $dbUser = 'root'; $dbPass = ''; $dbName = '';
if (file_exists($envFile)) {
    foreach (file($envFile) as $line) {
        $line = trim($line);
        if (str_starts_with($line, '#') || $line === '') continue;
        if (preg_match('/^database\.default\.hostname\s*=\s*(.+)$/', $line, $m)) $dbHost = trim($m[1]);
        if (preg_match('/^database\.default\.username\s*=\s*(.+)$/', $line, $m)) $dbUser = trim($m[1]);
        if (preg_match('/^database\.default\.password\s*=\s*(.+)$/', $line, $m)) $dbPass = trim($m[1]);
        if (preg_match('/^database\.default\.database\s*=\s*(.+)$/', $line, $m)) $dbName = trim($m[1]);
    }
}

echo "<pre class='info'>Connecting to: $dbUser@$dbHost / $dbName</pre>";

mysqli_report(MYSQLI_REPORT_OFF);
$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($db->connect_error) {
    echo "<pre class='err'>Connection failed: " . $db->connect_error . "</pre>";
    exit;
}
$db->set_charset('utf8mb4');
echo "<pre class='ok'>Connected successfully.</pre>";

$errors = 0;
$now    = date('Y-m-d H:i:s');

function run(mysqli $db, string $sql, string $label): void {
    global $errors;
    $result = $db->query($sql);
    if ($result === false) {
        $errno = $db->errno;
        if (in_array($errno, [1050, 1060, 1061, 1062, 1091])) {
            echo "<pre class='skip'>SKIP  $label — already applied ({$db->error})</pre>";
        } else {
            echo "<pre class='err'>ERROR $label — {$db->error}</pre>";
            $errors++;
        }
    } else {
        echo "<pre class='ok'>OK    $label</pre>";
    }
}

// ── SECTION 1: Shield / Auth tables (CodeIgniter Shield) ─────────────────────
echo "<h2>1. Shield Auth Tables</h2>";

run($db, "CREATE TABLE IF NOT EXISTS `users` (
    `id`                   INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username`             VARCHAR(30)  NULL DEFAULT NULL,
    `display_name`         VARCHAR(120) NULL DEFAULT NULL,
    `phone`                VARCHAR(30)  NULL DEFAULT NULL,
    `status`               VARCHAR(255) NULL DEFAULT NULL,
    `status_message`       VARCHAR(255) NULL DEFAULT NULL,
    `must_change_password` TINYINT(1)   NOT NULL DEFAULT 0,
    `access_expires_at`    DATETIME     NULL DEFAULT NULL,
    `active`               TINYINT(1)   NOT NULL DEFAULT 0,
    `last_active`          DATETIME     NULL DEFAULT NULL,
    `created_at`           DATETIME     NULL DEFAULT NULL,
    `updated_at`           DATETIME     NULL DEFAULT NULL,
    `deleted_at`           DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "users table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_identities` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`      INT UNSIGNED NOT NULL,
    `type`         VARCHAR(255) NOT NULL,
    `name`         VARCHAR(255) NULL DEFAULT NULL,
    `secret`       VARCHAR(255) NOT NULL,
    `secret2`      VARCHAR(255) NULL DEFAULT NULL,
    `expires`      DATETIME     NULL DEFAULT NULL,
    `extra`        TEXT         NULL DEFAULT NULL,
    `force_reset`  TINYINT(1)   NOT NULL DEFAULT 0,
    `last_used_at` DATETIME     NULL DEFAULT NULL,
    `created_at`   DATETIME     NULL DEFAULT NULL,
    `updated_at`   DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `auth_identities_type_secret` (`type`, `secret`),
    KEY `auth_identities_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_identities table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_logins` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(255) NULL DEFAULT NULL,
    `user_agent` VARCHAR(255) NULL DEFAULT NULL,
    `id_type`    VARCHAR(255) NOT NULL,
    `identifier` VARCHAR(255) NOT NULL,
    `user_id`    INT UNSIGNED NULL DEFAULT NULL,
    `date`       DATETIME     NOT NULL,
    `success`    TINYINT(1)   NOT NULL,
    PRIMARY KEY (`id`),
    KEY `auth_logins_identifier` (`identifier`),
    KEY `auth_logins_user_id`    (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_logins table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_token_logins` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ip_address` VARCHAR(255) NULL DEFAULT NULL,
    `user_agent` VARCHAR(255) NULL DEFAULT NULL,
    `id_type`    VARCHAR(255) NOT NULL,
    `identifier` VARCHAR(255) NOT NULL,
    `user_id`    INT UNSIGNED NULL DEFAULT NULL,
    `date`       DATETIME     NOT NULL,
    `success`    TINYINT(1)   NOT NULL,
    PRIMARY KEY (`id`),
    KEY `auth_token_logins_identifier` (`identifier`),
    KEY `auth_token_logins_user_id`    (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_token_logins table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_remember_tokens` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `selector`   VARCHAR(255) NOT NULL,
    `hashedValidator` VARCHAR(255) NOT NULL,
    `user_id`    INT UNSIGNED NOT NULL,
    `expires`    DATETIME     NOT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `auth_remember_tokens_selector` (`selector`),
    KEY `auth_remember_tokens_user_id`  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_remember_tokens table");

run($db, "CREATE TABLE IF NOT EXISTS `settings` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `class`      VARCHAR(255) NOT NULL,
    `key`        VARCHAR(255) NOT NULL,
    `value`      TEXT         NULL DEFAULT NULL,
    `type`       VARCHAR(31)  NOT NULL DEFAULT 'string',
    `context`    VARCHAR(255) NULL DEFAULT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `settings_class_key_context` (`class`, `key`, `context`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "settings table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_groups_users` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED NOT NULL,
    `group`      VARCHAR(255) NOT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `auth_groups_users_user_id_group` (`user_id`, `group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_groups_users table");

run($db, "CREATE TABLE IF NOT EXISTS `auth_permissions_users` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED NOT NULL,
    `permission` VARCHAR(255) NOT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `auth_permissions_users_user_id_permission` (`user_id`, `permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "auth_permissions_users table");

run($db, "CREATE TABLE IF NOT EXISTS `migrations` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `version`   VARCHAR(255) NOT NULL,
    `class`     VARCHAR(255) NOT NULL,
    `group`     VARCHAR(255) NOT NULL,
    `namespace` VARCHAR(255) NOT NULL,
    `time`      INT          NOT NULL,
    `batch`     INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "migrations table");

// ── SECTION 2: App tables ─────────────────────────────────────────────────────
echo "<h2>2. App Tables</h2>";

run($db, "CREATE TABLE IF NOT EXISTS `categories` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(100) NOT NULL,
    `slug`        VARCHAR(120) NOT NULL,
    `description` TEXT         NULL DEFAULT NULL,
    `cover_image` VARCHAR(255) NULL DEFAULT NULL,
    `sort_order`  INT          NOT NULL DEFAULT 0,
    `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at`  DATETIME     NULL DEFAULT NULL,
    `updated_at`  DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "categories table");

run($db, "CREATE TABLE IF NOT EXISTS `products` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tag_no`      VARCHAR(50)  NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `trt`         VARCHAR(50)  NULL DEFAULT NULL,
    `gr_wt`       DECIMAL(10,3) NOT NULL DEFAULT 0,
    `purity`      DECIMAL(5,3)  NOT NULL DEFAULT 0,
    `net_wt`      DECIMAL(10,3) NOT NULL DEFAULT 0,
    `labour`      DECIMAL(12,2) NOT NULL DEFAULT 0,
    `size`        VARCHAR(50)  NULL DEFAULT NULL,
    `colour`      VARCHAR(50)  NULL DEFAULT NULL,
    `description` TEXT         NULL DEFAULT NULL,
    `is_in_stock` TINYINT(1)   NOT NULL DEFAULT 1,
    `is_active`   TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at`  DATETIME     NULL DEFAULT NULL,
    `updated_at`  DATETIME     NULL DEFAULT NULL,
    `deleted_at`  DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `products_tag_no` (`tag_no`),
    KEY `products_category_id` (`category_id`),
    CONSTRAINT `products_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "products table");

run($db, "CREATE TABLE IF NOT EXISTS `product_diamonds` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `position`   TINYINT UNSIGNED NOT NULL,
    `carat`      DECIMAL(8,3)  NOT NULL DEFAULT 0,
    `rate`       DECIMAL(12,2) NOT NULL DEFAULT 0,
    `colour`     VARCHAR(10)  NULL DEFAULT NULL,
    `clarity`    VARCHAR(10)  NULL DEFAULT NULL,
    `cut`        VARCHAR(30)  NULL DEFAULT NULL,
    `pieces`     SMALLINT UNSIGNED NULL DEFAULT NULL,
    `shape`      VARCHAR(30)  NULL DEFAULT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_diamonds_product_id_position` (`product_id`, `position`),
    CONSTRAINT `product_diamonds_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "product_diamonds table");

run($db, "CREATE TABLE IF NOT EXISTS `product_stones` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `position`   TINYINT UNSIGNED NOT NULL,
    `name`       VARCHAR(60)  NULL DEFAULT NULL,
    `pieces`     SMALLINT UNSIGNED NULL DEFAULT NULL,
    `weight`     DECIMAL(8,3)  NOT NULL DEFAULT 0,
    `rate`       DECIMAL(12,2) NOT NULL DEFAULT 0,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_stones_product_id_position` (`product_id`, `position`),
    CONSTRAINT `product_stones_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "product_stones table");

run($db, "CREATE TABLE IF NOT EXISTS `product_media` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `type`       ENUM('image','video') NOT NULL DEFAULT 'image',
    `path`       VARCHAR(255) NOT NULL,
    `sort_order` INT          NOT NULL DEFAULT 0,
    `is_cover`   TINYINT(1)   NOT NULL DEFAULT 0,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_media_product_id` (`product_id`),
    CONSTRAINT `product_media_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "product_media table");

run($db, "CREATE TABLE IF NOT EXISTS `access_requests` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(120) NOT NULL,
    `email`         VARCHAR(160) NOT NULL,
    `phone`         VARCHAR(30)  NULL DEFAULT NULL,
    `company`       VARCHAR(160) NULL DEFAULT NULL,
    `address_line1` VARCHAR(200) NULL DEFAULT NULL,
    `address_line2` VARCHAR(200) NULL DEFAULT NULL,
    `city`          VARCHAR(100) NULL DEFAULT NULL,
    `state`         VARCHAR(100) NULL DEFAULT NULL,
    `postal_code`   VARCHAR(20)  NULL DEFAULT NULL,
    `country`       VARCHAR(100) NULL DEFAULT NULL,
    `business_type` VARCHAR(100) NULL DEFAULT NULL,
    `gst_number`    VARCHAR(50)  NULL DEFAULT NULL,
    `website`       VARCHAR(255) NULL DEFAULT NULL,
    `referred_by`   VARCHAR(200) NULL DEFAULT NULL,
    `message`       TEXT         NULL DEFAULT NULL,
    `status`        ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `reviewed_by`   INT UNSIGNED NULL DEFAULT NULL,
    `reviewed_at`   DATETIME     NULL DEFAULT NULL,
    `user_id`       INT UNSIGNED NULL DEFAULT NULL,
    `created_at`    DATETIME     NULL DEFAULT NULL,
    `updated_at`    DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `access_requests_status` (`status`),
    KEY `access_requests_email`  (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "access_requests table");

run($db, "CREATE TABLE IF NOT EXISTS `app_settings` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `key`        VARCHAR(100) NOT NULL,
    `value`      TEXT         NULL DEFAULT NULL,
    `type`       VARCHAR(20)  NOT NULL DEFAULT 'string',
    `label`      VARCHAR(160) NULL DEFAULT NULL,
    `updated_by` INT UNSIGNED NULL DEFAULT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    `updated_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `app_settings_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "app_settings table");

run($db, "CREATE TABLE IF NOT EXISTS `audit_log` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `actor_id`    INT UNSIGNED    NULL DEFAULT NULL,
    `action`      VARCHAR(60)     NOT NULL,
    `entity_type` VARCHAR(60)     NULL DEFAULT NULL,
    `entity_id`   VARCHAR(60)     NULL DEFAULT NULL,
    `details`     TEXT            NULL DEFAULT NULL,
    `ip`          VARCHAR(45)     NULL DEFAULT NULL,
    `created_at`  DATETIME        NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `audit_log_actor_id`            (`actor_id`),
    KEY `audit_log_entity_type_entity_id` (`entity_type`, `entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "audit_log table");

run($db, "CREATE TABLE IF NOT EXISTS `client_activity` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`      INT UNSIGNED    NOT NULL,
    `action`       VARCHAR(40)     NOT NULL,
    `entity_type`  VARCHAR(40)     NULL DEFAULT NULL,
    `entity_id`    VARCHAR(40)     NULL DEFAULT NULL,
    `entity_label` VARCHAR(160)    NULL DEFAULT NULL,
    `path`         VARCHAR(255)    NULL DEFAULT NULL,
    `ip`           VARCHAR(45)     NULL DEFAULT NULL,
    `user_agent`   VARCHAR(255)    NULL DEFAULT NULL,
    `created_at`   DATETIME        NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `client_activity_user_id`              (`user_id`),
    KEY `client_activity_entity_type_entity_id` (`entity_type`, `entity_id`),
    KEY `client_activity_created_at`           (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "client_activity table");

run($db, "CREATE TABLE IF NOT EXISTS `client_favourites` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT UNSIGNED NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `client_favourites_user_product` (`user_id`, `product_id`),
    KEY `client_favourites_user_id`    (`user_id`),
    CONSTRAINT `client_favourites_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci", "client_favourites table");

// ── SECTION 3: Default settings ───────────────────────────────────────────────
echo "<h2>3. Default Settings</h2>";

$settings = [
    ['current_gold_rate', '6200',                                                  'number', 'Current gold rate (per gram, 24K)'],
    ['brand_name',        'The Joharis',                                            'string', 'Brand name'],
    ['brand_tagline',     'A curated digital catalog of fine diamond jewellery.',   'string', 'Brand tagline'],
    ['contact_email',     'contact@thejoharis.com',                                 'string', 'Contact email'],
    ['region',            'IN',                                                      'string', 'Region'],
    ['currency',          'INR',                                                     'string', 'Currency code'],
    ['currency_symbol',   '₹',                                                      'string', 'Currency symbol'],
    ['currency_decimals', '0',                                                       'number', 'Currency decimals'],
    ['date_format',       'd M Y',                                                   'string', 'Date format'],
    ['time_format',       'h:i A',                                                   'string', 'Time format'],
    ['timezone',          'Asia/Kolkata',                                             'string', 'Timezone'],
];

foreach ($settings as [$key, $value, $type, $label]) {
    $k = $db->real_escape_string($key);
    $v = $db->real_escape_string($value);
    $t = $db->real_escape_string($type);
    $l = $db->real_escape_string($label);
    $check = $db->query("SELECT id FROM app_settings WHERE `key` = '$k' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo "<pre class='skip'>SKIP  Setting already exists: $key</pre>";
    } else {
        run($db, "INSERT INTO app_settings (`key`, `value`, `type`, `label`, `created_at`, `updated_at`) VALUES ('$k','$v','$t','$l','$now','$now')", "Setting: $key");
    }
}

// ── SECTION 4: Categories ─────────────────────────────────────────────────────
echo "<h2>4. Categories</h2>";

$categories = [
    'Bangle','Bracelet','Cuff links','Diamond Chain','Earrings',
    'Gents Ring','Lapel Pin','Ladies Ring','Pendant Chain','Pendant',
    'Pendant with Chain','Solitaire Ring','Solitaire Earrings','String','Teeka',
];

foreach ($categories as $cat) {
    $escaped = $db->real_escape_string($cat);
    $slug    = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($cat)), '-');
    $slugEsc = $db->real_escape_string($slug);
    $check   = $db->query("SELECT id FROM categories WHERE LOWER(name) = LOWER('$escaped') LIMIT 1");
    if ($check && $check->num_rows > 0) {
        echo "<pre class='skip'>SKIP  Category already exists: $cat</pre>";
        continue;
    }
    run($db, "INSERT INTO categories (name, slug, is_active, sort_order, created_at, updated_at) VALUES ('$escaped','$slugEsc',1,0,'$now','$now')", "Category: $cat");
}

// ── SECTION 5: Admin user ─────────────────────────────────────────────────────
echo "<h2>5. Admin User</h2>";

$adminEmail    = 'admin@thejoharis.com';
$adminPassword = password_hash('Admin@1234', PASSWORD_BCRYPT);
$adminEsc      = $db->real_escape_string($adminEmail);

$exists = $db->query("SELECT id FROM auth_identities WHERE secret = '$adminEsc' AND type = 'email_password' LIMIT 1");
if ($exists && $exists->num_rows > 0) {
    echo "<pre class='skip'>SKIP  Admin user already exists: $adminEmail</pre>";
} else {
    $db->query("INSERT INTO users (username, active, created_at, updated_at) VALUES ('admin', 1, '$now', '$now')");
    $userId = $db->insert_id;
    if ($userId) {
        $passEsc = $db->real_escape_string($adminPassword);
        run($db, "INSERT INTO auth_identities (user_id, type, secret, secret2, created_at, updated_at) VALUES ($userId, 'email_password', '$adminEsc', '$passEsc', '$now', '$now')", "Admin identity");
        run($db, "INSERT INTO auth_groups_users (user_id, `group`, created_at) VALUES ($userId, 'super_admin', '$now')", "Admin group");
        echo "<pre class='ok'>OK    Admin user created: $adminEmail / Admin@1234</pre>";
        echo "<pre class='info'>⚠ CHANGE THIS PASSWORD after first login!</pre>";
    }
}

// ── Summary ───────────────────────────────────────────────────────────────────
$cls = $errors === 0 ? 'summary' : 'summary fail';
echo "<div class='$cls'>";
if ($errors === 0) {
    echo "<span class='ok'>✓ ALL DONE — Database fully set up. You can now log in at /admin</span><br><br>";
    echo "<span class='ok'>Email: admin@thejoharis.com</span><br>";
    echo "<span class='ok'>Password: Admin@1234</span><br>";
    echo "<span class='err'>Change this password immediately after login!</span>";
} else {
    echo "<span class='err'>✗ Completed with $errors error(s). Review above.</span>";
}
echo "</div>";

echo "<br><p class='err'><strong>DELETE setup_live.php from your server immediately after running it.</strong></p>";
?>
</body>
</html>
