<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class ValidateStateUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->user_status == 1) {
            return $next($request);
        } else if(!auth()->check()){
            Alert::info('Acceso denegado', 'Señor usuario esta tratando de acceder a un contenido que no tiene el permiso');
            return redirect('/login');
        }else{
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Alert::warning('Rechazo de ingreso', 'Señor usuario actualmente se encuentra inactivo en el sistema, por favor comuniquese con el administrador');
            return redirect('/login');
        }
        }
    }
