<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->Jabatan === "admin") {
            return $next($request);
        }

        if(Auth::check() && Auth::user()->Jabatan !== "admin"){
            return redirect('/mobile-only')->with('message', 'Anda tidak memiliki akses admin.');
        }

        // Jika bukan admin, kirim respon error JSON
        return response()->json(['message' => 'Anda tidak memiliki akses admin.'], 403);
    }
}
