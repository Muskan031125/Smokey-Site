<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUrlToProjects extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('projects', [
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'description',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('projects', 'url');
    }
}
