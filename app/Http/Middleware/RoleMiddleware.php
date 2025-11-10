<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  // Cambiado para aceptar múltiples roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // CORRECCIÓN: Usar la relación 'roles' (plural) y obtener el primer rol
        if (!$user->roles || $user->roles->isEmpty()) {
            abort(403, 'Usuario sin rol asignado. Contacta al administrador.');
        }

        // CORRECCIÓN: Obtener el nombre del primer rol
        $userRoleName = $user->roles->first()->name;
        
        if (!in_array($userRoleName, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}