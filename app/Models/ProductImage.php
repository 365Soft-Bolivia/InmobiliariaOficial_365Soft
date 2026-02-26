<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'original_name',
        'is_primary',
        'order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
    ];

    // ✅ NO usar appends, manejarlo en el controlador

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ✅ Eliminar archivo físico al borrar el registro (solo locales, no URLs externas)
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Solo intentar eliminar si NO es una URL externa
            if (!str_starts_with($image->image_path, 'http')) {
                try {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                } catch (\Exception $e) {
                    // Silenciar error si no se puede acceder al storage (Railway)
                }
            }
        });
    }
}