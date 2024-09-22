<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri, $params)) {
                $controller = new $route['controller']();
                call_user_func_array([$controller, $route['action']], $params);
                return;
            }
        }

        // Si no se encuentra una ruta, mostrar error 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    private function matchPath($routePath, $uri, &$params)
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        $params = [];

        for ($i = 0; $i < count($routeParts); $i++) {
            if (strpos($routeParts[$i], ':') === 0) {
                $params[] = $uriParts[$i];
            } elseif ($routeParts[$i] !== $uriParts[$i]) {
                return false;
            }
        }

        return true;
    }
}