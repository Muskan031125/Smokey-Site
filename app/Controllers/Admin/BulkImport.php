<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class BulkImport extends BaseController
{
    public function index(): string
    {
        return view('admin/bulk_import/index', [
            'title' => 'Bulk Import — Smokey Admin',
        ]);
    }

    public function preview()
    {
        $file = $this->request->getFile('csv_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please upload a valid CSV or ZIP file.');
        }

        $tmpName = 'bulk_' . time() . '.csv';
        $csvPath = WRITEPATH . 'uploads/' . $tmpName;

        // Handle ZIP
        $ext = strtolower($file->getClientExtension());
        if ($ext === 'zip') {
            if (!class_exists('ZipArchive')) {
                return redirect()->back()->with('error', 'ZIP not supported on server. Extract the CSV and upload directly.');
            }
            $zipTmp = WRITEPATH . 'uploads/bulk_zip_' . time() . '.zip';
            $file->move(WRITEPATH . 'uploads/', basename($zipTmp));
            $zip = new \ZipArchive();
            if ($zip->open($zipTmp) !== true) {
                return redirect()->back()->with('error', 'Could not open ZIP.');
            }
            $csvFound = false;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'csv') {
                    $zip->extractTo(WRITEPATH . 'uploads/', $name);
                    rename(WRITEPATH . 'uploads/' . $name, $csvPath);
                    $csvFound = true;
                    break;
                }
            }
            $zip->close();
            @unlink($zipTmp);
            if (!$csvFound) {
                return redirect()->back()->with('error', 'No CSV found inside ZIP.');
            }
        } else {
            $file->move(WRITEPATH . 'uploads/', $tmpName);
        }

        $rows    = [];
        $headers = [];
        $handle  = fopen($csvPath, 'r');
        $headers = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false && count($rows) < 5) {
            $rows[] = array_combine($headers, array_pad($data, count($headers), ''));
        }
        fclose($handle);

        return view('admin/bulk_import/preview', [
            'title'   => 'Preview Import — Smokey Admin',
            'headers' => $headers,
            'rows'    => $rows,
            'tmpFile' => $tmpName,
        ]);
    }

    public function import()
    {
        $tmpFile = WRITEPATH . 'uploads/' . basename($this->request->getPost('tmp_file') ?? '');
        if (!file_exists($tmpFile)) {
            return redirect()->to(site_url('admin/bulk-import'))->with('error', 'File not found. Please re-upload.');
        }

        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $db            = \Config\Database::connect();

        $handle  = fopen($tmpFile, 'r');
        $headers = fgetcsv($handle);

        // Normalise headers to lowercase for flexible matching
        $headers = array_map('strtolower', array_map('trim', $headers));

        $inserted = 0;
        $updated  = 0;
        $skipped  = 0;

        // Track which handles we've already processed so we can add extra images
        $processedHandles = [];

        while (($data = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, array_pad($data, count($headers), ''));

            // ── Helpers to read column by multiple possible names ──
            $col = function(array $keys) use ($row) {
                foreach ($keys as $k) {
                    if (isset($row[$k]) && trim($row[$k]) !== '') return trim($row[$k]);
                }
                return '';
            };

            $handle_val = $col(['handle']);
            $title      = $col(['title']);
            $imageSrc   = $col(['image src']);

            // If no title AND no handle — skip empty row
            if (!$title && !$handle_val) { $skipped++; continue; }

            // If this handle already processed — just try to add extra image
            if ($handle_val && isset($processedHandles[$handle_val])) {
                if ($imageSrc) {
                    $pid = $processedHandles[$handle_val];
                    $exists = $db->table('product_media')
                        ->where('product_id', $pid)
                        ->where('path', $imageSrc)
                        ->countAllResults();
                    if (!$exists) {
                        $db->table('product_media')->insert([
                            'product_id' => $pid,
                            'type'       => 'image',
                            'path'       => $imageSrc,
                            'sort_order' => 99,
                            'is_cover'   => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
                $skipped++;
                continue;
            }

            // ── Price — Shopify uses "Variant Price" ──
            $price = (float)$col(['variant price', 'price', 'selling price']);
            if ($price <= 0) $price = (float)$col(['price']);

            // ── Compare price ──
            $comparePrice = (float)$col(['variant compare at price', 'compare at price', 'compare_price', 'compare price']);
            if ($comparePrice <= 0) $comparePrice = null;

            // ── Inventory ──
            $inventory = (int)$col(['variant inventory qty', 'inventory_qty', 'stock', 'qty', 'quantity']);

            // ── Category ──
            $catName = $col(['type', 'product type', 'category', 'product category']);
            $catId   = null;
            if ($catName) {
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $catName), '-'));
                $cat  = $categoryModel->where('slug', $slug)->first();
                if (!$cat) {
                    $categoryModel->insert([
                        'name'       => $catName,
                        'slug'       => $slug,
                        'is_active'  => 1,
                        'sort_order' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $catId = $categoryModel->getInsertID();
                } else {
                    $catId = $cat['id'];
                }
            }

            // ── Flags from tags ──
            $tags       = strtolower($col(['tags']));
            $isNew      = (int)(str_contains($tags,'new-arrival') || str_contains($tags,'new arrival') || str_contains($tags,'just-arrived'));
            $isBest     = (int)(str_contains($tags,'best-seller') || str_contains($tags,'best seller') || str_contains($tags,'bestseller') || str_contains($tags,'best selling'));
            $isFeatured = (int)(str_contains($tags,'featured') || str_contains($tags,"founder's pick") || str_contains($tags,'founders pick'));
            $isOnSale   = (int)($comparePrice && $comparePrice > $price);

            // ── Handle ──
            if (!$handle_val) {
                $handle_val = $productModel->generateHandle($title);
            }

            // ── Build product data ──
            $productData = [
                'handle'         => $handle_val,
                'title'          => $title,
                'category_id'    => $catId,
                'vendor'         => $col(['vendor']),
                'sku'            => $col(['variant sku', 'sku']),
                'description'    => $col(['body (html)', 'description', 'body']),
                'tags'           => $col(['tags']),
                'price'          => $price,
                'compare_price'  => $comparePrice,
                'inventory_qty'  => $inventory,
                'is_in_stock'    => $inventory > 0 ? 1 : 1,
                'is_active'      => 1,
                'is_new_arrival' => $isNew,
                'is_best_seller' => $isBest,
                'is_featured'    => $isFeatured,
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            // ── Insert or UPDATE existing ──
            $existing = $productModel->where('handle', $handle_val)->first();
            if ($existing) {
                $productModel->update($existing['id'], $productData);
                $pid = $existing['id'];
                $updated++;
            } else {
                $productData['created_at'] = date('Y-m-d H:i:s');
                $productModel->insert($productData);
                $pid = $productModel->getInsertID();
                $inserted++;
            }

            $processedHandles[$handle_val] = $pid;

            // ── Import cover image ──
            if ($imageSrc && $pid) {
                $imgExists = $db->table('product_media')
                    ->where('product_id', $pid)
                    ->where('path', $imageSrc)
                    ->countAllResults();
                if (!$imgExists) {
                    // Remove old cover first if updating
                    if ($existing) {
                        $db->table('product_media')
                            ->where('product_id', $pid)
                            ->where('is_cover', 1)
                            ->delete();
                    }
                    $db->table('product_media')->insert([
                        'product_id' => $pid,
                        'type'       => 'image',
                        'path'       => $imageSrc,
                        'sort_order' => 1,
                        'is_cover'   => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }

        fclose($handle);
        @unlink($tmpFile);

        return redirect()->to(site_url('admin/products'))
            ->with('success', "Import complete: {$inserted} new, {$updated} updated, {$skipped} variant rows skipped.");
    }

    public function uploadPhotos()
    {
        return redirect()->to(site_url('admin/bulk-import'))->with('info', 'Use the product media manager to upload photos.');
    }

    public function template()
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="smokey_import_template.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Handle','Title','Type','Vendor','Variant SKU','Variant Price','Variant Compare At Price','Variant Inventory Qty','Body (HTML)','Tags','Image Src']);
        fputcsv($out, ['whisky-glass-set','Whisky Glass Set (6pc)','Whi Glasses','Smokey','SKU001','3599','4500','10','Premium crystal whisky glasses','barware,best-seller','https://cdn.shopify.com/example.jpg']);
        fclose($out);
    }
}
