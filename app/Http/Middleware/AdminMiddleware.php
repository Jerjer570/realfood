<?php

namespace App\Http\Middleware; // <-- Pastikan tidak ada typo

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/login')->withErrors(['email' => 'Akses Terlarang!']);
    }
}