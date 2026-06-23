<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductStoneModel extends Model
{
    protected $table            = 'product_stones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'position', 'name', 'pieces', 'weight', 'rate'];
    protected $useTimestamps    = true;
}
