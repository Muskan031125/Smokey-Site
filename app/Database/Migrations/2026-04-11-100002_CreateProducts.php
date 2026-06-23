<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'handle'        => ['type' => 'VARCHAR', 'constraint' => 255, 'comment' => 'URL slug'],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'category_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'vendor'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sku'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'tags'          => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'price'         => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'compare_price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'cost_price'    => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'inventory_qty' => ['type' => 'INT', 'default' => 0],
            'size'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'colour'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'material'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_in_stock'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('handle');
        $this->forge->addKey('category_id');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
