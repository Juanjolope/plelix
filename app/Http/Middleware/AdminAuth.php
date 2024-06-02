<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
        // comprobamos si el usuario es admin
        if(auth()->check() && auth()->user()->role == 'admin') {
            // si es admin permitir el acceso
            return $next($request);
        }

        // si el usuario no es un administrador dirigirlo a la pagina de inicio
        return redirect()->to('/');
    }
}
