<?php

namespace App\Models;

use CodeIgniter\Model;

class CredentialModel extends Model
{
    protected $table            = 'credentials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['project_id', 'label', 'url', 'username', 'password', 'notes'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'project_id' => 'required|integer',
        'label'      => 'required|min_length[2]|max_length[255]',
        'url'        => 'permit_empty|valid_url_strict|max_length[500]',
    ];

    public function getByProject(int $projectId): array
    {
        return $this->where('project_id', $projectId)->findAll();
    }
}
