<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PromoCodes extends BaseController
{
    public function index(): string
    {
        $codes = $this->db->table('promo_codes')->orderBy('sort_order', 'ASC')->get()->getResultArray();
        return view('admin/promo_codes/index', ['title' => 'Promo Codes — Smokey Admin', 'codes' => $codes]);
    }

    public function store()
    {
        $this->db->table('promo_codes')->insert([
            'code'       => strtoupper(trim($this->request->getPost('code') ?? '')),
            'label'      => $this->request->getPost('label'),
            'is_active'  => 1,
            'sort_order' => (int)$this->request->getPost('sort_order'),
        ]);
        return redirect()->back()->with('success', 'Promo code added.');
    }

    public function delete(int $id)
    {
        $this->db->table('promo_codes')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Code deleted.');
    }
}
