<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWishlists extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'session_id' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['user_id', 'product_id']);
        $this->forge->addKey(['session_id', 'product_id']);
        $this->forge->createTable('wishlists');
    }

    public function down()
    {
        $this->forge->dropTable('wishlists');
    }
}
