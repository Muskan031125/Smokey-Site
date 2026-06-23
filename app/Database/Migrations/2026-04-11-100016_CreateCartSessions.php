<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartSessions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'session_id' => ['type' => 'VARCHAR', 'constraint' => 128],
            'user_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'quantity'   => ['type' => 'INT', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('session_id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('cart_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('cart_sessions');
    }
}
