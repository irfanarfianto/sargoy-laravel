<?php

use Symfony\Component\Routing\Route;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            // Route::middleware('api')
            //     ->prefix('apis')
            //     ->group(
            //         glob(base_path('routes/api/*.php'))
            //     );

            Route::middleware('web')
                ->group(glob(base_path('routes/web/*.php')));
        },
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'record.visit' =>   \App\Http\Middleware\RecordVisit::class,
            'record.product.view' => \App\Http\Middleware\RecordProductVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UnauthorizedException $e, $request) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        });
    })
    ->create();
