<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio pública
     */
    public function index(): Response
    {
        return Inertia::render('Public/Home', [
            'featured_properties' => [], // Aquí cargarás propiedades destacadas después
            'stats' => [
                'total_propiedades' => 0,
                'ciudades' => 0,
                'clientes_satisfechos' => 0,
            ]
        ]);
    }
}