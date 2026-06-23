<?php

namespace App\Models;

use CodeIgniter\Model;

class FavouriteModel extends Model
{
    protected $table            = 'client_favourites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'product_id'];
    protected $useTimestamps    = true;
    protected $updatedField     = '';

    /** Count favourites for a given user. Safe-fails to 0. */
    public function countForUser(?int $userId): int
    {
        if (!$userId) return 0;
        try {
            return $this->db->table($this->table)->where('user_id', $userId)->countAllResults();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public function isFavourite(int $userId, int $productId): bool
    {
        $row = $this->db->table($this->table)
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->limit(1)
            ->get()
            ->getRowArray();
        return !empty($row);
    }

    /**
     * Toggle a favourite. Returns 'added' or 'removed'.
     */
    public function toggle(int $userId, int $productId): string
    {
        $existing = $this->db->table($this->table)
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($existing) {
            $this->db->table($this->table)->where('id', $existing['id'])->delete();
            return 'removed';
        }

        $this->insert(['user_id' => $userId, 'product_id' => $productId]);
        return 'added';
    }

    /**
     * Return all favourited products for a user, joined with category and cover media.
     */
    public function forUser(int $userId): array
    {
        return $this->db->table($this->table . ' f')
            ->select('f.id as fav_id, f.created_at as fav_created_at, p.*, c.name as category_name, c.slug as category_slug, c.cover_image as category_cover')
            ->join('products p', 'p.id = f.product_id', 'inner')
            ->join('categories c', 'c.id = p.category_id', 'left')
            ->where('f.user_id', $userId)
            ->where('p.is_active', 1)
            ->where('p.deleted_at', null)
            ->orderBy('f.created_at', 'desc')
            ->get()
            ->getResultArray();
    }
}
