<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index($byCategory = 0, $search = null){

        $products = Product::all();

        foreach ($products as $product) {
            $product->category;
        }

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

        return view('shop', compact('categories', 'products', 'byCategory', 'search'));
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

    public function search(Request $request){
        return $this->index(0, $request->all()['query']);
    }
}
