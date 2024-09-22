<?php

namespace App\Auth;

use App\Models\Usuario;

class Auth
{
    public static function login($email, $password)
    {
        $usuario = (new Usuario())->findByEmail($email);

        if ($usuario && password_verify($password, $usuario['contraseña'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_role'] = $usuario['role_id'];
            return true;
        }

        return false;
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        session_destroy();
    }

    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function user()
    {
        if (self::check()) {
            return (new Usuario())->findById($_SESSION['user_id']);
        }
        return null;
    }

    public static function id()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function role()
    {
        return $_SESSION['user_role'] ?? null;
    }
}
