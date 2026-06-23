<?php
/**
 * Standalone product importer — uses PDO directly.
 * Run: php import_products.php
 */

$dsn      = 'mysql:host=localhost;dbname=smokey_db;charset=utf8mb4';
$user     = 'root';
$pass     = '';
$csvPath  = 'C:/Users/DEL/Downloads/products_export_1_unzipped/products_export_1.csv';
$uploadDir = __DIR__ . '/public/uploads/products/';

$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if (!file_exists($csvPath)) die("CSV not found: $csvPath\n");
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$handle  = fopen($csvPath, 'r');
$headers = fgetcsv($handle);
$headers = array_map('trim', $headers);

$idx = [];
foreach ($headers as $i => $h) {
    $idx[$h] = $i;
}

$get = function(array $data, string $key) use ($idx) {
    return isset($idx[$key]) ? trim($data[$idx[$key]] ?? '') : '';
};

$products = [];
$images   = [];

while (($data = fgetcsv($handle)) !== false) {
    if (count($data) < 5) continue;

    $h     = $get($data, 'Handle');
    $title = $get($data, 'Title');
    $img   = $get($data, 'Image Src');
    $pos   = (int)$get($data, 'Image Position');

    if (!$h) continue;

    if ($img) {
        $images[$h][] = ['src' => $img, 'pos' => $pos ?: 99];
    }

    if ($title && !isset($products[$h])) {
        $price   = (float)$get($data, 'Variant Price');
        $compare = (float)$get($data, 'Variant Compare At Price');
        $cost    = (float)$get($data, 'Cost per item');
        $inv     = (int)$get($data, 'Variant Inventory Qty');

        $products[$h] = [
            'handle'        => $h,
            'title'         => $title,
            'description'   => $get($data, 'Body (HTML)'),
            'vendor'        => $get($data, 'Vendor'),
            'type'          => $get($data, 'Type'),
            'tags'          => $get($data, 'Tags'),
            'sku'           => $get($data, 'Variant SKU'),
            'price'         => $price,
            'compare_price' => $compare ?: null,
            'cost_price'    => $cost ?: null,
            'inventory_qty' => $inv,
            'is_in_stock'   => 1,
            'is_active'     => 1,
        ];
    }
}
fclose($handle);

echo "Found " . count($products) . " unique products\n";

// Create categories
$categoryIds = [];
$types = array_unique(array_filter(array_column($products, 'type')));
foreach ($types as $type) {
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $type), '-'));
    $existing = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
    $existing->execute([$slug]);
    $row = $existing->fetch();
    if ($row) {
        $categoryIds[$type] = $row['id'];
    } else {
        $pdo->prepare("INSERT INTO categories (name, slug, is_active, sort_order, created_at, updated_at) VALUES (?,?,1,0,NOW(),NOW())")
            ->execute([ucwords($type), $slug]);
        $categoryIds[$type] = $pdo->lastInsertId();
        echo "  Category: $type\n";
    }
}

// Insert products
$inserted = 0;
$skipped  = 0;

$checkStmt  = $pdo->prepare("SELECT id FROM products WHERE handle = ?");
$insertProd = $pdo->prepare("INSERT INTO products (handle,title,category_id,vendor,sku,description,tags,price,compare_price,cost_price,inventory_qty,is_in_stock,is_active,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())");
$insertMedia = $pdo->prepare("INSERT INTO product_media (product_id,type,path,is_cover,sort_order,created_at,updated_at) VALUES (?,?,?,?,?,NOW(),NOW())");

foreach ($products as $p) {
    $checkStmt->execute([$p['handle']]);
    if ($checkStmt->fetch()) {
        $skipped++;
        continue;
    }

    $catId = $p['type'] ? ($categoryIds[$p['type']] ?? null) : null;

    $insertProd->execute([
        $p['handle'], $p['title'], $catId, $p['vendor'] ?: null, $p['sku'] ?: null,
        $p['description'] ?: null, $p['tags'] ?: null,
        $p['price'], $p['compare_price'], $p['cost_price'],
        $p['inventory_qty'], $p['is_in_stock'], $p['is_active'],
    ]);
    $productId = $pdo->lastInsertId();
    $inserted++;

    // Handle images
    if (!empty($images[$p['handle']])) {
        usort($images[$p['handle']], fn($a, $b) => $a['pos'] - $b['pos']);
        $coverSet = false;
        foreach ($images[$p['handle']] as $imgData) {
            $src      = $imgData['src'];
            $urlPath  = parse_url($src, PHP_URL_PATH);
            $basename = preg_replace('/[?#].*/', '', basename($urlPath));
            $basename = preg_replace('/[^a-zA-Z0-9._-]/', '-', $basename);
            $destPath = 'uploads/products/' . $basename;
            $destFull = $uploadDir . $basename;

            if (!file_exists($destFull)) {
                $ctx = stream_context_create(['http' => ['timeout' => 15]]);
                $imgContent = @file_get_contents($src, false, $ctx);
                if ($imgContent !== false) {
                    file_put_contents($destFull, $imgContent);
                    echo "  ↓ $basename\n";
                } else {
                    // store external URL as path
                    $destPath = $src;
                    echo "  ✗ failed (kept external): " . substr($src, 0, 60) . "\n";
                }
            } else {
                echo "  ✓ exists: $basename\n";
            }

            $insertMedia->execute([$productId, 'image', $destPath, $coverSet ? 0 : 1, $imgData['pos']]);
            $coverSet = true;
        }
    }

    if ($inserted % 10 === 0) echo "Imported $inserted products...\n";
}

echo "\n=== Done ===\n";
echo "Inserted : $inserted\n";
echo "Skipped  : $skipped\n";
echo "Categories: " . count($categoryIds) . "\n";
