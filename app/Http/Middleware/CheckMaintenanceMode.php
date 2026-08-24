<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::first();

        if ($setting && $setting->is_maintenance) {
            // Izinkan Admin dan Superadmin melihat website apa pun
            if (Auth::check() && Auth::user()->isAdmin()) {
                return $next($request);
            }

            // Izinkan akses ke admin panel, auth, dan file asset/media
            if (
                $request->is('admin*') ||
                $request->is('login') ||
                $request->is('logout') ||
                $request->is('register') ||
                $request->is('storage/*') ||
                $request->is('css/*') ||
                $request->is('js/*') ||
                $request->is('images/*') ||
                $request->is('favicon.ico')
            ) {
                return $next($request);
            }

            // Tampilkan halaman maintenance untuk user biasa dan tamu (guest)
            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}
