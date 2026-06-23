<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductVariants extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id'     => ['type' => 'INT', 'unsigned' => true],
            'option_name'    => ['type' => 'VARCHAR', 'constraint' => 50, 'comment' => 'e.g. Color, Size'],
            'option_value'   => ['type' => 'VARCHAR', 'constraint' => 100, 'comment' => 'e.g. Black, Large'],
            'price_modifier' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0, 'comment' => 'Added to base price'],
            'sku_suffix'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'stock_qty'      => ['type' => 'INT', 'default' => 0],
            'sort_order'     => ['type' => 'INT', 'default' => 0],
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_variants');

        // Add colour column to products for quick filter
        $this->forge->addColumn('products', [
            'colour_hex' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'colour',
                'comment'    => 'Hex colour for filter swatch',
            ],
            'is_new_arrival' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_active',
            ],
            'is_best_seller' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_new_arrival',
            ],
            'is_featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'is_best_seller',
            ],
            'avg_rating' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'default'    => 0,
                'after'      => 'is_featured',
            ],
            'review_count' => [
                'type'    => 'INT',
                'default' => 0,
                'after'   => 'avg_rating',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('product_variants');
        $this->forge->dropColumn('products', ['colour_hex', 'is_new_arrival', 'is_best_seller', 'is_featured', 'avg_rating', 'review_count']);
    }
}
