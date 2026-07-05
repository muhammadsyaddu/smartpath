<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Set locale aplikasi ke Bahasa Indonesia.
     */
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('id');

        return $next($request);
    }
}