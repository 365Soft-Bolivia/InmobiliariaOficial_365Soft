<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user() ? $request->user()->id : $request->ip());
        });

        $this->routes(function () {
            // ⭐ RUTAS PÚBLICAS (sin autenticación) - Se cargan PRIMERO
            Route::middleware('web')
                ->group(base_path('routes/public.php'));

            // 🔐 RUTAS ADMINISTRATIVAS (con autenticación)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // 🔌 API routes (si las usas)
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}