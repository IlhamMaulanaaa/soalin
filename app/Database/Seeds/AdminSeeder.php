<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        $existing = $userModel->where('email', 'admin@soalin.com')->first();

        if ($existing) {
            echo "Admin already exists (email: admin@soalin.com)\n";
            return;
        }

        $userModel->insert([
            'name'     => 'Kepala Sekolah',
            'nama'     => 'Kepala Sekolah',
            'email'    => 'admin@soalin.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin',
        ]);

        echo "Admin created:\n";
        echo "  Email:    admin@soalin.com\n";
        echo "  Password: admin123\n";
        echo "  Role:     admin\n";
    }
}
