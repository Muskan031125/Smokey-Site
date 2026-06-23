<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductMediaModel extends Model
{
    protected $table            = 'product_media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'type', 'path', 'sort_order', 'is_cover'];
    protected $useTimestamps    = true;

    public function forProduct(int $productId): array
    {
        return $this->where('product_id', $productId)
            ->orderBy('is_cover', 'desc')
            ->orderBy('sort_order', 'asc')
            ->findAll();
    }

    public function clearCoverFor(int $productId): void
    {
        $this->where('product_id', $productId)->set(['is_cover' => 0])->update();
    }
}
