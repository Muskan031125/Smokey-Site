<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'handle', 'title', 'category_id', 'vendor', 'sku', 'description',
        'tags', 'price', 'compare_price', 'cost_price', 'inventory_qty',
        'size', 'colour', 'colour_hex', 'material', 'is_in_stock', 'is_active',
        'is_new_arrival', 'is_best_seller', 'is_featured', 'avg_rating', 'review_count',
    ];

    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'price' => 'required|numeric',
    ];

    public function getWithCategory(int $id): ?array
    {
        return $this->db->table('products p')
            ->select('p.*, c.name as category_name, c.slug as category_slug')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('p.id', $id)->where('p.deleted_at IS NULL')
            ->get()->getRowArray();
    }

    public function getByHandle(string $handle): ?array
    {
        return $this->db->table('products p')
            ->select('p.*, c.name as category_name, c.slug as category_slug')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('p.handle', $handle)->where('p.is_active', 1)->where('p.deleted_at IS NULL')
            ->get()->getRowArray();
    }

    public function listPublic(array $filters = [], int $limit = 24, int $offset = 0): array
    {
        $builder = $this->_publicBuilder($filters);
        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countPublic(array $filters = []): int
    {
        return (int)$this->_publicBuilder($filters)->countAllResults();
    }

    private function _publicBuilder(array $filters): \CodeIgniter\Database\BaseBuilder
    {
        $builder = $this->db->table('products p')
            ->select('p.*, c.name as category_name, c.slug as category_slug,
                      (SELECT pm.path FROM product_media pm WHERE pm.product_id = p.id AND pm.is_cover = 1 LIMIT 1) as cover_image')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('p.is_active', 1)->where('p.deleted_at IS NULL');

        if (!empty($filters['category_id'])) {
            $builder->where('p.category_id', (int)$filters['category_id']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('p.title', $filters['search'])
                ->orLike('p.tags', $filters['search'])
                ->orLike('p.vendor', $filters['search'])
                ->orLike('p.description', $filters['search'])
                ->groupEnd();
        }
        if (!empty($filters['colour'])) {
            $builder->like('p.colour', $filters['colour']);
        }
        if (!empty($filters['min_price'])) {
            $builder->where('p.price >=', (float)$filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $builder->where('p.price <=', (float)$filters['max_price']);
        }
        if (!empty($filters['in_stock'])) {
            $builder->where('p.is_in_stock', 1);
        }
        if (!empty($filters['on_sale'])) {
            $builder->where('p.compare_price > p.price');
        }
        if (!empty($filters['flag'])) {
            $col = 'p.is_' . $filters['flag'];
            $allowed = ['p.is_new_arrival', 'p.is_best_seller', 'p.is_featured'];
            if (in_array($col, $allowed)) {
                $builder->where($col, 1);
            }
        }

        // Sort
        $sort = $filters['sort'] ?? 'newest';
        match($sort) {
            'price_asc'   => $builder->orderBy('p.price', 'ASC'),
            'price_desc'  => $builder->orderBy('p.price', 'DESC'),
            'alpha_asc'   => $builder->orderBy('p.title', 'ASC'),
            'alpha_desc'  => $builder->orderBy('p.title', 'DESC'),
            'top_rated'   => $builder->orderBy('p.avg_rating', 'DESC')->orderBy('p.review_count', 'DESC'),
            'best_selling'=> $builder->orderBy('p.is_best_seller', 'DESC')->orderBy('p.created_at', 'DESC'),
            default       => $builder->orderBy('p.created_at', 'DESC'),
        };

        return $builder;
    }

    public function listAdmin(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->_adminBuilder($filters);
        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countAdmin(array $filters = []): int
    {
        return (int)$this->_adminBuilder($filters)->countAllResults();
    }

    private function _adminBuilder(array $filters): \CodeIgniter\Database\BaseBuilder
    {
        $builder = $this->db->table('products p')
            ->select('p.*, c.name as category_name,
                      (SELECT pm.path FROM product_media pm WHERE pm.product_id = p.id AND pm.is_cover = 1 LIMIT 1) as cover_image')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('p.deleted_at IS NULL')
            ->orderBy('p.created_at', 'DESC');

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('p.title', $filters['search'])
                ->orLike('p.sku', $filters['search'])
                ->orLike('p.handle', $filters['search'])
                ->groupEnd();
        }
        if (!empty($filters['category_id'])) {
            $builder->where('p.category_id', (int)$filters['category_id']);
        }
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $builder->where('p.is_active', (int)$filters['is_active']);
        }

        return $builder;
    }

    public function getDistinctColours(): array
    {
        $rows = $this->db->query(
            "SELECT DISTINCT colour FROM products WHERE colour IS NOT NULL AND colour != '' AND is_active = 1 AND deleted_at IS NULL ORDER BY colour ASC"
        )->getResultArray();
        return array_filter(array_column($rows, 'colour'));
    }

    public function generateHandle(string $title): string
    {
        $handle = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));
        $base   = $handle; $i = 1;
        while ($this->where('handle', $handle)->withDeleted()->first()) {
            $handle = $base . '-' . $i++;
        }
        return $handle;
    }
}
