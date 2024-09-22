<?php

use PHPUnit\Framework\TestCase;
use App\Models\Usuario;

class UsuarioTest extends TestCase
{
    private $usuario;

    protected function setUp(): void
    {
        $this->usuario = new Usuario();
    }

    public function testCreateUser()
    {
        $data = [
            'nombre' => 'Test User',
            'email' => 'test@example.com',
            'contraseña' => 'password123',
            'role_id' => 3
        ];

        $userId = $this->usuario->create($data);

        $this->assertIsInt($userId);
        $this->assertGreaterThan(0, $userId);

        $createdUser = $this->usuario->findById($userId);
        $this->assertEquals($data['nombre'], $createdUser['nombre']);
        $this->assertEquals($data['email'], $createdUser['email']);
        $this->assertTrue(password_verify($data['contraseña'], $createdUser['contraseña']));
        $this->assertEquals($data['role_id'], $createdUser['role_id']);
    }

    // Añade más pruebas según sea necesario
}