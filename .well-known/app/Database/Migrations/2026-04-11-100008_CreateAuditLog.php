<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'actor_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'action'      => ['type' => 'VARCHAR', 'constraint' => 60],
            'entity_type' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'entity_id'   => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'details'     => ['type' => 'TEXT', 'null' => true],
            'ip'          => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('actor_id');
        $this->forge->addKey(['entity_type', 'entity_id']);
        $this->forge->createTable('audit_log');
    }

    public function down()
    {
        $this->forge->dropTable('audit_log');
    }
}
