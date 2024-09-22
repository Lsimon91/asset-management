<?php

namespace App\Controllers;

use App\Models\Empresa;
use App\Auth\AccessControl;

class EmpresaController extends Controller
{
    private $empresaModel;

    public function __construct()
    {
        parent::__construct();
        $this->empresaModel = new Empresa();
    }

    public function index()
    {
        AccessControl::check('leer_empresa');
        $empresas = $this->empresaModel->findAll();
        $this->render('empresas/index.twig', ['empresas' => $empresas]);
    }

    public function create()
    {
        AccessControl::check('crear_empresa');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            $this->empresaModel->create($data);
            $this->redirect('/empresas');
        }
        $this->render('empresas/create.twig');
    }

    public function edit($id)
    {
        AccessControl::check('actualizar_empresa');
        $empresa = $this->empresaModel->findById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre']
            ];
            $this->empresaModel->update($id, $data);
            $this->redirect('/empresas');
        }
        $this->render('empresas/edit.twig', ['empresa' => $empresa]);
    }

    public function delete($id)
    {
        AccessControl::check('eliminar_empresa');
        $this->empresaModel->delete($id);
        $this->redirect('/empresas');
    }
}
