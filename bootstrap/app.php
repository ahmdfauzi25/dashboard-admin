<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => \App\Shared\Middleware\CheckPermission::class,
            'role' => \App\Shared\Middleware\CheckRole::class,
            'page.maintenance' => \App\Shared\Middleware\PageMaintenance::class,
        ]);
        // Terapkan middleware maintenance ke seluruh group 'web'
        $middleware->appendToGroup('web', \App\Shared\Middleware\PageMaintenance::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
