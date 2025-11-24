<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')
    ->prefix('admin')
    ->group(function () {
        // Redirigir /admin/settings a profile
        Route::redirect('settings', '/admin/settings/profile');

        // Perfil
        Route::get('settings/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('settings/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');

        // Contraseña
        Route::get('settings/password', [PasswordController::class, 'edit'])->name('admin.password.edit');
        Route::put('settings/password', [PasswordController::class, 'update'])
            ->middleware('throttle:6,1')
            ->name('admin.password.update');

        // Apariencia
        Route::get('settings/appearance', function () {
            return Inertia::render('settings/Appearance');
        })->name('admin.appearance.edit');

        // Two-Factor Authentication
        Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])
            ->name('admin.two-factor.show');
    });