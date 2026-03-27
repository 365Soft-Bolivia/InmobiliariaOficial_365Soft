<?php

namespace App\Models;

// use App\Traits\HasCompany; // Comentado: tabla companies no existe en este sistema
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // use HasCompany; // Comentado: tabla companies no existe en este sistema

    // Spatie ya maneja todo
    // Los campos fillable ya están definidos en Spatie Role
    protected $fillable = ['name', 'guard_name', 'is_default', 'description'];

    // Ya no necesitamos la función users() porque Spatie la maneja automáticamente
}