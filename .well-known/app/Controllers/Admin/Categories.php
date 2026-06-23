<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\AuditLogModel;

class Categories extends BaseController
{
    protected CategoryModel $model;
    protected AuditLogModel $audit;

    public function __construct()
    {
        $this->model = new CategoryModel();
        $this->audit = new AuditLogModel();
    }

    public function index()
    {
        return view('admin/categories/index', [
            'title'      => 'Categories — Smokey Admin',
            'heading'    => 'Categories',
            'subheading' => 'Manage jewellery collections',
            'categories' => $this->model->withProductCounts(),
        ]);
    }

    public function create()
    {
        return view('admin/categories/form', [
            'title'    => 'New Category',
            'heading'  => 'New Category',
            'category' => null,
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost(['name', 'slug', 'description', 'sort_order']);
        $data['slug'] = $data['slug'] ?: url_title($data['name'] ?? '', '-', true);
        $data['is_active'] = 1;

        // Cover image: either uploaded file or pasted URL
        $uploaded = $this->handleCoverUpload();
        if ($uploaded !== null) {
            $data['cover_image'] = $uploaded;
        } else {
            $url = trim((string) $this->request->getPost('cover_image_url'));
            if ($url !== '') {
                $data['cover_image'] = $url;
            }
        }

        $slugExists = $this->model->where('slug', $data['slug'])->countAllResults() > 0;
        if ($slugExists) {
            return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug "' . $data['slug'] . '" is already in use. Choose a different one.']);
        }

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        $this->audit->log('category.create', 'category', $this->model->getInsertID(), $data['name'] ?? '');
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category created.');
    }

    public function edit(int $id)
    {
        $cat = $this->model->find($id);
        if (!$cat) {
            return redirect()->to(site_url('admin/categories'))->with('error', 'Not found.');
        }
        return view('admin/categories/form', [
            'title'    => 'Edit Category',
            'heading'  => 'Edit Category',
            'category' => $cat,
        ]);
    }

    public function update(int $id)
    {
        $cat = $this->model->find($id);
        if (!$cat) {
            return redirect()->to(site_url('admin/categories'))->with('error', 'Not found.');
        }

        $data = $this->request->getPost(['name', 'slug', 'description', 'sort_order']);
        $data['slug'] = $data['slug'] ?: url_title($data['name'] ?? '', '-', true);

        // Cover image handling
        if ($this->request->getPost('remove_cover')) {
            $this->deleteLocalCover($cat['cover_image'] ?? null);
            $data['cover_image'] = null;
        } else {
            $uploaded = $this->handleCoverUpload();
            if ($uploaded !== null) {
                $this->deleteLocalCover($cat['cover_image'] ?? null);
                $data['cover_image'] = $uploaded;
            } else {
                $url = trim((string) $this->request->getPost('cover_image_url'));
                if ($url !== '' && $url !== ($cat['cover_image'] ?? '')) {
                    $this->deleteLocalCover($cat['cover_image'] ?? null);
                    $data['cover_image'] = $url;
                }
            }
        }

        $slugExists = $this->model->where('slug', $data['slug'])->where('id !=', $id)->countAllResults() > 0;
        if ($slugExists) {
            return redirect()->back()->withInput()->with('errors', ['slug' => 'The slug "' . $data['slug'] . '" is already in use. Choose a different one.']);
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        $this->audit->log('category.update', 'category', $id, $data['name'] ?? '');
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category updated.');
    }

    /** Handle a file upload, return the relative path or null. */
    protected function handleCoverUpload(): ?string
    {
        $file = $this->request->getFile('cover_image');
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $mime = (string) $file->getMimeType();
        if (!str_starts_with($mime, 'image/')) {
            return null;
        }

        $dir = FCPATH . 'uploads/categories';
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $name = $file->getRandomName();
        if (!$file->move($dir, $name)) {
            return null;
        }

        return 'uploads/categories/' . $name;
    }

    /** Only delete if it's a local upload (not an external URL). */
    protected function deleteLocalCover(?string $path): void
    {
        if (empty($path) || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }
        $abs = FCPATH . ltrim($path, '/');
        if (is_file($abs)) {
            @unlink($abs);
        }
    }

    public function toggle(int $id)
    {
        $cat = $this->model->find($id);
        if (!$cat) {
            return redirect()->to(site_url('admin/categories'))->with('error', 'Not found.');
        }
        $this->model->update($id, ['is_active' => $cat['is_active'] ? 0 : 1]);
        $this->audit->log('category.toggle', 'category', $id);
        return redirect()->to(site_url('admin/categories'))->with('success', 'Category status updated.');
    }
}
