<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new App\Router();

// Rutas de autenticación
$router->add('GET', '/login', 'App\Controllers\UsuarioController', 'login');
$router->add('POST', '/login', 'App\Controllers\UsuarioController', 'login');
$router->add('GET', '/logout', 'App\Controllers\UsuarioController', 'logout');
$router->add('GET', '/forgot-password', 'App\Controllers\UsuarioController', 'forgotPassword');
$router->add('POST', '/forgot-password', 'App\Controllers\UsuarioController', 'forgotPassword');
$router->add('GET', '/reset-password/:token', 'App\Controllers\UsuarioController', 'resetPassword');
$router->add('POST', '/reset-password/:token', 'App\Controllers\UsuarioController', 'resetPassword');

// Rutas de usuarios
$router->add('GET', '/usuarios', 'App\Controllers\UsuarioController', 'index');
$router->add('GET', '/usuarios/create', 'App\Controllers\UsuarioController', 'create');
$router->add('POST', '/usuarios/create', 'App\Controllers\UsuarioController', 'create');
$router->add('GET', '/usuarios/edit/:id', 'App\Controllers\UsuarioController', 'edit');
$router->add('POST', '/usuarios/edit/:id', 'App\Controllers\UsuarioController', 'edit');
$router->add('POST', '/usuarios/delete/:id', 'App\Controllers\UsuarioController', 'delete');

// Aquí se añadirían las rutas para las demás entidades (empresas, sub-empresas, departamentos, equipos)

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);