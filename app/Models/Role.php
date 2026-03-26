<?php

namespace App\Models;

use App\Traits\HasCompany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasCompany;

    // Spatie ya maneja todo, solo agregamos el trait HasCompany
    // Los campos fillable ya están definidos en Spatie Role
    protected $fillable = ['name', 'guard_name', 'is_default'];

    // Ya no necesitamos la función users() porque Spatie la maneja automáticamente
}