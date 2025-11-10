<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Check if model has company method which comes from HasCompany Trait.
        // If that has method then it has company otherwise it do not have company id
        // and we can simply return from here
        if (!method_exists($model, 'company')) {
            return $builder;
        }

        // When user is logged in
        // CORRECCIÓN: Usar Auth::check() en lugar de auth()->hasUser()
        if (Auth::check()) {
            $user = Auth::user();
            
            // CORRECCIÓN: Obtener company_id del usuario en lugar de usar company()
            $companyId = $user->company_id;

            // We are not checking if table has company_id or not to avoid extra queries.
            // We need to be extra careful with migrations we have created. For all the migration when doing something with update
            // we need to add withoutGlobalScope(CompanyScope::class)
            // Otherwise we will get the error of company_id not found when application is updating or modules are installing

            if ($companyId) {
                $table = $model->getTable();

                // Excepción: Productos públicos visibles para todas las empresas
                if ($model instanceof \App\Models\Product) {
                    $builder->where(function ($q) use ($table, $companyId) {
                        $q->where($table . '.company_id', '=', $companyId)
                          ->orWhere($table . '.is_public', 1);
                    });
                } else {
                    $builder->where($table . '.company_id', '=', $companyId);
                }
            }
        }
    }
}