<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductMedia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'type'       => ['type' => 'ENUM', 'constraint' => ['image', 'video'], 'default' => 'image'],
            'path'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_cover'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_media');
    }

    public function down()
    {
        $this->forge->dropTable('product_media');
    }
}
