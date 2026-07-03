<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors; // এটি যোগ করুন

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ১. ডিফল্ট HandleCors মিডলওয়্যারটি ব্যবহার করুন (এটি আপনার কাস্টম মিডলওয়্যারটিকে রিপ্লেস করতে পারে)
        $middleware->append(HandleCors::class);

        // ২. আপনার কাস্টম মিডলওয়্যারগুলো এখানে রাখুন
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();