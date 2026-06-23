<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Wishlists extends BaseController
{
    public function index(): string
    {
        $rows = $this->db->table('wishlists w')
            ->select('p.title, p.handle, COUNT(*) as wish_count')
            ->join('products p', 'p.id = w.product_id')
            ->groupBy('w.product_id')
            ->orderBy('wish_count', 'DESC')
            ->limit(50)
            ->get()->getResultArray();

        return view('admin/wishlists/index', [
            'title' => 'Wishlists — Smokey Admin',
            'rows'  => $rows,
            'total' => $this->db->table('wishlists')->countAllResults(),
        ]);
    }
}
