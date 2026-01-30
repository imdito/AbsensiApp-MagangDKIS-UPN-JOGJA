<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOrSuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && (Auth::user()->Jabatan === "superadmin" || Auth::user()->Jabatan === "admin")){
            return $next($request);
        }
        return redirect('/')->with('message', 'Anda tidak memiliki akses Super Admin.');
    }
}
