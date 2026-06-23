<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table         = 'wishlists';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = ['user_id', 'session_id', 'product_id', 'created_at'];

    public function getItems(string $sessionId, ?int $userId = null): array
    {
        $builder = $this->db->table('wishlists w')
            ->select('w.*, p.title, p.handle, p.price, p.compare_price, p.avg_rating, p.review_count,
                      (SELECT pm.path FROM product_media pm WHERE pm.product_id = p.id AND pm.is_cover = 1 LIMIT 1) as cover_image')
            ->join('products p', 'p.id = w.product_id')
            ->where('p.is_active', 1);

        if ($userId) {
            $builder->groupStart()->where('w.user_id', $userId)->orWhere('w.session_id', $sessionId)->groupEnd();
        } else {
            $builder->where('w.session_id', $sessionId);
        }

        return $builder->orderBy('w.created_at', 'DESC')->get()->getResultArray();
    }

    public function isWishlisted(int $productId, string $sessionId, ?int $userId = null): bool
    {
        $builder = $this->where('product_id', $productId);
        if ($userId) {
            $builder->groupStart()->where('user_id', $userId)->orWhere('session_id', $sessionId)->groupEnd();
        } else {
            $builder->where('session_id', $sessionId);
        }
        return $builder->countAllResults() > 0;
    }

    public function toggle(int $productId, string $sessionId, ?int $userId = null): bool
    {
        if ($this->isWishlisted($productId, $sessionId, $userId)) {
            $builder = $this->db->table('wishlists')->where('product_id', $productId);
            if ($userId) {
                $builder->groupStart()->where('user_id', $userId)->orWhere('session_id', $sessionId)->groupEnd();
            } else {
                $builder->where('session_id', $sessionId);
            }
            $builder->delete();
            return false; // removed
        }
        $this->insert(['user_id' => $userId, 'session_id' => $sessionId, 'product_id' => $productId, 'created_at' => date('Y-m-d H:i:s')]);
        return true; // added
    }

    public function getProductIds(string $sessionId, ?int $userId = null): array
    {
        $builder = $this->db->table('wishlists');
        if ($userId) {
            $builder->groupStart()->where('user_id', $userId)->orWhere('session_id', $sessionId)->groupEnd();
        } else {
            $builder->where('session_id', $sessionId);
        }
        return array_column($builder->select('product_id')->get()->getResultArray(), 'product_id');
    }
}
