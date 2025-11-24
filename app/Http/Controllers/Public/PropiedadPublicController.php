<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
// use App\Models\Propiedad; // Descomenta cuando tengas el modelo

class PropiedadPublicController extends Controller
{
    /**
     * Muestra el listado público de propiedades
     */
    public function index(): Response
    {
        // Ejemplo: $propiedades = Propiedad::where('estado', 'publicado')->paginate(12);
        
        return Inertia::render('Public/Propiedades/Index', [
            'propiedades' => [], // Aquí irán tus propiedades
            'filtros' => [
                'tipos' => ['Casa', 'Departamento', 'Terreno', 'Local'],
                'ciudades' => ['La Paz', 'Santa Cruz', 'Cochabamba'],
                'rangos_precio' => [
                    ['min' => 0, 'max' => 50000],
                    ['min' => 50000, 'max' => 100000],
                    ['min' => 100000, 'max' => 200000],
                ]
            ]
        ]);
    }

    /**
     * Muestra el detalle de una propiedad específica
     */
    public function show(int $id): Response
    {
        // Ejemplo: $propiedad = Propiedad::findOrFail($id);
        
        return Inertia::render('Public/Propiedades/Show', [
            'propiedad' => [
                'id' => $id,
                'titulo' => 'Casa ejemplo',
                'precio' => 150000,
                'ubicacion' => 'La Paz',
                'descripcion' => 'Descripción de ejemplo',
                'caracteristicas' => [
                    'dormitorios' => 3,
                    'baños' => 2,
                    'area' => 120,
                ],
                'imagenes' => []
            ],
            'relacionadas' => [] // Propiedades relacionadas
        ]);
    }
}