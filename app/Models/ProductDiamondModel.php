<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductDiamondModel extends Model
{
    protected $table            = 'product_diamonds';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'position', 'carat', 'rate', 'colour', 'clarity', 'cut', 'pieces', 'shape'];
    protected $useTimestamps    = true;
}
