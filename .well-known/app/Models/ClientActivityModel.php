<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientActivityModel extends Model
{
    protected $table            = 'client_activity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'action', 'entity_type', 'entity_id', 'entity_label',
        'path', 'ip', 'user_agent',
    ];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    /**
     * Record a client action. Safe-fails silently.
     */
    public function record(int $userId, string $action, ?string $entityType = null, $entityId = null, ?string $entityLabel = null): void
    {
        try {
            $request = service('request');
            $this->insert([
                'user_id'      => $userId,
                'action'       => $action,
                'entity_type'  => $entityType,
                'entity_id'    => $entityId !== null ? (string) $entityId : null,
                'entity_label' => $entityLabel,
                'path'         => substr((string) $request->getUri()->getPath(), 0, 255),
                'ip'           => $request->getIPAddress(),
                'user_agent'   => substr((string) $request->getUserAgent(), 0, 255),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ClientActivity record failed: ' . $e->getMessage());
        }
    }

    public function forUser(int $userId, int $limit = 50): array
    {
        // Use a fresh query builder each call to avoid contamination
        return $this->db->table($this->table)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function statsForUser(int $userId): array
    {
        $db = $this->db;
        $tbl = $this->table;
        $total      = $db->table($tbl)->where('user_id', $userId)->countAllResults();
        $categories = $db->table($tbl)->where('user_id', $userId)->where('action', 'category.view')->countAllResults();
        $products   = $db->table($tbl)->where('user_id', $userId)->where('action', 'product.view')->countAllResults();
        $lastSeen   = $db->table($tbl)->selectMax('created_at', 'last')->where('user_id', $userId)->get()->getRowArray()['last'] ?? null;

        return [
            'total'      => $total,
            'categories' => $categories,
            'products'   => $products,
            'last_seen'  => $lastSeen,
        ];
    }
}
