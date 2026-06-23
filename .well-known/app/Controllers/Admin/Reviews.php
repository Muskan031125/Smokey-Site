<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReviewModel;

class Reviews extends BaseController
{
    public function index(): string
    {
        $model   = new ReviewModel();
        $filters = [
            'is_approved' => $this->request->getGet('status') ?? '',
            'search'      => $this->request->getGet('q') ?? '',
        ];
        $page    = max(1, (int)$this->request->getGet('page'));
        $perPage = 20;

        $reviews = $model->listAdmin($filters, $perPage, ($page - 1) * $perPage);
        $total   = $model->countAdmin($filters);

        return view('admin/reviews/index', [
            'title'   => 'Reviews — Smokey Admin',
            'reviews' => $reviews,
            'filters' => $filters,
            'total'   => $total,
            'page'    => $page,
            'perPage' => $perPage,
            'pending' => $model->where('is_approved', 0)->countAllResults(),
        ]);
    }

    public function approve(int $id)
    {
        $model = new ReviewModel();
        $rv    = $model->find($id);
        if ($rv) {
            $model->update($id, ['is_approved' => 1]);
            $model->recalcProduct($rv['product_id']);
        }
        return redirect()->back()->with('success', 'Review approved.');
    }

    public function reject(int $id)
    {
        $model = new ReviewModel();
        $rv    = $model->find($id);
        if ($rv) {
            $model->update($id, ['is_approved' => 0]);
            $model->recalcProduct($rv['product_id']);
        }
        return redirect()->back()->with('success', 'Review rejected.');
    }

    public function delete(int $id)
    {
        $model = new ReviewModel();
        $rv    = $model->find($id);
        if ($rv) {
            $model->delete($id);
            $model->recalcProduct($rv['product_id']);
        }
        return redirect()->back()->with('success', 'Review deleted.');
    }
}
