<?php

use App\Http\Controllers\AccesosController;
use Illuminate\Support\Facades\Route;

// Rutas de administración (protegidas)
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Rutas de accesos
        Route::prefix('accesos')
            ->group(function () {
                // Ruta principal de lista (GET /admin/accesos)
                Route::get('/', [AccesosController::class, 'index'])
                    ->name('admin.accesos');

                // Rutas API con prefijo admin.accesos.
                Route::get('/listar', [AccesosController::class, 'listar'])->name('admin.accesos.listar');
                Route::post('/', [AccesosController::class, 'store'])->name('admin.accesos.store');
                Route::put('/{id}', [AccesosController::class, 'update'])->name('admin.accesos.update');
                Route::delete('/{id}', [AccesosController::class, 'destroy'])->name('admin.accesos.destroy');
                Route::post('/{id}/toggle-status', [AccesosController::class, 'toggleStatus'])->name('admin.accesos.toggle-status');
            });
    });

// Rutas públicas (sin autenticación)
Route::get('/accesos', [AccesosController::class, 'accesos'])->name('accesos');
