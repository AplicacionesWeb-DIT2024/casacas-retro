<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camiseta extends Model
{
    protected $fillable = [
        'Nombre',
        'Descripción',
        'Precio',
        'Talle',
        'Cantidad',
        'Categoría',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/camisetas/'.$this->getKey());
    }
}
