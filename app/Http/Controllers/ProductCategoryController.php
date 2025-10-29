<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{
    public function index()
    {
        // Traer todas las categorías (puedes paginar con ->paginate(10) si quieres)
        $categories = ProductCategory::orderBy('id','asc')->get();

        // Retornar Inertia al componente 'Categorias' pasándole las categorías
        return Inertia::render('Categorias', [
            'categories' => $categories
        ]);
    }
}
