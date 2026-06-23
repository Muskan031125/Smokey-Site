<?php

namespace App\Models;

use CodeIgniter\Model;

class ServerModel extends Model
{
    protected $table         = 'servers';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'provider', 'ip_address', 'location', 'plan', 'panel_url', 'login_email', 'login_password', 'notes', 'status'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[150]',
    ];
}
