<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talle extends Model
{
    protected $fillable = ['Talle', 'Ancho', 'Altura',];
    
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
            if (!in_array($model->Talle, $sizes)) {
                throw new \Exception('Talle no valido');
            }
        });
    }
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/talles/'.$this->getKey());
    }
}
