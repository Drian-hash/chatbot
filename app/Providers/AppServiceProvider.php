<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pagination bootstrap
        Paginator::useBootstrap();

        // Kirim data admin hanya ke view admin
        View::composer('admin.*', function ($view) {
            if (Auth::guard('admin')->check()) {
                $view->with('admin', Auth::guard('admin')->user());
            }
        });
    }
}
