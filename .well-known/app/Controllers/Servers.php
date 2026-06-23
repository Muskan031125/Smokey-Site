<?php

namespace App\Controllers;

use App\Models\ServerModel;
use App\Models\ProjectModel;

class Servers extends BaseController
{
    private ServerModel $model;

    public function __construct()
    {
        $this->model = new ServerModel();
    }

    private function sidebarProjects(): array
    {
        return (new ProjectModel())->orderBy('name')->findAll();
    }

    public function index(): string
    {
        $servers = $this->model->orderBy('name')->findAll();
        $pm      = new ProjectModel();

        foreach ($servers as &$s) {
            $s['project_count'] = $pm->where('server_id', $s['id'])->countAllResults();
        }

        return view('layouts/main', [
            'title'    => 'Servers',
            'content'  => view('servers/index', compact('servers')),
            'projects' => $this->sidebarProjects(),
        ]);
    }

    public function show(int $id): string
    {
        $server = $this->model->find($id);
        if (!$server) return redirect()->to('/servers')->with('error', 'Server not found.');

        $projects = (new ProjectModel())->where('server_id', $id)->orderBy('name')->findAll();

        return view('layouts/main', [
            'title'    => $server['name'],
            'content'  => view('servers/show', compact('server', 'projects')),
            'projects' => $this->sidebarProjects(),
        ]);
    }

    public function create(): string
    {
        return view('layouts/main', [
            'title'    => 'Add Server',
            'content'  => view('servers/form', ['server' => null]),
            'projects' => $this->sidebarProjects(),
        ]);
    }

    public function store()
    {
        $data = $this->inputData();
        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return redirect()->to('/servers/' . $this->model->getInsertID())->with('success', 'Server added.');
    }

    public function edit(int $id): string
    {
        $server = $this->model->find($id);
        if (!$server) return redirect()->to('/servers')->with('error', 'Server not found.');

        return view('layouts/main', [
            'title'    => 'Edit Server',
            'content'  => view('servers/form', compact('server')),
            'projects' => $this->sidebarProjects(),
        ]);
    }

    public function update(int $id)
    {
        $server = $this->model->find($id);
        if (!$server) return redirect()->to('/servers')->with('error', 'Server not found.');

        $this->model->update($id, $this->inputData());
        return redirect()->to('/servers/' . $id)->with('success', 'Server updated.');
    }

    public function delete(int $id)
    {
        // Unlink projects before deleting
        (new ProjectModel())->where('server_id', $id)->set(['server_id' => null])->update();
        $this->model->delete($id);
        return redirect()->to('/servers')->with('success', 'Server deleted.');
    }

    private function inputData(): array
    {
        return [
            'name'           => $this->request->getPost('name'),
            'provider'       => $this->request->getPost('provider'),
            'ip_address'     => $this->request->getPost('ip_address'),
            'location'       => $this->request->getPost('location'),
            'plan'           => $this->request->getPost('plan'),
            'panel_url'      => $this->request->getPost('panel_url') ?: null,
            'login_email'    => $this->request->getPost('login_email'),
            'login_password' => $this->request->getPost('login_password'),
            'notes'          => $this->request->getPost('notes'),
            'status'         => $this->request->getPost('status') ?: 'active',
        ];
    }
}
