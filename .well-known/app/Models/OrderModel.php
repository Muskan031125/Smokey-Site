<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'order_number', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'address_line1', 'address_line2', 'city', 'state', 'pincode',
        'subtotal', 'total', 'status', 'notes',
    ];

    public function generateOrderNumber(): string
    {
        return 'SMK-' . strtoupper(substr(uniqid(), -6)) . '-' . date('Ymd');
    }

    public function getWithItems(int $id): ?array
    {
        $order = $this->find($id);
        if (!$order) return null;
        $order['items'] = $this->db->table('order_items oi')
            ->select('oi.*, p.handle,
                      (SELECT pm.path FROM product_media pm WHERE pm.product_id = oi.product_id AND pm.is_cover = 1 LIMIT 1) as cover_image')
            ->join('products p', 'p.id = oi.product_id', 'left')
            ->where('oi.order_id', $id)
            ->get()->getResultArray();
        return $order;
    }

    public function listAdmin(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->db->table('orders')
            ->orderBy('created_at', 'DESC');

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('order_number', $filters['search'])
                ->orLike('customer_name', $filters['search'])
                ->orLike('customer_email', $filters['search'])
                ->groupEnd();
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countAdmin(array $filters = []): int
    {
        $builder = $this->db->table('orders');
        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('order_number', $filters['search'])
                ->orLike('customer_name', $filters['search'])
                ->orLike('customer_email', $filters['search'])
                ->groupEnd();
        }
        return (int)$builder->countAllResults();
    }

    public function placeOrder(array $data, array $items): int
    {
        $this->db->transStart();

        $orderId = $this->insert($data, true);

        foreach ($items as $item) {
            $this->db->table('order_items')->insert([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'title'      => $item['title'],
                'sku'        => $item['sku'] ?? null,
                'price'      => $item['price'],
                'quantity'   => $item['quantity'],
                'subtotal'   => $item['price'] * $item['quantity'],
            ]);
        }

        $this->db->transComplete();
        return $orderId;
    }
}
