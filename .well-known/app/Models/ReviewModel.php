<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table         = 'product_reviews';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['product_id', 'user_id', 'name', 'email', 'rating', 'title', 'body', 'is_approved'];

    public function getApproved(int $productId): array
    {
        return $this->where('product_id', $productId)->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')->findAll();
    }

    public function getRatingStats(int $productId): array
    {
        $rows = $this->db->table('product_reviews')
            ->select('rating, COUNT(*) as cnt')
            ->where('product_id', $productId)->where('is_approved', 1)
            ->groupBy('rating')->get()->getResultArray();

        $stats = ['avg' => 0, 'count' => 0, 'breakdown' => [5=>0,4=>0,3=>0,2=>0,1=>0]];
        $total = 0; $sum = 0;
        foreach ($rows as $r) {
            $stats['breakdown'][(int)$r['rating']] = (int)$r['cnt'];
            $total += (int)$r['cnt'];
            $sum   += (int)$r['rating'] * (int)$r['cnt'];
        }
        $stats['count'] = $total;
        $stats['avg']   = $total > 0 ? round($sum / $total, 1) : 0;
        return $stats;
    }

    public function recalcProduct(int $productId): void
    {
        $stats = $this->getRatingStats($productId);
        $this->db->table('products')->where('id', $productId)->update([
            'avg_rating'   => $stats['avg'],
            'review_count' => $stats['count'],
        ]);
    }

    public function listAdmin(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->db->table('product_reviews r')
            ->select('r.*, p.title as product_title, p.handle')
            ->join('products p', 'p.id = r.product_id', 'left')
            ->orderBy('r.created_at', 'DESC');

        if (isset($filters['is_approved']) && $filters['is_approved'] !== '') {
            $builder->where('r.is_approved', (int)$filters['is_approved']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()->like('r.name', $filters['search'])->orLike('p.title', $filters['search'])->groupEnd();
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countAdmin(array $filters = []): int
    {
        $builder = $this->db->table('product_reviews r')
            ->join('products p', 'p.id = r.product_id', 'left');

        if (isset($filters['is_approved']) && $filters['is_approved'] !== '') {
            $builder->where('r.is_approved', (int)$filters['is_approved']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()->like('r.name', $filters['search'])->orLike('p.title', $filters['search'])->groupEnd();
        }

        return (int)$builder->countAllResults();
    }
}
