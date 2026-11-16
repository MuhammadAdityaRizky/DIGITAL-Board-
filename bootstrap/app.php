<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->web(append: [
            \App\Http\Middleware\AutoAlphaMiddleware::class,
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            if ($request->is('login')) {
                return back()->withErrors([
                    'username_or_nim_nip' => 'Terlalu banyak percobaan masuk. Mohon tunggu 1 menit sebelum mencoba kembali.',
                ])->withInput();
            }
            if ($request->is('mahasiswa/absensi') || $request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terlalu banyak permintaan presensi. Mohon tunggu beberapa detik lalu coba lagi.',
                ], 429);
            }
        });
    })->create();

// Auto-detect cPanel public_html jika direktori public dipisah ke public_html
$cpanelPublicHtml = dirname(__DIR__).'/../public_html';
if (is_dir($cpanelPublicHtml)) {
    $app->usePublicPath(realpath($cpanelPublicHtml) ?: $cpanelPublicHtml);
}

return $app;
