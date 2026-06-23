<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\ReviewModel;
use App\Models\BlogModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $orderModel    = new OrderModel();
        $reviewModel   = new ReviewModel();
        $blogModel     = new BlogModel();

        return view('admin/dashboard', [
            'title'          => 'Dashboard — Smokey Admin',
            'productCount'   => $productModel->where('deleted_at IS NULL')->countAllResults(),
            'categoryCount'  => $categoryModel->where('is_active', 1)->countAllResults(),
            'totalOrders'    => $orderModel->countAllResults(),
            'pendingOrders'  => $orderModel->where('status', 'pending')->countAllResults(),
            'pendingReviews' => $reviewModel->where('is_approved', 0)->countAllResults(),
            'blogCount'      => $blogModel->where('is_published', 1)->countAllResults(),
            'recentOrders'   => $orderModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ]);
    }
}
