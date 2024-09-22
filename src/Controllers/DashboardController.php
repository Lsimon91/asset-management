<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Auth\AccessControl;

class DashboardController extends Controller
{
    public function index()
    {
        AccessControl::check('leer_dashboard');

        $usuarioModel = new Usuario();
        $empresaModel = new Empresa();
        $equipoModel = new Equipo();

        $totalUsuarios = $usuarioModel->count();
        $totalEmpresas = $empresaModel->count();
        $totalEquipos = $equipoModel->count();
        $equiposActivos = $equipoModel->countByStatus('Activo');
        $equiposInactivos = $equipoModel->countByStatus('Inactivo');
        $equiposEnReparacion = $equipoModel->countByStatus('En reparación');

        $data = [
            'totalUsuarios' => $totalUsuarios,
            'totalEmpresas' => $totalEmpresas,
            'totalEquipos' => $totalEquipos,
            'equiposActivos' => $equiposActivos,
            'equiposInactivos' => $equiposInactivos,
            'equiposEnReparacion' => $equiposEnReparacion,
        ];

        $this->render('dashboard/index.twig', $data);
    }
}
