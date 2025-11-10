<?php

namespace App\Traits;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCompany
{
    /**
     * Boot the HasCompany trait.
     */
    protected static function bootHasCompany(): void
    {
        // COMENTAR temporalmente para diagnosticar
        // static::addGlobalScope(new CompanyScope());

        static::creating(function ($model) {
            if (auth()->check() && empty($model->company_id)) {
                $model->company_id = auth()->user()->company_id;
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope a query to only include records for a specific company.
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope a query to only include records for the current user's company.
     */
    public function scopeForCurrentCompany($query)
    {
        if (auth()->check() && !empty(auth()->user()->company_id)) {
            return $query->where('company_id', auth()->user()->company_id);
        }

        return $query;
    }
}