<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        // Cek apakah user memiliki role yang diizinkan
        if ($user) {
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
        }

        // Jika tidak memiliki akses yang sesuai
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}