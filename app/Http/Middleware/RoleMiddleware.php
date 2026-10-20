<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Manejar la solicitud entrante.
     *
     * @param  string  ...$roles  Lista de roles permitidos (ej. 'admin', 'operator')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Asegurar que el usuario esté autenticado
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Comprobar si el usuario cuenta con al menos uno de los roles indicados
        if (! $user->hasAnyRole($roles)) {
            // Lanza una excepción HTTP 403 (No Autorizado) con mensaje descriptivo
            abort(403, 'Acceso Denegado. Su rol no cuenta con los permisos necesarios para realizar esta acción.');
        }

        return $next($request);
    }
}
