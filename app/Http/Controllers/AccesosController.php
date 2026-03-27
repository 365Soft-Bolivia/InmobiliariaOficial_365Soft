<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class AccesosController extends Controller
{
    public function __construct()
    {
        \Log::info('🔔 AccesosController instanciado');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $usuarios = User::withoutGlobalScope(\App\Scopes\ActiveScope::class)
        ->with('roles')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('roles', function ($roleQuery) use ($search) {
                            $roleQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => $user->status,
                    'estado' => $user->status === 'active' ? 1 : 0,
                    'role' => $user->roles->first() ? [
                        'id' => $user->roles->first()->id,
                        'nombre' => $user->roles->first()->name,
                        'name' => $user->roles->first()->name,
                        // 'descripcion' => $user->roles->first()->description, // Comentado: campo no existe en tabla roles
                    ] : null,
                    'roles' => $user->roles->map(function ($role) {
                        return [
                            'id' => $role->id,
                            'name' => $role->name,
                            // 'display_name' => $role->display_name, // Comentado: campo no existe en tabla roles
                        ];
                    }),
                    'created_at' => $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : null,
                ];
            });

        $roles = Role::orderBy('name')->get()->map(function ($role) {
            return [
                'id' => $role->id,
                'nombre' => $role->name,
                'name' => $role->name,
                // 'descripcion' => $role->description, // Comentado: campo no existe en tabla roles
            ];
        });

        return Inertia::render('Accesos', [
            'usuarios' => $usuarios->values(),
            'roles' => $roles,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

  public function store(Request $request)
{
    \Log::info('===== MÉTODO STORE EJECUTÁNDOSE =====');
    \Log::info('Datos completos del request:', $request->all());
    \Log::info('Archivos en request:', $request->allFiles());

    \Log::info(' Datos recibidos para crear usuario:', $request->all());

    // La validación se maneja automáticamente por Laravel
    // Si falla, Laravel lanza una ValidationException que Inertia detecta automáticamente
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role_id' => ['required', 'exists:roles,id'],
        // 'company_id' => ['nullable', 'integer', 'exists:companies,id'], // Comentado: tabla companies no existe
        'gender' => ['nullable', 'in:male,female,other'],
    ]);

    \Log::info('✅ Validación exitosa:', $validated);

    try {
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->status = 'active';
        // $user->company_id = $validated['company_id'] ?? 1; // Comentado: tabla companies no existe
        $user->dark_theme = 0;
        $user->rtl = 0;
        $user->email_notifications = 1;
        $user->gender = $validated['gender'] ?? 'male';
        $user->locale = 'es';
        // Usar un valor único basado en el email para evitar duplicados en el campo login
        $user->login = 'enable_' . md5($validated['email'] . time());

        \Log::info('💾 Intentando guardar usuario...', ['name' => $user->name, 'email' => $user->email]);

        $user->save();

        \Log::info('✅ Usuario creado con ID: ' . $user->id);

        $user->roles()->attach($validated['role_id']);

        \Log::info('✅ Rol asignado correctamente');

        \Log::info('🔄 Redirigiendo a admin.accesos con éxito...');

        return redirect()->route('admin.accesos')->with('success', 'Usuario creado correctamente.');

    } catch (\Exception $e) {

        \Log::error(' Error al crear usuario:', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        // Redirigir con el mensaje de error
        return redirect()->route('admin.accesos')
            ->with('error', 'Error al crear el usuario: ' . $e->getMessage());
    }
}

    public function update(Request $request, int $id)
    {
        try {
            $user = User::findOrFail($id);

            \Log::info(' Actualizando usuario ID: ' . $id, $request->all());

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
                'role_id' => ['required', 'exists:roles,id'],
                // 'company_id' => ['nullable', 'integer', 'exists:companies,id'], // Comentado: tabla companies no existe
                'gender' => ['nullable', 'in:male,female,other'],
                'status' => ['nullable', 'in:active,deactive'], // Validación corregida
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            // $user->company_id = $validated['company_id'] ?? $user->company_id; // Comentado: tabla companies no existe
            $user->gender = $validated['gender'] ?? $user->gender;
            $user->status = $validated['status'] ?? $user->status;

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            $user->roles()->sync([$validated['role_id']]);

            \Log::info(' Usuario actualizado correctamente');

            return back()->with('success', 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            \Log::error('💥 Error al actualizar usuario:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
            return back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function toggleStatus(int $id)
{
    try {
        $user = User::withoutGlobalScope(\App\Scopes\ActiveScope::class)
            ->findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiar el estado de tu propia cuenta.');
        }

        $nuevoEstado = $user->status === 'active' ? 'deactive' : 'active';
        $user->status = $nuevoEstado;
        $user->save();

        return back()->with('success', $nuevoEstado === 'active' ? 'Usuario activado.' : 'Usuario desactivado.');
        
    } catch (\Exception $e) {
        \Log::error('Error al cambiar estado:', [
            'user_id' => $id,
            'error' => $e->getMessage()
        ]);
        
        return back()->with('error', 'Error al cambiar el estado del usuario.');
    }
}

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $nombreUsuario = $user->name;
        $user->roles()->detach();
        $user->delete();

        return back()->with('success', "Usuario {$nombreUsuario} eliminado correctamente.");
    }
}