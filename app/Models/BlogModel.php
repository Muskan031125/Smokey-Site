<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table         = 'blog_posts';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['slug', 'title', 'excerpt', 'body', 'cover_image', 'author', 'is_published', 'published_at'];

    public function getPublished(int $limit = 3, int $offset = 0): array
    {
        return $this->where('is_published', 1)
            ->orderBy('published_at', 'DESC')
            ->limit($limit, $offset)->findAll();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_published', 1)->first();
    }

    public function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));
        $base = $slug; $i = 1;
        while ($this->where('slug', $slug)->first()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
