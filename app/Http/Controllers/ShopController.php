<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $products;
    protected $categories;
    protected $trendProducts;

    public function __construct()
    {
        $this->loadProducts();

        $this->loadCategories();
    }

    public function index($byCategory = 0){

        $products = $this->products;

        $categories = $this->categories;

        return view('shop', compact('categories', 'products', 'byCategory'));
    }

    public function show($product){
        $categories = $this->categories;

        $product = $this->products[$product];

        $this->loadTrendProducts();

        $trendProducts = $this->trendProducts;

        return view('detail', compact('categories','product', 'trendProducts'));
    }

    public function productsByCategory($category){
        if($category != -1){
            $products = [];

            foreach ($this->products as $product) {
                if($product['category'] == $category){
                    $products[] = $product;
                }
            }
            return response()->json($products);
        }else{
            return response()->json($this->products);
        }
    }

    protected function loadProducts(){

        $this->products[] = $this->storeProduct(0, 1, 'Colorful Stylish Shirt 1', asset('img/product-1.jpg'), 10);

        $this->products[] = $this->storeProduct(1, 2, 'Colorful Stylish Shirt 2', asset('img/product-2.jpg'));

        $this->products[] = $this->storeProduct(2, 3, 'Colorful Stylish Shirt 3', asset('img/product-3.jpg'),20);

        $this->products[] = $this->storeProduct(3, 4, 'Colorful Stylish Shirt 4', asset('img/product-4.jpg'), 50);

        $this->products[] = $this->storeProduct(4, 5, 'Colorful Stylish Shirt 5', asset('img/product-5.jpg'), 30);

        $this->products[] = $this->storeProduct(5, 6, 'Colorful Stylish Shirt 6', asset('img/product-6.jpg'), 0);

        $this->products[] = $this->storeProduct(6, 7, 'Colorful Stylish Shirt 7', asset('img/product-7.jpg'), 40);

        $this->products[] = $this->storeProduct(7, 1, 'Colorful Stylish Shirt 8', asset('img/product-8.jpg'), 25);

        $this->products[] = $this->storeProduct(8, 2, 'Colorful Stylish Shirt 9', asset('img/product-1.jpg'), 35);
    }

    protected function storeProduct($id, $category, $name, $img, $discount = null) {
        $p = new Product();
        $p->id = $id;
        $p->category = $category;
        $p->name = $name;
        $p->description = 'Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet '
        . 'sit clita ea. Sanc invidunt ipsum et, labore clita lorem magna lorem ut. Erat'
        . 'lorem duo dolor no sea nonumy. Accus labore stet, est lorem sit diam sea et'
        . 'justo, amet at lorem et eirmod ipsum diam et rebum kasd rebum.';
        $p->extended_description = 'Volup erat ipsum diam elitr rebum et dolor. Est nonumy elitr erat diam stet '
        . 'sit clita ea. Sanc invidunt ipsum et, labore clita lorem magna lorem ut. Erat'
        . 'lorem duo dolor no sea nonumy. Accus labore stet, est lorem sit diam sea et'
        . 'justo, amet at lorem et eirmod ipsum diam et rebum kasd rebum.';
        $p->img = $img;
        $p->route = route('detail', ['id'=>$id]);
        $p->discount = $discount;

        return $p;
    }

    protected function loadCategories() {

        $this->categories[] = $this->storeCategory(1, 'Accesorios para vehiculo', asset('img/cat-1.jpg'));

        $this->categories[] = $this->storeCategory(2, 'Belleza', asset('img/cat-2.jpg'));

        $this->categories[] = $this->storeCategory(3, 'Bienestar', asset('img/cat-3.jpg'));

        $this->categories[] = $this->storeCategory(4, 'Cocina', asset('img/cat-4.jpg'));

        $this->categories[] = $this->storeCategory(5, 'Hogar', asset('img/cat-5.jpg'));

        $this->categories[] = $this->storeCategory(6, 'Mascotas', asset('img/cat-6.jpg'));

        $this->categories[] = $this->storeCategory(7, 'Juguetería', asset('img/cat-7.jpg'));
    }

    protected function storeCategory($id, $name, $img){
        $quantityOfProducts = 0;

        foreach($this->products as $product){
            if($product->category == $id){
                $quantityOfProducts++;
            }
        }

        $c = new Category();
        $c->id = $id;
        $c->name = $name;
        $c->route = route('shop.category', $id);
        $c->quantity = $quantityOfProducts;
        $c->img = $img;

        return $c;
    }

    protected function loadTrendProducts(){
        $this->trendProducts = $this->products;
    }
}
