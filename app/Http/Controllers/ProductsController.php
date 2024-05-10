<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductsController extends Controller
{
public function getIndexCreate(){
    return view('productos.create');
}
public function create(\Request  $request){

    //dd("ddd");
    $destination=public_path('/img').'/'.$_FILES['imagen']['name'];
    //dd($_FILES['imagen']['name']);

        $p = new Product();       
        $p->titulo = $request::input('titulo');
        $p->descripcion = $request::input('descripcion');
        $p->detalle = $request::input('detalle');
        $p->imagen ='/img/'.$_FILES['imagen']['name'];
        $p->descuento =$request::input('descuento');
        $p->categorias_id=$request::input('categorias_id'); 
        copy($_FILES['imagen']['tmp_name'],$destination);
        $p->save();
        return redirect()->route('administrador');



        
}



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
