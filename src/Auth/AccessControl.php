<?php

namespace App\Auth;

use App\Models\RolPermiso;

class AccessControl
{
    private static $permisos = null;

    public static function hasPermission($permiso)
    {
        if (self::$permisos === null) {
            self::loadPermisos();
        }

        return in_array($permiso, self::$permisos);
    }

    private static function loadPermisos()
    {
        $roleId = Auth::role();
        $rolPermiso = new RolPermiso();
        self::$permisos = $rolPermiso->getPermisosByRoleId($roleId);
    }

    public static function check($permiso)
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        if (!self::hasPermission($permiso)) {
            header('HTTP/1.1 403 Forbidden');
            echo "No tienes permiso para acceder a esta página.";
            exit;
        }
    }
}
