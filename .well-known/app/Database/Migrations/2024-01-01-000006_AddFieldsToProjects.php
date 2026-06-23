<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToProjects extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('projects', [
            'server_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'url'],
            'category'   => ['type' => 'VARCHAR', 'constraint' => 80,  'null' => true, 'after' => 'server_id'],
            'tech_stack' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'category'],
            'client_name'=> ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'tech_stack'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('projects', ['server_id', 'category', 'tech_stack', 'client_name']);
    }
}
