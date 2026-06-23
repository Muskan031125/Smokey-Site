<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClientFieldsToProjects extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('projects', [
            'client_email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'client_name'],
            'client_phone' => ['type' => 'VARCHAR', 'constraint' => 30,  'null' => true, 'after' => 'client_email'],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('projects', ['client_email', 'client_phone']);
    }
}
