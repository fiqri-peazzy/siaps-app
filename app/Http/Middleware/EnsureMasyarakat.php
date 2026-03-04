<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMasyarakat
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.phone');
        }

        if (Auth::user()->role !== 'masyarakat') {
            // Admin accidentally hit masyarakat routes -> redirect to admin dashboard
            return redirect()->route('dashboard');
        }

        if (Auth::user()->status !== 'active') {
            Auth::logout();
            return redirect()->route('auth.phone')
                ->withErrors(['phone' => 'Akun Anda tidak aktif. Hubungi administrator.']);
        }

        return $next($request);
    }
}
