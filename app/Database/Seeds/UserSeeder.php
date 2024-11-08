<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email'    => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'     => 'admin',
            ],
            [
                'email'    => 'user@example.com',
                'password' => password_hash('user123', PASSWORD_BCRYPT),
                'role'     => 'user',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
