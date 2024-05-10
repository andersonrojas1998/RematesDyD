<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(ShopController::class)->group(function(){
    Route::get('/tienda', 'index')->name('shop');
    Route::get('/tienda/{category}', 'index')->name('shop.category');
    Route::get('/productsByCategory/{id}', 'productsByCategory')->name('productsByCategory');
    Route::get('/detalle/{id}', 'show')->name('detail');
});
Route::get('/LoginPage', [HomeController::class, 'indexLogin']);



Auth::routes();
Route::get('/administrador', [HomeController::class, 'indexApp'])->name('administrador');


Route::group(['prefix' => 'products'], function(){
    Route::get('/list', [ProductsController::class, 'getProducts']);
    Route::get('/create-product', [ProductsController::class, 'getIndexCreate']);
});

Route::post('prd-submit', [ProductsController::class, 'create']);
Route::get('/delete-product/{id}', [ProductsController::class, 'deleteProducts']);


 

