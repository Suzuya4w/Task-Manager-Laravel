<?php
// app/Http/Kernel.php
protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \App\Http\Middleware\RoleMiddleware::class,
    'manager' => \App\Http\Middleware\ManagerMiddleware::class,
    
];

