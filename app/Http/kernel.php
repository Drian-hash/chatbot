<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     * Dijalankan pada setiap request.
     */
    protected $middleware = [

        // Enkripsi cookie (penting untuk keamanan session)
        \Illuminate\Cookie\Middleware\EncryptCookies::class,

        // Handle CORS
        \Illuminate\Http\Middleware\HandleCors::class,

        // Validasi ukuran POST
        \Illuminate\Http\Middleware\ValidatePostSize::class,

        // Konversi string kosong ke null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Route middleware groups.
     */
    protected $middlewareGroups = [

        // Group WEB (wajib untuk auth & session)
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // Middleware untuk mendeteksi user Online / Offline
            \App\Http\Middleware\UserOnlineStatus::class,
        ],
    ];

    /**
     * Route middleware (custom & default).
     */
    protected $routeMiddleware = [

        // Default Laravel middleware
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session'     => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Middleware custom SIMKIP
        'admin' => \App\Http\Middleware\Admin::class,
        'user'  => \App\Http\Middleware\User::class,
    ];
}
