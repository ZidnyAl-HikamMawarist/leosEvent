<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     * Pastikan hanya user dengan role admin atau superadmin yang bisa mengakses admin panel.
     *
     * Kalau user biasa (role=user) mencoba akses /admin, redirect ke halaman depan
     * dengan pesan error yang jelas — bukan error 403 yang membingungkan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            // Kalau user sudah login tapi bukan admin, redirect ke halaman depan
            if ($request->user()) {
                return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
            }

            // Kalau belum login sama sekali, redirect ke login
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
