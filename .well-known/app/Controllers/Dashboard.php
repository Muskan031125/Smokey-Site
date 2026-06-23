<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CredentialModel;
use App\Models\ServerModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $projectModel    = new ProjectModel();
        $credentialModel = new CredentialModel();
        $serverModel     = new ServerModel();

        $projects = $projectModel->orderBy('created_at', 'DESC')->findAll();
        foreach ($projects as &$p) {
            $p['credential_count'] = $credentialModel->where('project_id', $p['id'])->countAllResults();
        }

        $servers = $serverModel->orderBy('name')->findAll();
        foreach ($servers as &$s) {
            $s['project_count'] = $projectModel->where('server_id', $s['id'])->countAllResults();
        }

        return view('layouts/main', [
            'title'   => 'Dashboard',
            'content' => view('dashboard/index', compact('projects', 'servers')),
            'projects'=> $projects,
        ]);
    }
}
