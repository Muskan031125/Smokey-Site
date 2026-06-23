<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Category slug -> id map
        $cats = [];
        foreach ($this->db->table('categories')->get()->getResultArray() as $c) {
            $cats[$c['slug']] = (int) $c['id'];
        }

        // Sample SKUs adapted from the scope document's attribute set.
        // Numbers are realistic placeholders for seeding only.
        $products = [
            [
                'tag_no'      => 'LR1802',
                'category'    => 'rings',
                'trt'         => 'Rhodium',
                'gr_wt'       => 4.250,
                'purity'      => 0.750,
                'net_wt'      => 3.850,
                'labour'      => 2500.00,
                'size'        => '14',
                'colour'      => 'White',
                'description' => 'Classic solitaire ladies ring in 18K white gold.',
                'diamonds'    => [
                    ['position' => 1, 'carat' => 0.480, 'rate' => 185000, 'colour' => 'F', 'clarity' => 'VS1', 'cut' => 'Round Brilliant'],
                ],
            ],
            [
                'tag_no'      => 'ER1845',
                'category'    => 'earrings',
                'trt'         => 'Rhodium',
                'gr_wt'       => 3.180,
                'purity'      => 0.750,
                'net_wt'      => 2.720,
                'labour'      => 1800.00,
                'size'        => null,
                'colour'      => 'White',
                'description' => 'Pair of solitaire stud earrings.',
                'diamonds'    => [
                    ['position' => 1, 'carat' => 0.310, 'rate' => 160000, 'colour' => 'G', 'clarity' => 'VS2', 'cut' => 'Round'],
                    ['position' => 2, 'carat' => 0.310, 'rate' => 160000, 'colour' => 'G', 'clarity' => 'VS2', 'cut' => 'Round'],
                ],
            ],
            [
                'tag_no'      => 'ER1906',
                'category'    => 'earrings',
                'trt'         => null,
                'gr_wt'       => 5.100,
                'purity'      => 0.750,
                'net_wt'      => 4.300,
                'labour'      => 3200.00,
                'size'        => null,
                'colour'      => 'Yellow',
                'description' => 'Floral cluster drop earrings in 18K yellow gold.',
                'diamonds'    => [
                    ['position' => 1, 'carat' => 0.620, 'rate' => 170000, 'colour' => 'G', 'clarity' => 'SI1', 'cut' => 'Round'],
                ],
            ],
            [
                'tag_no'      => 'BR315',
                'category'    => 'bracelets',
                'trt'         => 'Rhodium',
                'gr_wt'       => 12.400,
                'purity'      => 0.750,
                'net_wt'      => 10.850,
                'labour'      => 7500.00,
                'size'        => '6.5 in',
                'colour'      => 'White',
                'description' => 'Tennis bracelet with micro-pave diamonds.',
                'diamonds'    => [
                    ['position' => 1, 'carat' => 1.850, 'rate' => 155000, 'colour' => 'H', 'clarity' => 'SI1', 'cut' => 'Round'],
                ],
            ],
            [
                'tag_no'      => 'BR326',
                'category'    => 'bangles',
                'trt'         => null,
                'gr_wt'       => 18.750,
                'purity'      => 0.750,
                'net_wt'      => 16.200,
                'labour'      => 9800.00,
                'size'        => '2.4',
                'colour'      => 'Yellow',
                'description' => 'Hinged bangle with diamond accents.',
                'diamonds'    => [
                    ['position' => 1, 'carat' => 0.950, 'rate' => 150000, 'colour' => 'H', 'clarity' => 'VS2', 'cut' => 'Round'],
                ],
            ],
        ];

        foreach ($products as $p) {
            $diamonds = $p['diamonds'];
            unset($p['diamonds']);

            $slug = $p['category'];
            unset($p['category']);
            if (!isset($cats[$slug])) {
                continue;
            }

            $p['category_id'] = $cats[$slug];
            $p['is_in_stock'] = 1;
            $p['is_active']   = 1;
            $p['created_at']  = $now;
            $p['updated_at']  = $now;

            $this->db->table('products')->insert($p);
            $productId = $this->db->insertID();

            foreach ($diamonds as $d) {
                $d['product_id'] = $productId;
                $d['created_at'] = $now;
                $d['updated_at'] = $now;
                $this->db->table('product_diamonds')->insert($d);
            }
        }
    }
}
