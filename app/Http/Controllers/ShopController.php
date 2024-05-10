<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index($byCategory = 0){

        $products = Product::all();

        $categories = Category::all();

        foreach($categories as $category){
            $category->route = route('shop.category', $category->id);
            $category->quantity = Product::select('productos.categorias_id')
            ->join('categorias AS c', 'c.id', 'productos.categorias_id')
            ->where(
                'productos.categorias_id',
                $category->id
                )->get()->count();
        }

        return view('shop', compact('categories', 'products', 'byCategory'));
    }

    public function show(Product $product){
        $categories = Category::all();
        foreach($categories as $category){
            $category->route = route('shop.category', $category->id);
            $category->quantity = Product::select('productos.categorias_id')
            ->join('categorias AS c', 'c.id', 'productos.categorias_id')
            ->where(
                'productos.categorias_id',
                $category->id
                )->get()->count();
        }

        $trendProducts = Product::getOffers();

        return view('detail', compact('categories','product', 'trendProducts'));
    }

    public function productsByCategory($category){
        /*if($category != -1){
            $products = [];

            foreach ($this->products as $product) {
                if($product['category'] == $category){
                    $products[] = $product;
                }
            }
            return response()->json($products);
        }else{
            return response()->json($this->products);
        }*/
    }
}
