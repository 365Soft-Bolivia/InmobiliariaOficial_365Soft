<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Solo insertar si las tablas están vacías
        if (DB::table('product_category')->count() > 0 || DB::table('categories')->count() > 0) {
            return;
        }

        $categories = [
            [
                'id' => 1,
                'name' => 'Casa',
                'category_name' => 'Casa',
                'description' => 'Propiedades residenciales tipo casa',
                'is_active' => 1,
                'order' => 1,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 2,
                'name' => 'Departamento',
                'category_name' => 'Departamento',
                'description' => 'Propiedades residenciales tipo departamento',
                'is_active' => 1,
                'order' => 2,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 3,
                'name' => 'Edificio',
                'category_name' => 'Edificio',
                'description' => 'Edificios completos o en venta',
                'is_active' => 1,
                'order' => 3,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 4,
                'name' => 'Galpón',
                'category_name' => 'Galpón',
                'description' => 'Galpones industriales y comerciales',
                'is_active' => 1,
                'order' => 4,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 5,
                'name' => 'Habitación',
                'category_name' => 'Habitación',
                'description' => 'Habitaciones individuales',
                'is_active' => 1,
                'order' => 5,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 6,
                'name' => 'Local Comercial',
                'category_name' => 'Local Comercial',
                'description' => 'Locales comerciales y negocios',
                'is_active' => 1,
                'order' => 6,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 7,
                'name' => 'Oficina',
                'category_name' => 'Oficina',
                'description' => 'Oficinas corporativas',
                'is_active' => 1,
                'order' => 7,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 8,
                'name' => 'Parqueo',
                'category_name' => 'Parqueo',
                'description' => 'Espacios de parqueo',
                'is_active' => 1,
                'order' => 8,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 9,
                'name' => 'Quinta Propiedad Agricola',
                'category_name' => 'Quinta Propiedad Agricola',
                'description' => 'Quintas y propiedades agrícolas',
                'is_active' => 1,
                'order' => 9,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
            [
                'id' => 10,
                'name' => 'Terreno',
                'category_name' => 'Terreno',
                'description' => 'Terrenos y lotes',
                'is_active' => 1,
                'order' => 10,
                'company_id' => 1,
                'created_at' => '2025-10-29 17:16:12',
                'updated_at' => '2025-10-29 17:16:12',
            ],
        ];

        foreach ($categories as $category) {
            // Insertar en tabla 'categories' (para foreign key de products)
            DB::table('categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'description' => $category['description'],
                'is_active' => $category['is_active'],
                'order' => $category['order'],
                'created_at' => $category['created_at'],
                'updated_at' => $category['updated_at'],
            ]);

            // Insertar en tabla 'product_category' (para modelo ProductCategory)
            DB::table('product_category')->insert([
                'id' => $category['id'],
                'category_name' => $category['category_name'],
                'company_id' => $category['company_id'],
                'created_at' => $category['created_at'],
                'updated_at' => $category['updated_at'],
            ]);
        }
    }
}
