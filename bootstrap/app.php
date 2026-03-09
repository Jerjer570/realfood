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
    ->withMiddleware(function (Middleware $middleware) {
        // Pengaturan Alias Middleware
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Tambahkan ini untuk memastikan CSRF bekerja dengan benar di web
        $middleware->validateCsrfTokens(except: [
            // Jika benar-benar macet, kamu bisa tes masukkan 'login' di sini sementara
            // 'login', 
        ]);

        // Memastikan stateful cookies aman untuk local development
        $middleware->statefulApi(); 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();