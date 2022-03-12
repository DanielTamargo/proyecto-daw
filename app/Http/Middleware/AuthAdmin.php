<?php

namespace App\Http\Middleware;

use App\Models\Constants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Comprobamos que está accediendo un usuario registrado y que se trata de un usuario administrador
        $user = Auth::user();
        if (!$user || $user->rol != Constants::ROL_ADMINISTRADOR) {
            return redirect()->route('error.403');
        }

        return $next($request);
    }
}
