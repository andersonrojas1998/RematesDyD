<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $appends = ['route'];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'categorias_id');
    }

    public function getRouteAttribute(){
        return route('detail', ['product' => $this->id]);
    }

    public static function getOffers(){
        return Product::orderBy('descuento', 'DESC')->take(8)->get();
    }

    public static function getNewProducts(){
        return Product::orderBy('created_at', 'DESC')->take(8)->get();
    }

    public function getImagenAttribute($value){
        return asset($value);
    }
}
