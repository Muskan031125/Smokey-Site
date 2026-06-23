<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Banners extends BaseController
{
    public function index(): string
    {
        $banners = $this->db->table('homepage_banners')->orderBy('sort_order', 'ASC')->get()->getResultArray();
        return view('admin/banners/index', ['title' => 'Homepage Banners — Smokey Admin', 'banners' => $banners]);
    }

    public function store()
    {
        $data = $this->request->getPost(['title', 'subtitle', 'link', 'btn_text', 'sort_order']);
        $data['is_active'] = 1;
        $img = $this->request->getFile('image');
        if ($img && $img->isValid()) {
            $name = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/banners/', $name);
            $data['image'] = 'uploads/banners/' . $name;
        }
        $this->db->table('homepage_banners')->insert($data);
        return redirect()->back()->with('success', 'Banner added.');
    }

    public function delete(int $id)
    {
        $this->db->table('homepage_banners')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Banner deleted.');
    }
}
