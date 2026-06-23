<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServersTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'provider'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'ip_address'   => ['type' => 'VARCHAR', 'constraint' => 60,  'null' => true],
            'location'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'plan'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'panel_url'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'login_email'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'login_password' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'notes'        => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('servers');
    }

    public function down(): void
    {
        $this->forge->dropTable('servers');
    }
}
