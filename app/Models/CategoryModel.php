<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'slug', 'description', 'cover_image', 'sort_order', 'is_active'];
    protected $useTimestamps    = true;

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'slug' => 'required|alpha_dash|max_length[120]',
    ];

    public function activeOrdered(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'asc')->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }

    public function withProductCounts(): array
    {
        $builder = $this->db->table($this->table . ' c');
        $builder->select('c.*, COUNT(p.id) as product_count');
        $builder->join('products p', 'p.category_id = c.id AND p.is_active = 1 AND p.deleted_at IS NULL', 'left');
        $builder->groupBy('c.id');
        $builder->orderBy('c.sort_order', 'ASC');
        return $builder->get()->getResultArray();
    }
}
