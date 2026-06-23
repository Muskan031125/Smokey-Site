<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfileFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'display_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
                'after'      => 'username',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'display_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['display_name', 'phone']);
    }
}
