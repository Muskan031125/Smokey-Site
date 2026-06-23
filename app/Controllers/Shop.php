<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductMediaModel;
use App\Models\WishlistModel;

class Shop extends BaseController
{
    private function buildFilters(): array
    {
        return [
            'search'      => trim((string)$this->request->getGet('q')),
            'category_id' => $this->request->getGet('cat'),
            'colour'      => $this->request->getGet('colour'),
            'min_price'   => $this->request->getGet('min_price'),
            'max_price'   => $this->request->getGet('max_price'),
            'in_stock'    => $this->request->getGet('in_stock'),
            'sort'        => $this->request->getGet('sort') ?? 'newest',
            'flag'        => $this->request->getGet('flag'),
        ];
    }

    private function wishlistedIds(): array
    {
        $wModel = new WishlistModel();
        $sid    = session()->get('__cart_sid') ?? '';
        $uid    = auth()->loggedIn() ? (int)auth()->user()->id : null;
        return $wModel->getProductIds($sid, $uid);
    }

    public function index(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $filters = $this->buildFilters();
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 24;
        $offset  = ($page - 1) * $perPage;

        $products   = $productModel->listPublic($filters, $perPage, $offset);
        $total      = $productModel->countPublic($filters);
        $categories = $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
        $colours    = $productModel->getDistinctColours();

        return view('public/shop', [
            'title'        => 'Shop — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'pageHeading'  => 'All Products',
            'products'     => $products,
            'categories'   => $categories,
            'colours'      => $colours,
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'wishlistedIds'=> $this->wishlistedIds(),
        ]);
    }

    public function newArrivals(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $filters = array_merge($this->buildFilters(), ['flag' => 'new_arrival']);
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 24;

        $products   = $productModel->listPublic($filters, $perPage, ($page - 1) * $perPage);
        $total      = $productModel->countPublic($filters);
        $categories = $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        return view('public/shop', [
            'title'        => 'New Arrivals — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'pageHeading'  => 'New Arrivals',
            'products'     => $products,
            'categories'   => $categories,
            'colours'      => $productModel->getDistinctColours(),
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'wishlistedIds'=> $this->wishlistedIds(),
        ]);
    }

    public function bestSellers(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $filters = array_merge($this->buildFilters(), ['flag' => 'best_seller']);
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 24;

        $products   = $productModel->listPublic($filters, $perPage, ($page - 1) * $perPage);
        $total      = $productModel->countPublic($filters);
        $categories = $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        return view('public/shop', [
            'title'        => 'Best Sellers — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'pageHeading'  => 'Best Sellers',
            'products'     => $products,
            'categories'   => $categories,
            'colours'      => $productModel->getDistinctColours(),
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'wishlistedIds'=> $this->wishlistedIds(),
        ]);
    }

    public function sale(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $filters = array_merge($this->buildFilters(), ['on_sale' => true]);
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 24;

        $products   = $productModel->listPublic($filters, $perPage, ($page - 1) * $perPage);
        $total      = $productModel->countPublic($filters);
        $categories = $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

        return view('public/shop', [
            'title'        => 'Sale — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'pageHeading'  => 'On Sale',
            'products'     => $products,
            'categories'   => $categories,
            'colours'      => $productModel->getDistinctColours(),
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'wishlistedIds'=> $this->wishlistedIds(),
        ]);
    }

    public function category(string $slug): string
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $category = $categoryModel->where('slug', $slug)->where('is_active', 1)->first();
        if (!$category) {
            // Category slug not in DB yet — show empty page instead of hard 404
            $category = ['id' => 0, 'name' => ucwords(str_replace('-', ' ', $slug)), 'slug' => $slug];
        }

        $filters  = array_merge($this->buildFilters(), ['category_id' => $category['id']]);
        $page     = max(1, (int)$this->request->getGet('page'));
        $perPage  = 24;

        $products = $productModel->listPublic($filters, $perPage, ($page - 1) * $perPage);
        $total    = $productModel->countPublic($filters);

        return view('public/shop', [
            'title'        => $category['name'] . ' — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'pageHeading'  => $category['name'],
            'category'     => $category,
            'products'     => $products,
            'categories'   => $categoryModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'colours'      => $productModel->getDistinctColours(),
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'wishlistedIds'=> $this->wishlistedIds(),
        ]);
    }

    public function product(string $handle): string
    {
        $productModel = new ProductModel();
        $mediaModel   = new ProductMediaModel();

        $product = is_numeric($handle)
            ? $productModel->getWithCategory((int)$handle)
            : $productModel->getByHandle($handle);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $media    = $mediaModel->where('product_id', $product['id'])->orderBy('sort_order', 'ASC')->findAll();
        $dbConn   = \Config\Database::connect();
        $variants = $dbConn->table('product_variants')
            ->where('product_id', $product['id'])->where('is_active', 1)
            ->orderBy('option_name', 'ASC')->orderBy('sort_order', 'ASC')
            ->get()->getResultArray();

        // Group variants by option_name
        $variantGroups = [];
        foreach ($variants as $v) {
            $variantGroups[$v['option_name']][] = $v;
        }

        $reviewModel = new \App\Models\ReviewModel();
        $reviews     = $reviewModel->getApproved($product['id']);
        $ratingStats = $reviewModel->getRatingStats($product['id']);

        $promoCodes = $dbConn->table('promo_codes')->where('is_active', 1)->orderBy('sort_order', 'ASC')->get()->getResultArray();

        $related = [];
        if ($product['category_id']) {
            $related = $productModel->listPublic(['category_id' => $product['category_id']], 4, 0);
            $related = array_values(array_filter($related, fn($r) => $r['id'] !== $product['id']));
        }

        $wModel       = new WishlistModel();
        $sid          = session()->get('__cart_sid') ?? '';
        $uid          = auth()->loggedIn() ? (int)auth()->user()->id : null;
        $isWishlisted = $wModel->isWishlisted($product['id'], $sid, $uid);

        return view('public/product', [
            'title'         => $product['title'] . ' — ' . brand_setting('brand_name', 'Smokey Cocktail'),
            'product'       => $product,
            'media'         => $media,
            'variantGroups' => $variantGroups,
            'reviews'       => $reviews,
            'ratingStats'   => $ratingStats,
            'promoCodes'    => $promoCodes,
            'related'       => $related,
            'isWishlisted'  => $isWishlisted,
        ]);
    }
}
