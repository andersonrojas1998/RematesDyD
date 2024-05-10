<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;

class HomeController extends Controller
{
    protected $offers;

    public function __construct()
    {
        $this->loadOffers();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   public function indexLogin()
    {
        return view('auth.login');
    }
    public function indexApp()
    {
        return view('productos.product');
    }

   

   

    public function index(){
        $banners = Banner::orderBy('orden')->get();
        $brands = Brand::all();
        $categories = Category::all();
        foreach($categories as $category){
            $category->quantity = Product::select('productos.categorias_id')
            ->join('categorias AS c', 'c.id', 'productos.categorias_id')
            ->where(
                'productos.categorias_id',
                $category->id
                )->get()->count();
        }
        $offers = $this->offers;
        $trendProducts = Product::getOffers();
        $newProducts = Product::getNewProducts();
        return view('home', compact('banners', 'brands', 'categories', 'offers', 'trendProducts', 'newProducts'));
    }

    protected function loadOffers() {
        $category = Category::all()->random();
        $o = new Offer();
        $o->id = $category->id;
        $o->title = $category->titulo;
        $o->subtitle = 'GRANDES DESCUENTOS';
        $o->link = $category->route;
        $o->linkDescription = 'Ver más';
        $o->img = $category->imagen;

        $this->offers[] = $o;

        do{
            $category = Category::all()->random();
        }while($category->id == $o->id);

        $o = new Offer();
        $o->id = $category->id;
        $o->title = $category->titulo;
        $o->subtitle = 'OFERTAS INCREIBLES';
        $o->link = $category->route;
        $o->linkDescription = 'Comprar ahora';
        $o->img = $category->imagen;

        $this->offers[] = $o;
    }
}
