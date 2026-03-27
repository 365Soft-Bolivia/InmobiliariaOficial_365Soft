<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function __construct()
    {
        Log::info('🔔 LogRequests middleware instanciado');
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            Log::info('===== PETICIÓN RECIBIDA =====', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'ajax' => $request->ajax(),
                'inertia' => $request->header('X-Inertia'),
                'all_input' => $request->all(),
            ]);

            $response = $next($request);

            Log::info('===== RESPUESTA ENVIADA =====', [
                'status' => $response->getStatusCode(),
                'redirect' => $response->headers->get('Location'),
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('⚠️ ERROR en LogRequests: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            throw $e;
        }
    }
}
