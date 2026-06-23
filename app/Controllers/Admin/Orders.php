<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    public function index(): string
    {
        $model = new OrderModel();

        $filters = [
            'status' => $this->request->getGet('status') ?? '',
            'search' => $this->request->getGet('q') ?? '',
        ];
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 20;
        $offset  = ($page - 1) * $perPage;

        $orders = $model->listAdmin($filters, $perPage, $offset);
        $total  = $model->countAdmin($filters);

        // Status counts for tabs
        $statusCounts = [];
        foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $s) {
            $statusCounts[$s] = $model->countAdmin(['status' => $s]);
        }

        return view('admin/orders/index', [
            'title'        => 'Orders — Admin',
            'orders'       => $orders,
            'filters'      => $filters,
            'total'        => $total,
            'page'         => $page,
            'perPage'      => $perPage,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function show(int $id): string
    {
        $model = new OrderModel();
        $order = $model->getWithItems($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/orders/show', [
            'title' => 'Order ' . $order['order_number'] . ' — Admin',
            'order' => $order,
        ]);
    }

    public function updateStatus(int $id)
    {
        $model  = new OrderModel();
        $status = $this->request->getPost('status');

        $allowed = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $model->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Order status updated.');
    }
}
