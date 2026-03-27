<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $roles = Role::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->withCount('users')
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'nombre' => $role->name,
                    'name' => $role->name,
                    'descripcion' => $role->description,
                    'activo' => $role->is_default ? 1 : 0, // Usando is_default en lugar de status
                    'usuarios_count' => $role->users_count,
                    'created_at' => $role->created_at ? $role->created_at->format('Y-m-d H:i:s') : null,
                ];
            });

        return Inertia::render('Roles', [
            'roles' => $roles->values(),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'activo' => ['boolean'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con este nombre.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        // ✅ Asignación directa
        $role = new Role();
        $role->name = $validated['nombre'];
        $role->description = $validated['descripcion'] ?? null;
        $role->is_default = ($validated['activo'] ?? true) ? 1 : 0;
        $role->save();

        return redirect()->route('admin.roles')->with('success', 'Rol creado correctamente.');
    }

    public function update(Request $request, int $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'activo' => ['boolean'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con este nombre.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
        ]);

        // ✅ Asignación directa
        $role->name = $validated['nombre'];
        $role->description = $validated['descripcion'] ?? null;
        $role->is_default = ($validated['activo'] ?? $role->is_default === 1) ? 1 : 0;
        $role->save();

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function toggleStatus(int $id)
    {
        $role = Role::findOrFail($id);

        // Verificar si el rol tiene usuarios asignados antes de desactivarlo
        $isEnabled = $role->is_default === 1;
        
        if ($isEnabled && $role->users()->count() > 0) {
            return back()->with('error', 'No puedes desactivar un rol que tiene usuarios asignados.');
        }

        $role->is_default = $isEnabled ? 0 : 1;
        $role->save();

        return back()->with('success', $role->is_default === 1 ? 'Rol activado correctamente.' : 'Rol desactivado correctamente.');
    }

    public function destroy(int $id)
    {
        $role = Role::findOrFail($id);

        // Verificar si el rol tiene usuarios asignados
        if ($role->users()->count() > 0) {
            return back()->with('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
        }

        $nombreRole = $role->name; // Usamos name en lugar de display_name
        $role->delete();

        return back()->with('success', "Rol '{$nombreRole}' eliminado correctamente.");
    }
}