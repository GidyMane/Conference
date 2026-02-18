<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\ReviewerOnly;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO
        );

        $middleware->alias([
            'admin' => AdminOnly::class,
            'reviewer' => ReviewerOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 🔄 Handle expired session (419)
    $exceptions->render(function (TokenMismatchException $e, $request) {

        if ($request->is('admin/*')) {
            return redirect()->route('admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        if ($request->is('reviewer/*')) {
            return redirect()->route('reviewer.login')
                ->with('error', 'Session expired. Please login again.');
        }

        return redirect()->route('login');
    });

    // 🔐 Handle unauthenticated users
    $exceptions->render(function (AuthenticationException $e, $request) {

            if ($request->is('admin/*')) {
                return redirect()->route('admin.login');
            }

            if ($request->is('reviewer/*')) {
                return redirect()->route('reviewer.login');
            }

            return redirect()->route('login');
        });
    })->create();