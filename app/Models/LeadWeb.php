<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadWeb extends Model
{
    protected $table = 'lead_web';

    public $timestamps = false; // Solo tienes created_at

    protected $fillable = [
        'lead_id',
        'is_web',
    ];
}
