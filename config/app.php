<?php

return [
    'database' => [
        'host' => 'localhost',
        'dbname' => 'sset_management',
        'user' => 'equipos',
        'password' => 'equipos',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'name' => 'Asset Management',
        'url' => 'https://host.example.com',
    ],
];

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \App\Application(
    realpath(__DIR__ . '/..')
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

return $app;
