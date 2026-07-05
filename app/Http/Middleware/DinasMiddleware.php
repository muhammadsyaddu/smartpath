<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DinasMiddleware
{
    /**
     * Memastikan hanya administrator dan dinas yang dapat mengakses rute ini.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->isAdmin() && !$user->isDinas()) {
            abort(403, 'Akses ditolak. Hanya administrator dan dinas yang diizinkan.');
        }

        return $next($request);
    }
}