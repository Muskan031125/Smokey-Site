<?php

namespace App\Controllers;

use App\Models\CredentialModel;
use App\Models\ProjectModel;

class Credentials extends BaseController
{
    private CredentialModel $model;

    public function __construct()
    {
        $this->model = new CredentialModel();
    }

    public function create(int $projectId): string
    {
        $projectModel = new ProjectModel();
        $project      = $projectModel->find($projectId);
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found.');
        }

        return view('layouts/main', [
            'title'    => 'Add Credential',
            'content'  => view('credentials/form', ['credential' => null, 'project' => $project]),
            'projects' => $projectModel->orderBy('name')->findAll(),
        ]);
    }

    public function store()
    {
        $data = [
            'project_id' => (int) $this->request->getPost('project_id'),
            'label'      => $this->request->getPost('label'),
            'url'        => $this->request->getPost('url'),
            'username'   => $this->request->getPost('username'),
            'password'   => $this->request->getPost('password'),
            'notes'      => $this->request->getPost('notes'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to("/projects/{$data['project_id']}")->with('success', 'Credential added.');
    }

    public function edit(int $id): string
    {
        $credential = $this->model->find($id);
        if (!$credential) {
            return redirect()->to('/projects')->with('error', 'Credential not found.');
        }

        $projectModel = new ProjectModel();
        $project      = $projectModel->find($credential['project_id']);

        return view('layouts/main', [
            'title'    => 'Edit Credential',
            'content'  => view('credentials/form', compact('credential', 'project')),
            'projects' => $projectModel->orderBy('name')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $credential = $this->model->find($id);
        if (!$credential) {
            return redirect()->to('/projects')->with('error', 'Credential not found.');
        }

        $data = [
            'label'    => $this->request->getPost('label'),
            'url'      => $this->request->getPost('url'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'notes'    => $this->request->getPost('notes'),
        ];

        $this->model->update($id, $data);
        return redirect()->to("/projects/{$credential['project_id']}")->with('success', 'Credential updated.');
    }

    public function delete(int $id)
    {
        $credential = $this->model->find($id);
        $projectId  = $credential['project_id'] ?? null;
        $this->model->delete($id);
        return redirect()->to($projectId ? "/projects/{$projectId}" : '/projects')->with('success', 'Credential deleted.');
    }
}
