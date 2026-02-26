<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Si ya hay imágenes, no crear duplicadas
        if (\DB::table('product_images')->count() > 0) {
            return;
        }

        // URLs de imágenes (proporcionadas por el usuario)
        $imageUrls = [
            'https://cdn.21online.lat/bolivia/cache/awsTest1/rc/rM2LZiJ4/uploads/63/propiedades/81164/68755f9320d77.jpg',
            'https://www.argenprop.com/static-content/88986771/7f2692df-af89-4cee-95e9-899b69042753_u_small.jpg',
            'https://www.argenprop.com/static-content/76417381/8a92c989-d4b9-41ce-bd12-0d87d5d0014e_u_medium.jpg',
            'https://http2.mlstatic.com/D_NQ_NP_2X_917243-MLU87776401780_072025-N.webp',
            'https://www.argenprop.com/static-content/27993521/2566eabe-5876-40e3-82f8-629cf60bcafd_u_small.jpg',
            'https://www.argenprop.com/static-content/47158681/7bfdf207-4e3c-496d-89e0-8ee786dcd192_u_small.jpg',
        ];

        // Obtener todos los IDs de productos que realmente existen
        $productIds = \DB::table('products')->pluck('id');

        // Crear 3 imágenes por producto con URLs aleatorias
        foreach ($productIds as $productId) {
            // Seleccionar 3 URLs aleatorias (pueden repetirse)
            $selectedUrls = collect($imageUrls)->shuffle()->take(3)->values();

            foreach ($selectedUrls as $imgIndex => $url) {
                $imageName = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_FILENAME);

                ProductImage::create([
                    'product_id' => $productId,
                    'image_path' => $url,
                    'original_name' => $imageName . '_' . $productId . '_' . $imgIndex . '.jpg',
                    'is_primary' => $imgIndex === 0,
                    'order' => $imgIndex,
                ]);
            }
        }
    }
}
