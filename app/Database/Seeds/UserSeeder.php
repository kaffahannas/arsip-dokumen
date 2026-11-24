<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@example.com';

        $exists = $this->db->table('users')
            ->where('email', $email)
            ->countAllResults();

        if ($exists > 0) {
            return;
        }

        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'name'       => 'Administrator',
            'email'      => $email,
            'password'   => password_hash('Admin12345', PASSWORD_DEFAULT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
