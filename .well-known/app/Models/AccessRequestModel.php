<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessRequestModel extends Model
{
    protected $table            = 'access_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'name', 'email', 'phone', 'company',
        'address_line1', 'address_line2', 'city', 'state', 'postal_code', 'country',
        'business_type', 'gst_number', 'website', 'referred_by',
        'message',
        'status', 'reviewed_by', 'reviewed_at', 'user_id',
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name'          => 'required|min_length[2]|max_length[120]',
        'email'         => 'required|valid_email|max_length[160]',
        'phone'         => 'required|max_length[30]',
        'company'       => 'permit_empty|max_length[160]',
        'address_line1' => 'permit_empty|max_length[200]',
        'address_line2' => 'permit_empty|max_length[200]',
        'city'          => 'permit_empty|max_length[100]',
        'state'         => 'permit_empty|max_length[100]',
        'postal_code'   => 'permit_empty|max_length[20]',
        'country'       => 'permit_empty|max_length[100]',
        'business_type' => 'permit_empty|max_length[100]',
        'gst_number'    => 'permit_empty|max_length[50]',
        'website'       => 'permit_empty|max_length[255]',
        'referred_by'   => 'permit_empty|max_length[200]',
        'message'       => 'permit_empty|max_length[2000]',
    ];

    public function pending(): array
    {
        return $this->where('status', 'pending')->orderBy('created_at', 'desc')->findAll();
    }

    public function pendingCount(): int
    {
        return $this->where('status', 'pending')->countAllResults();
    }
}
