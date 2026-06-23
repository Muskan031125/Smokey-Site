<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CredentialModel;
use App\Models\ServerModel;

class Projects extends BaseController
{
    private ProjectModel $model;
    private const PER_PAGE = 10;

    public function __construct()
    {
        $this->model = new ProjectModel();
    }

    public function index(): string
    {
        $search = trim($this->request->getGet('q') ?? '');
        $page   = max(1, (int) ($this->request->getGet('page') ?? 1));

        $builder = $this->model->orderBy('created_at', 'DESC');
        if ($search !== '') {
            $builder->like('name', $search);
        }

        $total    = $builder->countAllResults(false);
        $projects = $builder->paginate(self::PER_PAGE, 'default', $page);
        $pager    = $this->model->pager;

        // Attach server name to each project
        $serverModel = new \App\Models\ServerModel();
        $servers     = $serverModel->findAll();
        $serverMap   = array_column($servers, null, 'id');
        foreach ($projects as &$p) {
            $p['server_name'] = $p['server_id'] ? ($serverMap[$p['server_id']]['name'] ?? null) : null;
        }

        return view('layouts/main', [
            'title'    => 'Projects',
            'content'  => view('projects/index', compact('projects', 'search', 'total', 'pager', 'page')),
            'projects' => $this->model->orderBy('name')->findAll(),
        ]);
    }

    public function show(int $id): string
    {
        $project = $this->model->find($id);
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found.');
        }

        $server      = $project['server_id'] ? (new ServerModel())->find($project['server_id']) : null;
        $credentials = (new CredentialModel())->getByProject($id);

        return view('layouts/main', [
            'title'    => $project['name'],
            'content'  => view('projects/show', compact('project', 'credentials', 'server')),
            'projects' => $this->model->orderBy('name')->findAll(),
            'addBtn'   => ['label' => '+ Add Credential'],
        ]);
    }

    public function create(): string
    {
        return view('layouts/main', [
            'title'    => 'New Project',
            'content'  => view('projects/form', ['project' => null, 'servers' => (new ServerModel())->orderBy('name')->findAll()]),
            'projects' => $this->model->orderBy('name')->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->inputData();
        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
        return redirect()->to('/projects/' . $this->model->getInsertID())->with('success', 'Project created.');
    }

    public function edit(int $id): string
    {
        $project = $this->model->find($id);
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found.');
        }

        return view('layouts/main', [
            'title'    => 'Edit Project',
            'content'  => view('projects/form', ['project' => $project, 'servers' => (new ServerModel())->orderBy('name')->findAll()]),
            'projects' => $this->model->orderBy('name')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $project = $this->model->find($id);
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found.');
        }
        $this->model->update($id, $this->inputData());
        return redirect()->to('/projects/' . $id)->with('success', 'Project updated.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        (new CredentialModel())->where('project_id', $id)->delete();
        return redirect()->to('/projects')->with('success', 'Project deleted.');
    }

    private function inputData(): array
    {
        return [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'url'         => $this->request->getPost('url') ?: null,
            'server_id'   => $this->request->getPost('server_id') ?: null,
            'category'    => $this->request->getPost('category') ?: null,
            'tech_stack'  => $this->request->getPost('tech_stack') ?: null,
            'client_name'  => $this->request->getPost('client_name') ?: null,
            'client_email' => $this->request->getPost('client_email') ?: null,
            'client_phone' => $this->request->getPost('client_phone') ?: null,
            'color'       => $this->request->getPost('color') ?: '#7c6ff7',
            'status'      => $this->request->getPost('status') ?: 'active',
        ];
    }
}
