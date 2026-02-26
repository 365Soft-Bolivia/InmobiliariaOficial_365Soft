<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // 1. Primero usuarios y roles
            UserSeeder::class,

            // 2. Categorías de productos
            ProductCategorySeeder::class,

            // 3. Productos (depende de categorías y usuarios)
            ProductSeeder::class,

            // 4. Imágenes de productos (depende de productos)
            ProductImageSeeder::class,

            // 5. Ubicaciones de productos (depende de productos)
            ProductLocationSeeder::class,
        ]);
    }
}
