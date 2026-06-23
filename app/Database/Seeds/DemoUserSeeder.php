<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'name'       => 'Demo User',
            'email'      => 'demo@crm.local',
            'password'   => password_hash('demo@123', PASSWORD_BCRYPT),
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Only insert if not already exists
        $exists = $this->db->table('users')->where('email', 'demo@crm.local')->countAllResults();
        if (!$exists) {
            $this->db->table('users')->insert($data);
            echo "Demo user created: demo@crm.local / demo@123\n";
        } else {
            echo "Demo user already exists.\n";
        }
    }
}
