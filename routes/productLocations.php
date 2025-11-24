<?php

use App\Http\Controllers\ProductLocationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Ruta principal para la vista del dashboard de ubicaciones
        Route::get('ubicaciones', [ProductLocationController::class, 'index'])
            ->name('admin.ubicaciones');

        // Rutas para las vistas (renderiza componentes Vue con Inertia)
        Route::prefix('ubicaciones')
            ->name('admin.ubicaciones.')
            ->group(function () {
                Route::get('/mapa', [ProductLocationController::class, 'mapa'])->name('mapa');
                Route::get('/asignar', [ProductLocationController::class, 'asignar'])->name('asignar');
                Route::get('/editar', [ProductLocationController::class, 'editar'])->name('editar');
            });

        // Grupo de rutas para operaciones con ubicaciones (API endpoints)
        Route::prefix('ubicaciones/api')
            ->name('admin.ubicaciones.api.')
            ->group(function () {
                Route::get('/listar', [ProductLocationController::class, 'listar'])->name('listar');
                Route::get('/{product}/obtener', [ProductLocationController::class, 'show'])->name('show');
                Route::post('/{product}', [ProductLocationController::class, 'store'])->name('store');
                Route::post('/{product}/toggle-status', [ProductLocationController::class, 'toggleActive'])->name('toggle-status');
                Route::delete('/{product}', [ProductLocationController::class, 'destroy'])->name('destroy');
                Route::post('/cercanos', [ProductLocationController::class, 'nearby'])->name('cercanos');
            });
    });