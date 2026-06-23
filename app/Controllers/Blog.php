<?php

namespace App\Controllers;

use App\Models\BlogModel;

class Blog extends BaseController
{
    public function index(): string
    {
        $model = new BlogModel();
        $page  = max(1, (int)$this->request->getGet('page'));
        $posts = $model->getPublished(9, ($page - 1) * 9);
        $total = $model->where('is_published', 1)->countAllResults();

        return view('public/blog/index', [
            'title'  => 'Blog — ' . brand_setting('site_name'),
            'posts'  => $posts,
            'total'  => $total,
            'page'   => $page,
        ]);
    }

    public function show(string $slug): string
    {
        $model = new BlogModel();
        $post  = $model->getBySlug($slug);
        if (!$post) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('public/blog/show', [
            'title'    => $post['title'] . ' — ' . brand_setting('site_name'),
            'post'     => $post,
            'related'  => $model->getPublished(3),
        ]);
    }
}
