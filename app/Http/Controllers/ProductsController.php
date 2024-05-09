<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductsController extends Controller
{



 public function getProducts(){


    

    $c=Product::All();

    $data=[];
    foreach($c as $k=> $vl){
        $data['data'][$k]['id']=$vl->id;
        $data['data'][$k]['titulo']=$vl->titulo;
        $data['data'][$k]['descripcion']=$vl->descripcion;
        $data['data'][$k]['detalle']=$vl->detalle;
        $data['data'][$k]['imagen']=$vl->imagen;            
    }
    return json_encode($data);


 }
}
