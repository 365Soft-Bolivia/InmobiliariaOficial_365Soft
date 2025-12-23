<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExternalApiService;
use App\Services\ExternalPropertyFilterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar el servicio de la API externa
        $this->app->singleton(ExternalApiService::class, function ($app) {
            return new ExternalApiService();
        });

        // Registrar el servicio de filtros para la API externa
        $this->app->singleton(ExternalPropertyFilterService::class, function ($app) {
            return new ExternalPropertyFilterService($app->make(ExternalApiService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
