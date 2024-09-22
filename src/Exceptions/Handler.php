<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

class Handler implements ExceptionHandler
{
    public function report(Exception $e)
    {
        // Aquí puedes implementar el registro de errores
    }

    public function render($request, Exception $e)
    {
        if ($e instanceof \App\Exceptions\AuthorizationException) {
            return new Response('No tienes permiso para realizar esta acción.', 403);
        }

        if ($e instanceof \App\Exceptions\NotFoundException) {
            return new Response('La página que buscas no existe.', 404);
        }

        if (config('app.debug')) {
            return new Response((string) $e, 500);
        }

        return new Response('Ha ocurrido un error en el servidor.', 500);
    }

    public function renderForConsole($output, Exception $e)
    {
        $output->writeln((string) $e);
    }
}
