<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Auth Middlewares
use App\Http\Middleware\Auth\CookieBasedSanctumAuthMiddleware;
use App\Http\Middleware\Auth\OptionalCookieBasedSanctumAuthMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.sanctum.cookie' => CookieBasedSanctumAuthMiddleware::class,
            'optional.auth.sanctum.cookie' => OptionalCookieBasedSanctumAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
