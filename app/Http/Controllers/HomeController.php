<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $banners;
    protected $brands;
    protected $categories;
    protected $offers;
    protected $trendProducts;
    protected $newProducts;

    public function __construct()
    {
        $this->loadBanners();
        $this->loadBrands();
        $this->loadCategories();
        $this->loadOffers();
        $this->loadTrendProducts();
        $this->loadNewProducts();
    }

    public function index(){
        $banners = $this->banners;
        $brands = $this->brands;
        $categories = $this->categories;
        $offers = $this->offers;
        $trendProducts = $this->trendProducts;
        $newProducts = $this->newProducts;
        return view('home', compact('banners', 'brands', 'categories', 'offers', 'trendProducts', 'newProducts'));
    }

    protected function loadBanners(){
        $b = new Banner();
        $b->id = 1;
        $b->title = 'Lo mejor para tu cocina';
        $b->subtitle = '10% DE DESCUENTO EN LA PRIMERA COMPRA';
        $b->img = 'img/carousel-1.jpg';
        $b->link = route('shop');
        $b->linkDescription = 'Comprar ahora';

        $this->banners[] = $b;

        $b = new Banner();
        $b->id = 2;
        $b->title = 'Maquillaje de calidad';
        $b->subtitle = '10% DE DESCUENTO EN LA PRIMERA COMPRA';
        $b->img = 'img/carousel-2.jpg';
        $b->link = route('shop');
        $b->linkDescription = 'Ver más';

        $this->banners[] = $b;
    }

    protected function loadBrands(){
        $b = new Brand();
        $b->id = 1;
        $b->img = 'img/vendor-1.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 2;
        $b->img = 'img/vendor-2.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 3;
        $b->img = 'img/vendor-3.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 4;
        $b->img = 'img/vendor-4.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 5;
        $b->img = 'img/vendor-5.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 6;
        $b->img = 'img/vendor-6.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 7;
        $b->img = 'img/vendor-7.jpg';

        $this->brands[] = $b;

        $b = new Brand();
        $b->id = 8;
        $b->img = 'img/vendor-8.jpg';

        $this->brands[] = $b;
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
        $quantityOfProducts = rand(0, 100);

        $c = new Category();
        $c->id = $id;
        $c->name = $name;
        $c->route = route('shop.category', $id);
        $c->quantity = $quantityOfProducts;
        $c->img = $img;

        return $c;
    }

    protected function loadOffers() {
        $o = new Offer();
        $o->id = 1;
        $o->title = 'Juguetería';
        $o->subtitle = '30% EN TODAS LA COMPRAS';
        $o->link = route('shop');
        $o->linkDescription = 'Ver más';
        $o->img = 'img/offer-1.png';

        $this->offers[] = $o;

        $o = new Offer();
        $o->id = 2;
        $o->title = 'Linea de plástico';
        $o->subtitle = '20% EN TODAS LAS COMPRAS';
        $o->link = route('shop');
        $o->linkDescription = 'Comprar ahora';
        $o->img = 'img/offer-2.png';

        $this->offers[] = $o;
    }

    protected function loadProducts(){
        $p = new Product();
        $p->id = 0;
        $p->name = 'Colorful Stylish Shirt 1';
        $p->img = 'img/product-1.jpg';
        $p->discount = 20;
        $p->route = route('detail', ['id'=>1]);

        $array[] = $p;

        $p = new Product();
        $p->id = 1;
        $p->name = 'Colorful Stylish Shirt 2';
        $p->img = 'img/product-2.jpg';
        $p->discount = null;
        $p->route = route('detail', ['id'=>2]);

        $array[] = $p;

        $p = new Product();
        $p->id = 2;
        $p->name = 'Colorful Stylish Shirt 3';
        $p->img = 'img/product-3.jpg';
        $p->discount = 30;
        $p->route = route('detail', ['id'=>3]);

        $array[] = $p;

        $p = new Product();
        $p->id = 3;
        $p->name = 'Colorful Stylish Shirt 4';
        $p->img = 'img/product-4.jpg';
        $p->discount = 0;
        $p->route = route('detail', ['id'=>4]);

        $array[] = $p;

        $p = new Product();
        $p->id = 4;
        $p->name = 'Colorful Stylish Shirt 5';
        $p->img = 'img/product-5.jpg';
        $p->route = route('detail', ['id'=>5]);

        $array[] = $p;

        $p = new Product();
        $p->id = 5;
        $p->name = 'Colorful Stylish Shirt 6';
        $p->img = 'img/product-6.jpg';
        $p->discount = 40;
        $p->route = route('detail', ['id'=>6]);

        $array[] = $p;

        $p = new Product();
        $p->id = 6;
        $p->name = 'Colorful Stylish Shirt 7';
        $p->img = 'img/product-7.jpg';
        $p->discount = 10;
        $p->route = route('detail', ['id'=>7]);

        $array[] = $p;

        $p = new Product();
        $p->id = 7;
        $p->name = 'Colorful Stylish Shirt 8';
        $p->img = 'img/product-8.jpg';
        $p->discount = 50;
        $p->route = route('detail', ['id' => 8]);

        $array[] = $p;

        return $array;
    }

    protected function loadTrendProducts(){
        $this->trendProducts = $this->loadProducts();
    }

    protected function loadNewProducts(){
        $this->newProducts = $this->loadProducts();
    }
}
