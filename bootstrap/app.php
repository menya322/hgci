<?php

use App\Http\Middleware\EnsureUserIsAdmin;
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
        // Trust the local reverse proxy that terminates TLS. Both the
        // production Nginx server and a local tunnel agent (ngrok,
        // cloudflared) connect over the loopback interface, so only those
        // addresses are trusted: X-Forwarded-Proto is honoured and generated
        // asset URLs stay on https, while a direct public connection cannot
        // spoof the scheme.
        $middleware->trustProxies(at: ['127.0.0.1', '::1']);

        $middleware->alias([
            'admin' => EnsureUserIsAdmin::class,
        ]);

        $middleware->redirectGuestsTo(fn () => route('admin.login'));
        $middleware->redirectUsersTo('/admin');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
