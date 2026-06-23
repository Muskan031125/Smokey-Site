<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['actor_id', 'action', 'entity_type', 'entity_id', 'details', 'ip'];
    protected $useTimestamps    = true;
    protected $updatedField     = '';

    public function log(string $action, ?string $entityType = null, $entityId = null, $details = null): void
    {
        $user = auth()->user();
        $this->insert([
            'actor_id'    => $user?->id,
            'action'      => $action,
            'entity_type' => $entityType,
            'entity_id'   => $entityId !== null ? (string) $entityId : null,
            'details'     => is_array($details) || is_object($details) ? json_encode($details) : $details,
            'ip'          => service('request')->getIPAddress(),
        ]);
    }

    public function recent(int $limit = 20): array
    {
        return $this->orderBy('created_at', 'desc')->limit($limit)->findAll();
    }
}
