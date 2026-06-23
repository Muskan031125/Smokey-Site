-- Fix admin password
UPDATE auth_identities SET secret2 = '$2y$10$QYr0Yb5qcO2iILVH81s3ieaJ8B.Jb7M457T4yJnZiEmgyvXX8oZMK' WHERE user_id = 1 AND type = 'email_password';

-- Add super_admin group
INSERT IGNORE INTO auth_groups_users (user_id, `group`, created_at) VALUES (1, 'super_admin', NOW());

-- Site settings
INSERT INTO app_settings (`key`, `value`, created_at, updated_at) VALUES
('site_name', 'Smokey Cocktail', NOW(), NOW()),
('site_tagline', 'Handcrafted Barware & Cocktail Essentials', NOW(), NOW()),
('currency_symbol', '₹', NOW(), NOW()),
('contact_email', 'hello@smokeycocktail.com', NOW(), NOW()),
('contact_phone', '+91 98765 43210', NOW(), NOW()),
('contact_address', 'Mumbai, India', NOW(), NOW())
ON DUPLICATE KEY UPDATE value = VALUES(value), updated_at = NOW();
