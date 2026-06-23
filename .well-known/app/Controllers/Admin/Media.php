<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\ProductMediaModel;
use App\Models\AuditLogModel;

class Media extends BaseController
{
    protected ProductModel $products;
    protected ProductMediaModel $media;
    protected AuditLogModel $audit;

    public function __construct()
    {
        $this->products = new ProductModel();
        $this->media    = new ProductMediaModel();
        $this->audit    = new AuditLogModel();
    }

    public function index(int $productId)
    {
        $product = $this->products->find($productId);
        if (!$product) {
            return redirect()->to(site_url('admin/products'))->with('error', 'Not found.');
        }

        return view('admin/products/media', [
            'title'      => 'Media — ' . $product['tag_no'],
            'heading'    => 'Media: ' . $product['tag_no'],
            'subheading' => 'Upload and manage images & videos',
            'product'    => $product,
            'media'      => $this->media->forProduct($productId),
        ]);
    }

    public function upload(int $productId)
    {
        $product = $this->products->find($productId);
        if (!$product) {
            return redirect()->to(site_url('admin/products'))->with('error', 'Not found.');
        }

        $files = $this->request->getFileMultiple('files');
        if (!$files) {
            return redirect()->back()->with('error', 'No files uploaded.');
        }

        $uploadDir = FCPATH . 'uploads/skus/' . $productId;
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        $uploaded = 0;
        foreach ($files as $file) {
            if (!$file || !$file->isValid() || $file->hasMoved()) continue;

            $mime = $file->getMimeType();
            $isImage = str_starts_with((string) $mime, 'image/');
            $isVideo = str_starts_with((string) $mime, 'video/');
            if (!$isImage && !$isVideo) continue;

            $name = $file->getRandomName();
            if (!$file->move($uploadDir, $name)) continue;

            $relPath = 'uploads/skus/' . $productId . '/' . $name;
            $this->media->insert([
                'product_id' => $productId,
                'type'       => $isVideo ? 'video' : 'image',
                'path'       => $relPath,
                'sort_order' => 0,
                'is_cover'   => 0,
            ]);
            $uploaded++;
        }

        // If no cover set yet, promote first image to cover
        $hasCover = $this->media->where('product_id', $productId)->where('is_cover', 1)->countAllResults();
        if (!$hasCover) {
            $first = $this->media->where('product_id', $productId)->where('type', 'image')->orderBy('id', 'asc')->first();
            if ($first) {
                $this->media->update($first['id'], ['is_cover' => 1]);
            }
        }

        $this->audit->log('media.upload', 'product', $productId, $uploaded . ' files');
        return redirect()->to(site_url('admin/products/' . $productId . '/media'))
            ->with('success', $uploaded . ' file(s) uploaded.');
    }

    public function addVimeo(int $productId)
    {
        $product = $this->products->find($productId);
        if (!$product) {
            return redirect()->to(site_url('admin/products'))->with('error', 'Not found.');
        }

        $url = trim((string) $this->request->getPost('vimeo_url'));
        if ($url === '' || !preg_match('~^https?://(?:[\w.-]+\.)?vimeo\.com/~i', $url)) {
            return redirect()->back()->with('error', 'Please provide a valid Vimeo URL (e.g. https://vimeo.com/123456789).');
        }

        // Don't add the same video twice for a product.
        $exists = $this->media->where('product_id', $productId)->where('path', $url)->countAllResults();
        if ($exists) {
            return redirect()->to(site_url('admin/products/' . $productId . '/media'))
                ->with('error', 'That video is already added to this SKU.');
        }

        $this->media->insert([
            'product_id' => $productId,
            'type'       => 'video',
            'path'       => $url,
            'sort_order' => 0,
            'is_cover'   => 0,
        ]);

        $this->audit->log('media.add_vimeo', 'product', $productId, $url);
        return redirect()->to(site_url('admin/products/' . $productId . '/media'))
            ->with('success', 'Vimeo video added.');
    }

    public function setCover(int $productId, int $mediaId)
    {
        $row = $this->media->find($mediaId);
        if (!$row || (int) $row['product_id'] !== $productId) {
            return redirect()->back()->with('error', 'Not found.');
        }
        $this->media->clearCoverFor($productId);
        $this->media->update($mediaId, ['is_cover' => 1]);
        $this->audit->log('media.set_cover', 'media', $mediaId);
        return redirect()->back()->with('success', 'Cover updated.');
    }

    public function reorder(int $productId)
    {
        $product = $this->products->find($productId);
        if (!$product) {
            return $this->response->setJSON(['ok' => false, 'error' => 'not_found']);
        }

        $order = $this->request->getJSON(true)['order'] ?? [];
        if (!is_array($order)) {
            return $this->response->setJSON(['ok' => false, 'error' => 'bad_payload']);
        }

        foreach ($order as $position => $mediaId) {
            $mediaId = (int) $mediaId;
            if ($mediaId <= 0) continue;
            $this->media->where('product_id', $productId)
                        ->where('id', $mediaId)
                        ->set(['sort_order' => (int) $position])
                        ->update();
        }

        $this->audit->log('media.reorder', 'product', $productId, count($order) . ' items');
        return $this->response->setJSON(['ok' => true]);
    }

    public function delete(int $productId, int $mediaId)
    {
        $row = $this->media->find($mediaId);
        if (!$row || (int) $row['product_id'] !== $productId) {
            return redirect()->back()->with('error', 'Not found.');
        }

        $isExternal = str_starts_with((string) $row['path'], 'http://') || str_starts_with((string) $row['path'], 'https://');
        if (!$isExternal) {
            $abs = FCPATH . $row['path'];
            if (is_file($abs)) @unlink($abs);
        }

        $this->media->delete($mediaId);
        $this->audit->log('media.delete', 'media', $mediaId);
        return redirect()->back()->with('success', 'File deleted.');
    }
}
