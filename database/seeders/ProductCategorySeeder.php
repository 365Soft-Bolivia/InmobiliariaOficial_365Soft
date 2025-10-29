<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de categorías inmobiliarias
        $categories = [
            'Casa',
            'Departamento',
            'Edificio',
            'Galpón',
            'Habitacion',
            'Local Comercial',
            'Oficina',
            'Parqueo',
            'Quinta Propiedad Agricola',
            'Terreno',
        ];

        // Crear cada categoría en la base de datos
        foreach ($categories as $category) {
            ProductCategory::create([
                'category_name' => $category,
            ]);
        }
    }
}
