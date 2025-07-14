<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => CheckAdmin::class,
            'setlocale' => SetLocale::class, 
        ]);
          // Thêm các middleware toàn cục (global)
        $middleware->appendToGroup('web', [
            EncryptCookies::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            EnsureFrontendRequestsAreStateful::class, // Đây là middleware chính của Sanctum
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
