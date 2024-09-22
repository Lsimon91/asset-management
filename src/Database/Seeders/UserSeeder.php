<?php

namespace App\Database\Seeders;

use App\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'nombre' => 'Admin User',
                'email' => 'admin@example.com',
                'contraseña' => password_hash('admin123', PASSWORD_DEFAULT),
                'role_id' => 1
            ],
            [
                'nombre' => 'Operator User',
                'email' => 'operator@example.com',
                'contraseña' => password_hash('operator123', PASSWORD_DEFAULT),
                'role_id' => 2
            ],
            [
                'nombre' => 'Normal User',
                'email' => 'user@example.com',
                'contraseña' => password_hash('user123', PASSWORD_DEFAULT),
                'role_id' => 3
            ]
        ];

        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, contraseña, role_id) VALUES (:nombre, :email, :contraseña, :role_id)");

        foreach ($users as $user) {
            $stmt->execute($user);
        }
    }
}
