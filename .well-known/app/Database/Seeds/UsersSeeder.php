<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = new UserModel();

        $seeds = [
            [
                'username' => 'superadmin',
                'email'    => 'super@joharis.local',
                'password' => 'Super@123',
                'group'    => 'super_admin',
                'name'     => 'Super Admin',
            ],
            [
                'username' => 'inventory',
                'email'    => 'inventory@joharis.local',
                'password' => 'Inv@12345',
                'group'    => 'inventory_manager',
                'name'     => 'Inventory Manager',
            ],
            [
                'username' => 'client1',
                'email'    => 'client@joharis.local',
                'password' => 'Client@123',
                'group'    => 'client',
                'name'     => 'Approved Client',
            ],
        ];

        foreach ($seeds as $s) {
            $existing = $users->findByCredentials(['email' => $s['email']]);
            if ($existing) {
                continue;
            }

            $user = new User([
                'username' => $s['username'],
                'email'    => $s['email'],
                'password' => $s['password'],
            ]);
            $users->save($user);

            $user = $users->findById($users->getInsertID());
            $user->addGroup($s['group']);

            // Activate immediately (skip email verification)
            $user->activate();
        }
    }
}
