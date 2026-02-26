<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Insertar roles primero (Spatie Permission structure)
        if (!DB::table('roles')->where('id', 1)->exists()) {
            DB::table('roles')->insert([
                [
                    'id' => 1,
                    'name' => 'admin',
                    'guard_name' => 'web',
                    'is_default' => true,
                    'created_at' => '2025-10-29 17:16:12',
                    'updated_at' => '2025-10-29 17:16:12',
                ],
                [
                    'id' => 2,
                    'name' => 'employee',
                    'guard_name' => 'web',
                    'is_default' => false,
                    'created_at' => '2025-10-29 17:16:12',
                    'updated_at' => '2025-10-29 17:16:12',
                ],
            ]);
        }

        // Insertar usuarios
        $adminEmail = 'administrador@gmail.com';
        $juanEmail = 'juan55@gmail.com';

        if (!DB::table('users')->where('email', $adminEmail)->exists() &&
            !DB::table('users')->where('email', $juanEmail)->exists()) {
            DB::table('users')->insert([
                [
                    'id' => 1,
                    'name' => 'Administrador',
                    'email' => 'administrador@gmail.com',
                    'password' => '$2y$12$9jNXpnRBew/hV7XQLsC0O.K6RNppcjL1NQzVB80PD2l7iuJXN1Ky2', // superadmin
                    'status' => 'active',
                    'dark_theme' => 0,
                    'rtl' => 0,
                    'email_notifications' => 1,
                    'gender' => 'male',
                    'locale' => 'es',
                    'login' => 'administrador',
                    'created_at' => '2025-11-17 06:49:24',
                    'updated_at' => '2025-11-17 06:49:24',
                ],
                [
                    'id' => 2,
                    'name' => 'juan',
                    'email' => 'juan55@gmail.com',
                    'password' => '$2y$12$ABFeO7lvnIHHg8ZcTcg75uEctzPr9y7zSok5yfSbxkPGX.7xF3yCu', // password (asumido)
                    'status' => 'active',
                    'dark_theme' => 0,
                    'rtl' => 0,
                    'email_notifications' => 1,
                    'gender' => 'male',
                    'locale' => 'es',
                    'login' => 'juan55',
                    'created_at' => '2025-11-17 07:06:53',
                    'updated_at' => '2025-12-02 18:47:17',
                ],
            ]);
        }

        // Asignar roles usando Spatie Permission structure (model_has_roles)
        if (!DB::table('model_has_roles')->where('model_id', 1)->where('role_id', 1)->exists()) {
            DB::table('model_has_roles')->insert([
                [
                    'role_id' => 1,
                    'model_type' => 'App\Models\User',
                    'model_id' => 1,
                ],
                [
                    'role_id' => 2,
                    'model_type' => 'App\Models\User',
                    'model_id' => 2,
                ],
            ]);
        }
    }
}
