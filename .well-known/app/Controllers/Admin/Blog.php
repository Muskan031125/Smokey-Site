<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Blog extends BaseController
{
    public function index(): string
    {
        $model = new BlogModel();
        $posts = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/blog/index', ['title' => 'Blog — Smokey Admin', 'posts' => $posts]);
    }

    public function create(): string
    {
        return view('admin/blog/form', ['title' => 'New Post — Smokey Admin', 'post' => null]);
    }

    public function store()
    {
        $model = new BlogModel();
        $data  = $this->request->getPost(['title', 'excerpt', 'body', 'author']);
        $data['slug']         = $model->generateSlug($data['title']);
        $data['is_published'] = $this->request->getPost('is_published') ? 1 : 0;
        $data['published_at'] = $data['is_published'] ? date('Y-m-d H:i:s') : null;

        // Handle cover image upload
        $img = $this->request->getFile('cover_image');
        if ($img && $img->isValid()) {
            $name = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/blog/', $name);
            $data['cover_image'] = 'uploads/blog/' . $name;
        }

        $model->insert($data);
        return redirect()->to(site_url('admin/blog'))->with('success', 'Post created.');
    }

    public function edit(int $id): string
    {
        $post = (new BlogModel())->find($id);
        if (!$post) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('admin/blog/form', ['title' => 'Edit Post — Smokey Admin', 'post' => $post]);
    }

    public function update(int $id)
    {
        $model = new BlogModel();
        $data  = $this->request->getPost(['title', 'excerpt', 'body', 'author']);
        $data['is_published'] = $this->request->getPost('is_published') ? 1 : 0;
        if ($data['is_published']) {
            $existing = $model->find($id);
            if (!$existing['published_at']) $data['published_at'] = date('Y-m-d H:i:s');
        }
        $img = $this->request->getFile('cover_image');
        if ($img && $img->isValid()) {
            $name = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/blog/', $name);
            $data['cover_image'] = 'uploads/blog/' . $name;
        }
        $model->update($id, $data);
        return redirect()->to(site_url('admin/blog'))->with('success', 'Post updated.');
    }

    public function delete(int $id)
    {
        (new BlogModel())->delete($id);
        return redirect()->to(site_url('admin/blog'))->with('success', 'Post deleted.');
    }
}
