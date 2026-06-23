<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'app_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['key', 'value', 'type', 'label', 'updated_by'];
    protected $useTimestamps    = true;

    /** Fetch a single setting value by key, with an optional fallback. */
    public function get(string $key, $default = null)
    {
        $row = $this->where('key', $key)->first();
        return $row['value'] ?? $default;
    }

    /** Upsert a single setting value. */
    public function put(string $key, $value, ?int $updatedBy = null): void
    {
        $row = $this->where('key', $key)->first();
        if ($row) {
            $this->update($row['id'], ['value' => (string) $value, 'updated_by' => $updatedBy]);
        } else {
            $this->insert([
                'key'        => $key,
                'value'      => (string) $value,
                'type'       => 'string',
                'updated_by' => $updatedBy,
            ]);
        }
    }

    /** Return all settings keyed by "key" → row. */
    public function all(): array
    {
        $out = [];
        foreach ($this->findAll() as $row) {
            $out[$row['key']] = $row;
        }
        return $out;
    }

    public function currentGoldRate(): float
    {
        static $rate = null;
        if ($rate === null) {
            $rate = (float) ($this->get('current_gold_rate', 0));
        }
        return $rate;
    }

    /**
     * Global price multiplier applied to every SKU's final total.
     * Defaults to 1 (no change) when unset or invalid, so existing
     * prices are unaffected until a multiplier is entered.
     */
    public function currentPriceMultiplier(): float
    {
        static $mult = null;
        if ($mult === null) {
            $mult = (float) ($this->get('price_multiplier', 1));
            if ($mult <= 0) {
                $mult = 1.0;
            }
        }
        return $mult;
    }
}
