<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Auth\Auth;
use App\Auth\AccessControl;
use App\Mail\Mailer;

class UsuarioController extends Controller
{
    private $usuarioModel;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }

    public function index()
    {
        AccessControl::check('leer_usuario');
        $usuarios = $this->usuarioModel->findAll();
        $this->render('usuarios/index.twig', ['usuarios' => $usuarios]);
    }

    public function create()
    {
        AccessControl::check('crear_usuario');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'contraseña' => $_POST['contraseña'],
                'role_id' => $_POST['role_id'],
                'sub_empresa_id' => $_POST['sub_empresa_id'] ?? null,
            ];
            $this->usuarioModel->create($data);
            $this->redirect('/usuarios');
        }
        $this->render('usuarios/create.twig');
    }

    public function edit($id)
    {
        AccessControl::check('actualizar_usuario');
        $usuario = $this->usuarioModel->findById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'role_id' => $_POST['role_id'],
                'sub_empresa_id' => $_POST['sub_empresa_id'] ?? null,
            ];
            if (!empty($_POST['contraseña'])) {
                $data['contraseña'] = $_POST['contraseña'];
            }
            $this->usuarioModel->update($id, $data);
            $this->redirect('/usuarios');
        }
        $this->render('usuarios/edit.twig', ['usuario' => $usuario]);
    }

    public function delete($id)
    {
        AccessControl::check('eliminar_usuario');
        $this->usuarioModel->delete($id);
        $this->redirect('/usuarios');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['contraseña'];
            if (Auth::login($email, $password)) {
                $this->redirect('/dashboard');
            } else {
                $error = "Credenciales inválidas";
                $this->render('auth/login.twig', ['error' => $error]);
            }
        } else {
            $this->render('auth/login.twig');
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/login');
    }
public function forgotPassword()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $usuario = $this->usuarioModel->findByEmail($email);
        if ($usuario) {
            $token = bin2hex(random_bytes(32));
            $this->usuarioModel->update($usuario['id'], ['reset_token' => $token]);
            
            $mailer = new Mailer();
            $resetUrl = "http://tudominio.com/reset-password/{$token}";
            $subject = "Recuperación de contraseña";
            $body = "Para restablecer tu contraseña, haz clic en el siguiente enlace: <a href='{$resetUrl}'>{$resetUrl}</a>";
            
            if ($mailer->send($email, $subject, $body)) {
                $message = "Se ha enviado un enlace de recuperación a tu email.";
                $this->render('auth/forgot-password.twig', ['message' => $message]);
            } else {
                $error = "Hubo un problema al enviar el email. Por favor, inténtalo de nuevo.";
                $this->render('auth/forgot-password.twig', ['error' => $error]);
            }
        } else {
            $error = "No se encontró un usuario con ese email.";
            $this->render('auth/forgot-password.twig', ['error' => $error]);
        }
    } else {
        $this->render('auth/forgot-password.twig');
    }
}

public function resetPassword($token)
{
    $usuario = $this->usuarioModel->findByResetToken($token);
    if (!$usuario) {
        $this->redirect('/login');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $validator = new Validator();
        $rules = [
            'contraseña' => ['required', 'min:8'],
            'confirmar_contraseña' => ['required', 'min:8'],
        ];

        if ($validator->validate($_POST, $rules)) {
            if ($_POST['contraseña'] === $_POST['confirmar_contraseña']) {
                $this->usuarioModel->update($usuario['id'], [
                    'contraseña' => password_hash($_POST['contraseña'], PASSWORD_DEFAULT),
                    'reset_token' => null
                ]);
                $this->redirect('/login');
            } else {
                $error = "Las contraseñas no coinciden.";
                $this->render('auth/reset-password.twig', ['token' => $token, 'error' => $error]);
            }
        } else {
            $errors = $validator->getErrors();
            $this->render('auth/reset-password.twig', ['token' => $token, 'errors' => $errors]);
        }
    } else {
        $this->render('auth/reset-password.twig', ['token' => $token]);
    }
}
