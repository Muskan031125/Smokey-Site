<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table         = 'cart_sessions';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['session_id', 'user_id', 'product_id', 'quantity'];

    public function getCartItems(string $sessionId, ?int $userId = null): array
    {
        $builder = $this->db->table('cart_sessions cs')
            ->select('cs.*, p.title, p.handle, p.price, p.compare_price, p.is_in_stock, p.vendor,
                      (SELECT pm.path FROM product_media pm WHERE pm.product_id = p.id AND pm.is_cover = 1 LIMIT 1) as cover_image')
            ->join('products p', 'p.id = cs.product_id')
            ->where('p.is_active', 1)
            ->where('p.deleted_at IS NULL');

        if ($userId) {
            $builder->groupStart()
                ->where('cs.session_id', $sessionId)
                ->orWhere('cs.user_id', $userId)
                ->groupEnd();
        } else {
            $builder->where('cs.session_id', $sessionId);
        }

        return $builder->orderBy('cs.created_at', 'ASC')->get()->getResultArray();
    }

    public function addOrUpdate(string $sessionId, int $productId, int $qty, ?int $userId = null): void
    {
        $existing = $this->where('session_id', $sessionId)->where('product_id', $productId)->first();
        if ($existing) {
            $this->update($existing['id'], ['quantity' => $existing['quantity'] + $qty]);
        } else {
            $this->insert([
                'session_id' => $sessionId,
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => max(1, $qty),
            ]);
        }
    }

    public function setQuantity(string $sessionId, int $productId, int $qty): void
    {
        if ($qty <= 0) {
            $this->where('session_id', $sessionId)->where('product_id', $productId)->delete();
        } else {
            $this->where('session_id', $sessionId)->where('product_id', $productId)
                 ->set(['quantity' => $qty])->update();
        }
    }

    public function removeItem(string $sessionId, int $productId): void
    {
        $this->where('session_id', $sessionId)->where('product_id', $productId)->delete();
    }

    public function clearCart(string $sessionId, ?int $userId = null): void
    {
        $builder = $this->db->table('cart_sessions');
        if ($userId) {
            $builder->groupStart()
                ->where('session_id', $sessionId)
                ->orWhere('user_id', $userId)
                ->groupEnd();
        } else {
            $builder->where('session_id', $sessionId);
        }
        $builder->delete();
    }

    public function mergeGuestCart(string $sessionId, int $userId): void
    {
        $guestItems = $this->where('session_id', $sessionId)->where('user_id IS NULL')->findAll();
        foreach ($guestItems as $item) {
            $existing = $this->where('user_id', $userId)->where('product_id', $item['product_id'])->first();
            if ($existing) {
                $this->update($existing['id'], ['quantity' => $existing['quantity'] + $item['quantity']]);
                $this->delete($item['id']);
            } else {
                $this->update($item['id'], ['user_id' => $userId]);
            }
        }
    }

    public function countItems(string $sessionId, ?int $userId = null): int
    {
        $builder = $this->db->table('cart_sessions');
        if ($userId) {
            $builder->groupStart()
                ->where('session_id', $sessionId)
                ->orWhere('user_id', $userId)
                ->groupEnd();
        } else {
            $builder->where('session_id', $sessionId);
        }
        return (int)$builder->selectSum('quantity')->get()->getRow()->quantity;
    }
}
