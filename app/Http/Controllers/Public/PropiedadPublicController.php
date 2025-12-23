<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\ExternalPropertyFilterService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PropiedadPublicController extends Controller
{
    private ExternalPropertyFilterService $filterService;

    public function __construct(ExternalPropertyFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * Muestra el listado público de propiedades con filtros optimizados
     */
    public function index(Request $request): Response
    {
        try {
            $data = $this->filterService->applyFilters($request);

            return Inertia::render('Public/Propiedades/Index', [
                'propiedades' => $data['propiedades'],
                'pagination' => $data['pagination'],
                'filter_options' => $data['filter_options'],
                'filtros' => $data['filters_applied'],
            ]);
        } catch (\Exception $e) {
            // Log del error
            \Log::error('Error al obtener productos de la API externa: ' . $e->getMessage());

            // Mostrar vista con mensaje de error pero manteniendo la estructura
            return Inertia::render('Public/Propiedades/Index', [
                'propiedades' => [],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 12,
                    'total' => 0,
                    'from' => 0,
                    'to' => 0,
                ],
                'filter_options' => [
                    'categorias' => [],
                    'operaciones' => [],
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
                ],
                'filtros' => [],
                'error' => 'No se pudieron cargar las propiedades en este momento. Por favor, intente más tarde.',
            ]);
        }
    }

    /**
     * Vista del mapa interactivo con todas las propiedades públicas
     */
    public function mapa(): Response
    {
        try {
            $productsConUbicacion = $this->filterService->getProductsForMap();

            // Obtener categorías disponibles
            $filterOptions = $this->filterService->getFilterOptions();
            $categoriasDisponibles = array_keys($filterOptions['categorias'] ?? []);

            return Inertia::render('Public/Propiedades/Mapa', [
                'productsConUbicacion' => $productsConUbicacion,
                'categoriasDisponibles' => $categoriasDisponibles,
                'defaultCenter' => [
                    'lat' => -16.5000, // La Paz, Bolivia (centro del país)
                    'lng' => -68.1500,
                ],
                'totalPropiedades' => count($productsConUbicacion),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener productos para el mapa: ' . $e->getMessage());

            return Inertia::render('Public/Propiedades/Mapa', [
                'productsConUbicacion' => [],
                'categoriasDisponibles' => [],
                'defaultCenter' => [
                    'lat' => -16.5000,
                    'lng' => -68.1500,
                ],
                'totalPropiedades' => 0,
                'error' => 'No se pudieron cargar las propiedades para el mapa en este momento.',
            ]);
        }
    }

    /**
     * Muestra el detalle de una propiedad específica
     */
    public function show(int $id): Response
    {
        try {
            $propiedad = $this->filterService->getProductById($id);

            if (!$propiedad) {
                abort(404, 'Propiedad no encontrada');
            }

            // Obtener propiedades relacionadas
            $relacionadas = $this->filterService->getRelatedProperties(
                $id,
                $propiedad['category_id']
            );

            // Formatear agente para el frontend
            $agente = $propiedad['agente_captador'] ? [
                'id' => $propiedad['agente_captador']['id'],
                'name' => $propiedad['agente_captador']['nombre'],
                'email' => $propiedad['agente_captador']['email'],
                'phone' => null, // La API no incluye teléfono
            ] : null;

            // Formatear fecha de creación
            $createdAt = $propiedad['fecha_creacion'];
            if ($createdAt) {
                $date = new \DateTime($createdAt);
                $createdAtFormatted = $date->format('d/m/Y');
            } else {
                $createdAtFormatted = 'N/A';
            }

            return Inertia::render('Public/Propiedades/Show', [
                'propiedad' => [
                    'id' => $propiedad['id'],
                    'name' => $propiedad['name'],
                    'codigo_inmueble' => $propiedad['codigo_inmueble'],
                    'price' => $propiedad['price'],
                    'descripcion' => $propiedad['descripcion'],
                    'direccion' => null, // La API actual no incluye dirección
                    'superficie_util' => $propiedad['superficie_util'],
                    'superficie_construida' => $propiedad['superficie_construida'],
                    'ambientes' => $propiedad['ambientes'],
                    'habitaciones' => $propiedad['habitaciones'],
                    'banos' => $propiedad['banos'],
                    'cocheras' => $propiedad['cocheras'],
                    'ano_construccion' => $propiedad['ano_construccion'],
                    'antiguedad' => $propiedad['antiguedad'],
                    'operacion' => $propiedad['operacion'],
                    'category' => $propiedad['category_name'],
                    'is_public' => $propiedad['is_public'],
                    'comision' => $propiedad['comision'],
                    'created_at' => $createdAtFormatted,
                    'images' => $propiedad['images'],
                    'location' => $propiedad['location'], // Será null hasta que la API incluya ubicación
                    'agente' => $agente,
                ],
                'relacionadas' => $relacionadas,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener detalle de propiedad: ' . $e->getMessage());

            if ($e->getCode() === 404) {
                abort(404, 'Propiedad no encontrada');
            }

            abort(500, 'Error al cargar la propiedad');
        }
    }
}