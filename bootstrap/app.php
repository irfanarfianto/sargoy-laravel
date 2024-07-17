<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        using: function () {
            Route::middleware('web')
                ->group(glob(base_path('routes/web/*.php')));
        },
        health: '/status',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'record.visit' => \App\Http\Middleware\RecordVisit::class,
            'record.product.view' => \App\Http\Middleware\RecordProductVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            return response()->view('errors.404', ['exception' => $e->getMessage()], 404);
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 500) {
                return response()->view('errors.500', ['exception' => $e->getMessage()], 500);
            }
        });
    })
    ->create();
