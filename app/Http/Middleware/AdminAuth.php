<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Pastikan admin sudah login (session 'admin_id' ada) sebelum
     * mengakses halaman admin, kasir, atau dapur.
     * Kalau belum login, lempar ke halaman login admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_id')) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
