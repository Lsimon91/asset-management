<?php

namespace App\Models;

class Usuario extends Model
{
    protected $table = 'usuarios';

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
        return parent::create($data);
    }

    public function update($id, $data)
    {
        if (isset($data['contraseña'])) {
            $data['contraseña'] = password_hash($data['contraseña'], PASSWORD_DEFAULT);
        }
        return parent::update($id, $data);
    }
}
