<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);

        // Añadir variables globales a Twig
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('auth', [
            'check' => \App\Auth\Auth::check(),
            'user' => \App\Auth\Auth::user(),
        ]);
    }

    protected function render($template, $data = [])
    {
        echo $this->twig->render($template, $data);
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
