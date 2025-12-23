<?php

namespace App\Services;

use Illuminate\Http\Request;

class ExternalPropertyFilterService
{
    private ExternalApiService $apiService;

    public function __construct(ExternalApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Aplica filtros a los productos de la API externa
     */
    public function applyFilters(Request $request): array
    {
        $data = $this->apiService->filterProducts($request);

        return [
            'propiedades' => $data['products'],
            'pagination' => $data['pagination'],
            'filter_options' => $this->getFilterOptions(),
            'filters_applied' => $this->getAppliedFilters($request),
        ];
    }

    /**
     * Obtiene las opciones para filtros
     */
    public function getFilterOptions(): array
    {
        return $this->apiService->getFilterOptions();
    }

    /**
     * Obtiene los filtros aplicados para el frontend
     */
    private function getAppliedFilters(Request $request): array
    {
        return $request->only([
            'categoria',
            'operacion',
            'codigo',
            'precio_min',
            'precio_max',
            'ambientes',
            'habitaciones',
            'banos',
            'cocheras',
            'per_page',
        ]);
    }

    /**
     * Obtiene un producto específico
     */
    public function getProductById(int $id): ?array
    {
        return $this->apiService->getProductById($id);
    }

    /**
     * Obtiene productos para el mapa (todos los productos con sus datos básicos)
     */
    public function getProductsForMap(): array
    {
        $products = $this->apiService->getProducts();

        // Por ahora, la API no incluye ubicación, pero preparamos la estructura
        return collect($products['products'])->map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'codigo_inmueble' => $product['codigo_inmueble'],
                'price' => $product['price'],
                'operacion' => $product['operacion'],
                'category' => $product['category_name'],
                'category_id' => $product['category_id'],
                'habitaciones' => $product['habitaciones'],
                'banos' => $product['banos'],
                'ambientes' => $product['ambientes'],
                'cocheras' => $product['cocheras'],
                'superficie_util' => $product['superficie_util'],
                'superficie_construida' => $product['superficie_construida'],
                'ano_construccion' => $product['ano_construccion'],
                'antiguedad' => $product['antiguedad'],
                'comision' => $product['comision'],
                'default_image' => $product['imagen_portada'],
                'images' => $product['images'],
                'location' => $product['location'], // Será null hasta que la API incluya ubicación
                'agente' => $product['agente_captador'],
            ];
        })->toArray();
    }

    /**
     * Obtiene propiedades relacionadas (misma categoría)
     */
    public function getRelatedProperties(int $excludeId, ?int $categoryId = null, int $limit = 6): array
    {
        $products = $this->apiService->getProducts();

        return collect($products['products'])
            ->filter(function ($product) use ($excludeId) {
                return $product['id'] !== $excludeId;
            })
            ->when($categoryId, function ($collection, $categoryId) {
                return $collection->where('category_id', $categoryId);
            })
            ->take($limit)
            ->map(function ($product) {
                return [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'codigo_inmueble' => $product['codigo_inmueble'],
                    'price' => $product['price'],
                    'category' => $product['category_name'],
                    'direccion' => null, // La API actual no incluye dirección
                    'images' => array_slice($product['images'], 0, 2),
                ];
            })
            ->toArray();
    }
}