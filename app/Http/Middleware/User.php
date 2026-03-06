<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Harus login sebagai USER (guard web)
        if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        // Cegah admin mengakses area user
        if (Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
