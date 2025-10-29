<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ProductLocation;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'codigo_inmueble',
        'price',
        'superficie_util',
        'superficie_construida',
        'ambientes',
        'habitaciones',
        'banos',
        'cocheras',
        'ano_construccion',
        'operacion',
        'comision',
        'taxes',
        'allow_purchase',
        'is_public',
        'downloadable',
        'downloadable_file',
        'description',
        'category_id',
        'added_by',
        'last_updated_by',
        'hsn_sac_code',
        'default_image',
        // 'unit_id',
        'sku',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'superficie_util' => 'decimal:2',
        'superficie_construida' => 'decimal:2',
        'comision' => 'decimal:2',
        'taxes' => 'decimal:2',
        'allow_purchase' => 'boolean',
        'is_public' => 'boolean',
        'downloadable' => 'boolean',
        'ano_construccion' => 'integer',
    ];

    /**
     * Relación con la categoría del producto
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Usuario que agregó el producto
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    /**
     * Usuario que actualizó por última vez el producto
     */
    public function lastUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    /**
     * Unidad de medida del producto
     */
    // public function unit(): BelongsTo
    // {
    //     return $this->belongsTo(Unit::class, 'unit_id');
    // }

    /**
     * Scope para obtener solo productos públicos
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // /**
    //  * Scope para filtrar por tipo de operación
    //  */
    // public function scopeOperacion($query, $operacion)
    // {
    //     return $query->where('operacion', $operacion);
    // }
    // /**
    //  * Ubicaciones geográficas del producto
    //  */
    // public function locations(): HasMany
    // {
    //     return $this->hasMany(ProductLocation::class);
    // }

    // /**
    //  * Ubicación principal del producto
    //  */
    // public function primaryLocation(): HasOne
    // {
    //     return $this->hasOne(ProductLocation::class)->where('is_primary', true);
    // }

    // /**
    //  * Scope para productos cerca de una ubicación
    //  */
    // public function scopeNearLocation($query, $latitude, $longitude, $radiusInMeters = 5000)
    // {
    //     return $query->whereHas('locations', function ($q) use ($latitude, $longitude, $radiusInMeters) {
    //         $point = "POINT($longitude $latitude)";
    //         $q->whereRaw(
    //             "ST_Distance_Sphere(coordinates, ST_GeomFromText(?)) <= ?",
    //             [$point, $radiusInMeters]
    //         );
    //     });
    // }
}
