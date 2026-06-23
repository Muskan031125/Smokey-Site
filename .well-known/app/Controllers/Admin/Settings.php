<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    public function index(): string
    {
        $model = new SettingModel();
        return view('admin/settings/index', [
            'title'    => 'Settings — Smokey Admin',
            'settings' => $model->all(),
        ]);
    }

    public function update()
    {
        $model  = new SettingModel();
        $fields = $this->request->getPost('setting') ?? [];
        foreach ($fields as $key => $value) {
            $model->put($key, $value);
        }
        return redirect()->to(site_url('admin/settings'))->with('success', 'Settings saved.');
    }
}
