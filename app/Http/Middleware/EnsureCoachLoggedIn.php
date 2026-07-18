<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCoachLoggedIn
{
    /**
     * Mengamankan agar orang tua tidak bisa masuk ke dashboard pelatih tanpa login PIN.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika tidak ada tanda session login pelatih, tendang balik ke halaman login
        if (!session()->has('coach_logged_in')) {
            return redirect()->route('coach.login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return $next($request);
    }
}