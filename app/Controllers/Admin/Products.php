<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductMediaModel;

class Products extends BaseController
{
    protected ProductModel $model;
    protected CategoryModel $cats;
    protected ProductMediaModel $media;

    public function __construct()
    {
        $this->model = new ProductModel();
        $this->cats  = new CategoryModel();
        $this->media = new ProductMediaModel();
    }

    public function index(): string
    {
        $filters = [
            'search'      => trim((string)$this->request->getGet('q')),
            'category_id' => $this->request->getGet('category'),
            'is_active'   => $this->request->getGet('status') ?? '',
        ];
        $perPage = in_array((int)$this->request->getGet('per_page'), [20, 50, 100]) ? (int)$this->request->getGet('per_page') : 20;
        $page    = max(1, (int)$this->request->getGet('page'));
        $offset  = ($page - 1) * $perPage;

        $products   = $this->model->listAdmin($filters, $perPage, $offset);
        $total      = $this->model->countAdmin($filters);
        $categories = $this->cats->orderBy('name', 'ASC')->findAll();

        return view('admin/products/index', [
            'title'      => 'Products — Smokey Admin',
            'products'   => $products,
            'categories' => $categories,
            'filters'    => $filters,
            'total'      => $total,
            'page'       => $page,
            'perPage'    => $perPage,
        ]);
    }

    public function create(): string
    {
        return view('admin/products/form', [
            'title'      => 'Add Product — Smokey Admin',
            'product'    => null,
            'categories' => $this->cats->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost([
            'title', 'category_id', 'vendor', 'sku', 'description',
            'tags', 'price', 'compare_price', 'cost_price', 'inventory_qty',
            'size', 'colour', 'material',
        ]);
        $data['is_in_stock']    = $this->request->getPost('is_in_stock') ? 1 : 0;
        $data['is_active']      = $this->request->getPost('is_active') ? 1 : 0;
        $data['is_new_arrival'] = $this->request->getPost('is_new_arrival') ? 1 : 0;
        $data['is_best_seller'] = $this->request->getPost('is_best_seller') ? 1 : 0;
        $data['is_featured']    = $this->request->getPost('is_featured') ? 1 : 0;
        $data['handle']         = $this->model->generateHandle($data['title']);

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to(site_url('admin/products'))->with('success', 'Product created.');
    }

    public function edit(int $id): string
    {
        $product = $this->model->getWithCategory($id);
        if (!$product) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $media = $this->media->where('product_id', $id)->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/products/form', [
            'title'      => 'Edit Product — Smokey Admin',
            'product'    => $product,
            'categories' => $this->cats->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
            'media'      => $media,
        ]);
    }

    public function update(int $id)
    {
        $product = $this->model->find($id);
        if (!$product) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = $this->request->getPost([
            'title', 'category_id', 'vendor', 'sku', 'description',
            'tags', 'price', 'compare_price', 'cost_price', 'inventory_qty',
            'size', 'colour', 'material',
        ]);
        $data['is_in_stock']    = $this->request->getPost('is_in_stock') ? 1 : 0;
        $data['is_active']      = $this->request->getPost('is_active') ? 1 : 0;
        $data['is_new_arrival'] = $this->request->getPost('is_new_arrival') ? 1 : 0;
        $data['is_best_seller'] = $this->request->getPost('is_best_seller') ? 1 : 0;
        $data['is_featured']    = $this->request->getPost('is_featured') ? 1 : 0;

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to(site_url('admin/products'))->with('success', 'Product updated.');
    }

    public function toggleStock(int $id)
    {
        $product = $this->model->find($id);
        if (!$product) return redirect()->back();
        $this->model->update($id, ['is_in_stock' => $product['is_in_stock'] ? 0 : 1]);
        return redirect()->back()->with('success', 'Stock status updated.');
    }

    public function toggleFlag(int $id)
    {
        $flag    = $this->request->getPost('flag');
        $allowed = ['is_new_arrival', 'is_best_seller', 'is_featured', 'is_active'];
        if (!in_array($flag, $allowed)) return redirect()->back();

        $product = $this->model->find($id);
        if (!$product) return redirect()->back();
        $this->model->update($id, [$flag => $product[$flag] ? 0 : 1]);
        return redirect()->back()->with('success', 'Product updated.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(site_url('admin/products'))->with('success', 'Product deleted.');
    }
}
