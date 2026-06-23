<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $rows = [
            ['name' => 'Rings',     'slug' => 'rings',     'description' => 'Solitaires, bands, and statement rings.',        'sort_order' => 1],
            ['name' => 'Earrings',  'slug' => 'earrings',  'description' => 'Studs, drops, and ear cuffs.',                    'sort_order' => 2],
            ['name' => 'Necklaces', 'slug' => 'necklaces', 'description' => 'Delicate chains to layered statements.',          'sort_order' => 3],
            ['name' => 'Pendants',  'slug' => 'pendants',  'description' => 'Solitaire pendants and charm pieces.',            'sort_order' => 4],
            ['name' => 'Bracelets', 'slug' => 'bracelets', 'description' => 'Tennis, link, and charm bracelets.',              'sort_order' => 5],
            ['name' => 'Bangles',   'slug' => 'bangles',   'description' => 'Classic and contemporary bangles.',               'sort_order' => 6],
        ];

        foreach ($rows as &$r) {
            $r['is_active']  = 1;
            $r['created_at'] = $now;
            $r['updated_at'] = $now;
        }

        $this->db->table('categories')->insertBatch($rows);
    }
}
