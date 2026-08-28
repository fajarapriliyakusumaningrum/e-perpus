<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login DAN apakah role-nya sesuai
        if (!auth()->check() || auth()->user()->role !== $role) {
            // Jika tidak sesuai, stop akses (Tampilkan error 403 Forbidden)
            abort(403, 'Kamu tidak memiliki akses ke halaman ini!');
        }

        return $next($request);
    }
}