<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index(): string
    {
        $model  = new OrderModel();
        $userId = (int)auth()->user()->id;

        $orders = $model->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')->findAll();

        return view('public/orders', [
            'title'  => 'My Orders — ' . brand_setting('site_name'),
            'orders' => $orders,
        ]);
    }

    public function show(int $id): string
    {
        $model  = new OrderModel();
        $userId = (int)auth()->user()->id;

        $order = $model->getWithItems($id);
        if (!$order || $order['user_id'] != $userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('public/order_detail', [
            'title' => 'Order ' . $order['order_number'] . ' — ' . brand_setting('site_name'),
            'order' => $order,
        ]);
    }
}
