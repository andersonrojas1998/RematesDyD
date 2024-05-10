<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $append = ['route'];

    public function product(){
        return $this->belongsTo('\App\Models\Product', 'categorias_id', 'id');
    }

    public function getRouteAttribute(){
        return route('shop.category', $this->id);
    }

    public function getImagenAttribute($value){
        return asset($value);
    }
}
