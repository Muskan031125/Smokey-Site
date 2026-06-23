<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $rows = [
            ['key' => 'current_gold_rate', 'value' => '6200',                                                 'type' => 'number', 'label' => 'Current gold rate (per gram, 24K)'],
            ['key' => 'brand_name',        'value' => 'The Joharis',                                          'type' => 'string', 'label' => 'Brand name'],
            ['key' => 'brand_tagline',     'value' => 'A curated digital catalog of fine diamond jewellery.', 'type' => 'string', 'label' => 'Brand tagline'],
            ['key' => 'contact_email',     'value' => 'contact@joharis.local',                                'type' => 'string', 'label' => 'Contact email'],
            ['key' => 'region',            'value' => 'IN',                                                   'type' => 'string', 'label' => 'Region'],
            ['key' => 'currency',          'value' => 'INR',                                                  'type' => 'string', 'label' => 'Currency code'],
            ['key' => 'currency_symbol',   'value' => '₹',                                                    'type' => 'string', 'label' => 'Currency symbol'],
            ['key' => 'currency_decimals', 'value' => '0',                                                    'type' => 'number', 'label' => 'Currency decimals'],
            ['key' => 'date_format',       'value' => 'd M Y',                                                'type' => 'string', 'label' => 'Date format'],
            ['key' => 'time_format',       'value' => 'h:i A',                                                'type' => 'string', 'label' => 'Time format'],
            ['key' => 'timezone',          'value' => 'Asia/Kolkata',                                         'type' => 'string', 'label' => 'Timezone'],
        ];

        foreach ($rows as &$r) {
            $r['created_at'] = $now;
            $r['updated_at'] = $now;
        }

        $this->db->table('app_settings')->insertBatch($rows);
    }
}
