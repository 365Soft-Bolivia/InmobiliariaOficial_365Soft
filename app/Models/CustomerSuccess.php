<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSuccess extends Model
{
    use HasFactory;

    protected $table = 'customer_success';

    protected $fillable = [
        'product_id',
        'captador_client_id',
        'vendedor_client_id',
        'captador_id',
        'sales_agent_id',
        'captador_date',
        'sale_date',
        'price',
        'comission',
        'metodo_pago'
    ];

    /**
     * Relación: CustomerSuccess pertenece a un Producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // public function salesAgent()
    // {
    //     return $this->belongsTo(Product::class, 'salesAgent_id');
    // }

    public function userAgent()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }
}
