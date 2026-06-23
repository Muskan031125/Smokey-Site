<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'description', 'url', 'server_id', 'category', 'tech_stack', 'client_name', 'client_email', 'client_phone', 'color', 'status'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
    ];

    protected $validationMessages = [
        'name' => ['required' => 'Project name is required.'],
    ];
}
