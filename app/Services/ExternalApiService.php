<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ExternalApiService
{
    private string $apiUrl;
    private string $apiKey;
    private int $cacheDuration;

    public function __construct()
    {
        $this->apiUrl = config('services.external_api.url', 'https://fifusa.site/api/v1/products');
        $this->apiKey = config('services.external_api.key', '');
        $this->cacheDuration = config('services.external_api.cache_duration', 300); // 5 minutos por defecto
    }

    /**
     * Obtiene todos los productos de la API externa
     */
    public function getProducts(?Request $request = null): array
    {
        $cacheKey = $this->generateCacheKey($request);

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($request) {
            $url = $this->apiUrl;

            // Agregar parámetros de paginación si existen
            if ($request) {
                $params = [];

                if ($request->get('page')) {
                    $params['page'] = $request->get('page');
                }

                if ($request->get('per_page')) {
                    $params['per_page'] = min($request->get('per_page'), 100);
                }

                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'X-API-KEY' => $this->apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($url);

            if (!$response->successful()) {
                throw new \Exception('Error al consumir la API externa: ' . $response->status());
            }

            $data = $response->json();

            if (!$data['success']) {
                throw new \Exception('La API externa devolvió un error: ' . ($data['message'] ?? 'Error desconocido'));
            }

            return [
                'products' => $this->formatProducts($data['data']),
                'pagination' => $data['meta'] ?? [],
                'raw_data' => $data
            ];
        });
    }

    /**
     * Obtiene un producto específico por ID
     */
    public function getProductById(int $id): ?array
    {
        $cacheKey = "external_product_{$id}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($id) {
            $response = Http::timeout(30)
                ->withHeaders([
                    'X-API-KEY' => $this->apiKey,
                    'Accept' => 'application/json',
                ])
                ->get("{$this->apiUrl}/{$id}");

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            if (!$data['success']) {
                return null;
            }

            return $this->formatSingleProduct($data['data']);
        });
    }

    /**
     * Filtra productos según los parámetros de solicitud
     */
    public function filterProducts(Request $request): array
    {
        // Por ahora, la API externa no soporta filtros complejos
        // Obtenemos todos y filtramos localmente
        $allProducts = $this->getProducts($request);

        $filtered = collect($allProducts['products']);

        // Aplicar filtros localmente

        // Filtro de categorías (soporta múltiples IDs separados por coma)
        if ($request->get('categoria')) {
            $categoriaValue = $request->get('categoria');

            // Si es un string con comas, es una lista de IDs
            if (is_string($categoriaValue) && str_contains($categoriaValue, ',')) {
                $categoryIds = array_map('intval', explode(',', $categoriaValue));
                $filtered = $filtered->filter(function ($product) use ($categoryIds) {
                    return in_array($product['category_id'], $categoryIds);
                });
            } else {
                // Single category ID
                $categoryId = (int) $categoriaValue;
                $filtered = $filtered->where('category_id', $categoryId);
            }
        }

        // Filtro de operaciones (soporta múltiples operaciones separadas por coma)
        if ($request->get('operacion')) {
            $operacionValue = $request->get('operacion');

            if (is_string($operacionValue) && str_contains($operacionValue, ',')) {
                $operaciones = explode(',', $operacionValue);
                $filtered = $filtered->filter(function ($product) use ($operaciones) {
                    return in_array($product['operacion'], $operaciones);
                });
            } else {
                $filtered = $filtered->where('operacion', $operacionValue);
            }
        }

        // Filtro por código de inmueble
        if ($request->get('codigo')) {
            $codigo = $request->get('codigo');
            $filtered = $filtered->filter(function ($product) use ($codigo) {
                return stripos($product['codigo_inmueble'], $codigo) !== false;
            });
        }

        // Filtro de rango de precios
        if ($request->get('precio_min')) {
            $minPrice = (float) $request->get('precio_min');
            $filtered = $filtered->where('price', '>=', $minPrice);
        }

        if ($request->get('precio_max')) {
            $maxPrice = (float) $request->get('precio_max');
            $filtered = $filtered->where('price', '<=', $maxPrice);
        }

        // Filtros de características
        if ($request->get('ambientes')) {
            $ambientes = (int) $request->get('ambientes');
            $filtered = $filtered->where('ambientes', $ambientes);
        }

        if ($request->get('habitaciones')) {
            $habitaciones = (int) $request->get('habitaciones');
            $filtered = $filtered->where('habitaciones', $habitaciones);
        }

        if ($request->get('banos')) {
            $banos = (int) $request->get('banos');
            $filtered = $filtered->where('banos', $banos);
        }

        if ($request->get('cocheras')) {
            $cocheras = (int) $request->get('cocheras');
            $filtered = $filtered->where('cocheras', $cocheras);
        }

        // Filtros de superficies (superficie_construida)
        if ($request->get('superficie_construida_min')) {
            $minSuperficie = (float) $request->get('superficie_construida_min');
            $filtered = $filtered->filter(function ($product) use ($minSuperficie) {
                return $product['superficie_construida'] !== null
                    && $product['superficie_construida'] >= $minSuperficie;
            });
        }

        if ($request->get('superficie_construida_max')) {
            $maxSuperficie = (float) $request->get('superficie_construida_max');
            $filtered = $filtered->filter(function ($product) use ($maxSuperficie) {
                return $product['superficie_construida'] !== null
                    && $product['superficie_construida'] <= $maxSuperficie;
            });
        }

        // Filtros de superficie_util (superficie_terreno en el frontend)
        if ($request->get('superficie_terreno_min')) {
            $minSuperficie = (float) $request->get('superficie_terreno_min');
            $filtered = $filtered->filter(function ($product) use ($minSuperficie) {
                return $product['superficie_util'] !== null
                    && $product['superficie_util'] >= $minSuperficie;
            });
        }

        if ($request->get('superficie_terreno_max')) {
            $maxSuperficie = (float) $request->get('superficie_terreno_max');
            $filtered = $filtered->filter(function ($product) use ($maxSuperficie) {
                return $product['superficie_util'] !== null
                    && $product['superficie_util'] <= $maxSuperficie;
            });
        }

        // Aplicar paginación local
        $perPage = min($request->get('per_page', 12), 100);
        $page = $request->get('page', 1);
        $total = $filtered->count();

        $paginated = $filtered->slice(($page - 1) * $perPage, $perPage)->values();

        return [
            'products' => $paginated->toArray(),
            'pagination' => [
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'per_page' => $perPage,
                'total' => $total,
                'from' => ($page - 1) * $perPage + 1,
                'to' => min($page * $perPage, $total),
            ]
        ];
    }

    /**
     * Obtiene las opciones para filtros
     */
    public function getFilterOptions(): array
    {
        $cacheKey = 'external_api_filter_options';

        return Cache::remember($cacheKey, 3600, function () {
            $products = $this->getProducts();
            $productCollection = collect($products['products']);

            // Obtener categorías únicas con sus IDs
            $categoriasConIds = $productCollection
                ->filter(function ($product) {
                    return isset($product['category_id']) && isset($product['category_name']);
                })
                ->map(function ($product) {
                    return [
                        'id' => $product['category_id'],
                        'name' => $product['category_name'],
                    ];
                })
                ->unique('id')
                ->sortBy('name')
                ->values();

            // Crear array asociativo con ID como clave
            $categoriasAsociativas = [];
            foreach ($categoriasConIds as $categoria) {
                $categoriasAsociativas[$categoria['id']] = $categoria['name'];
            }

            // Obtener operaciones únicas
            $operaciones = $productCollection
                ->pluck('operacion')
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            // Crear array asociativo para operaciones
            $operacionesAsociativas = [];
            foreach ($operaciones as $operacion) {
                $operacionesAsociativas[$operacion] = ucfirst($operacion);
            }

            return [
                'categorias' => $categoriasAsociativas,
                'operaciones' => $operacionesAsociativas,
                'rango_precios' => [
                    '0-50000' => '$0 - $50,000',
                    '50000-100000' => '$50,000 - $100,000',
                    '100000-200000' => '$100,000 - $200,000',
                    '200000-500000' => '$200,000 - $500,000',
                    '500000+' => '$500,000+',
                ],
                'opciones_ordenamiento' => [
                    'fecha_creacion_desc' => 'Más recientes primero',
                    'fecha_creacion_asc' => 'Más antiguos primero',
                    'precio_asc' => 'Precio: Menor a Mayor',
                    'precio_desc' => 'Precio: Mayor a Menor',
                    'nombre_asc' => 'Nombre A-Z',
                    'nombre_desc' => 'Nombre Z-A',
                ],
            ];
        });
    }

    /**
     * Formatea los productos de la API al formato que espera el frontend
     */
    private function formatProducts(array $apiProducts): array
    {
        return collect($apiProducts)->map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['nombre'],
                'codigo_inmueble' => $product['codigo_inmueble'] ?? 'N/A',
                'price' => (float) $product['precio'],
                'descripcion' => $product['descripcion'] ?? '',
                'superficie_util' => $product['caracteristicas']['superficie_util'] ?? null,
                'superficie_construida' => $product['caracteristicas']['superficie_construida'] ?? null,
                'ambientes' => $product['caracteristicas']['ambientes'] ?? null,
                'habitaciones' => $product['caracteristicas']['habitaciones'] ?? null,
                'banos' => $product['caracteristicas']['banos'] ?? null,
                'cocheras' => $product['caracteristicas']['cocheras'] ?? null,
                'ano_construccion' => $product['caracteristicas']['ano_construccion'] ?? null,
                'antiguedad' => $product['caracteristicas']['ano_construccion']
                    ? (date('Y') - $product['caracteristicas']['ano_construccion'])
                    : null,
                'operacion' => $product['operacion'],
                'category' => $product['categoria']['nombre'] ?? null,
                'category_id' => $product['categoria']['id'] ?? null,
                'category_name' => $product['categoria']['nombre'] ?? null,
                'is_public' => true, // Asumimos que todos los productos de la API son públicos
                'comision' => $product['comision'] ?? null,
                'imagen_portada' => $product['imagen_portada'] ?? null,
                'images' => collect($product['imagenes'])->map(function ($image) {
                    return [
                        'id' => $image['id'],
                        'image_path' => $image['url'],
                        'original_name' => $image['filename'],
                        'is_primary' => $image['es_portada'] ?? false,
                        'order' => 0,
                        'size' => $image['size'] ?? null,
                    ];
                })->toArray(),
                'agente_captador' => $product['agente_captador'] ?? null,
                'agente_vendedor' => $product['agente_vendedor'] ?? null,
                'fecha_creacion' => $product['fecha_creacion'] ?? null,
                'fecha_actualizacion' => $product['fecha_actualizacion'] ?? null,
                'location' => null, // La API actual no incluye ubicación
            ];
        })->toArray();
    }

    /**
     * Formatea un solo producto
     */
    private function formatSingleProduct(array $apiProduct): array
    {
        $formatted = $this->formatProducts([$apiProduct]);
        return $formatted[0] ?? null;
    }

    /**
     * Genera una clave de cache única
     */
    private function generateCacheKey(?Request $request = null): string
    {
        if (!$request) {
            return 'external_api_products_all';
        }

        $params = $request->only(['page', 'per_page']);
        return 'external_api_products_' . md5(serialize($params));
    }

    /**
     * Limpia el cache de la API
     */
    public function clearCache(): void
    {
        Cache::forget('external_api_products_all');
        Cache::forget('external_api_filter_options');

        // Limpiar cachés específicas (esto podría mejorarse con un sistema de tags)
        $cacheKeys = Cache::get('external_api_cache_keys', []);
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        Cache::forget('external_api_cache_keys');
    }
}