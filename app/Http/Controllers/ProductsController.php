<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use \DB;
use App\Models\Banner;

class ProductsController extends Controller
{
public function getIndexCreate(){
    $categorias=Category::all();
    return view('productos.create',compact('categorias'));
}
public function getIndexCreateSlider(){
    
    return view('productos.slider');
}

public function create(\Request  $request){

        $destination=public_path('/img/productos').'/'.$_FILES['imagen']['name'];
        $p = new Product();       
        $p->titulo = $request::input('titulo');
        $p->descripcion = $request::input('descripcion');
        $p->detalle = $request::input('detalle');
        $p->imagen ='/img/productos/'.$_FILES['imagen']['name'];
        $p->descuento =$request::input('descuento');
        $p->categorias_id=$request::input('sel_category'); 
        copy($_FILES['imagen']['tmp_name'],$destination);
        $p->save();
        return redirect()->route('administrador');        
}
public function createSlider(\Request  $request){

    $destination=public_path('/img/slider').'/'.$_FILES['imagen']['name'];
    $p = new Banner();       
    $p->titulo = $request::input('titulo');
    $p->subtitulo = $request::input('subtitulo');
    $p->orden = $request::input('orden');
    $p->imagen ='/img/slider/'.$_FILES['imagen']['name'];        
    copy($_FILES['imagen']['tmp_name'],$destination);
    $p->save();
    return redirect()->route('administrador');        
}
 public function getProducts(){
    $c=Product::All();
    $data=[];
    foreach($c as $k=> $vl){
        $data['data'][$k]['id']=$vl->id;
        $data['data'][$k]['categorias_id']=$vl->category->titulo;
        $data['data'][$k]['titulo']=$vl->titulo;
        $data['data'][$k]['descripcion']=$vl->descripcion;
        $data['data'][$k]['detalle']=$vl->detalle;
        $data['data'][$k]['imagen']=$vl->imagen;            
    }
    return json_encode($data);   
 }
 public function getSlider(){
    $c=Banner::All();
    $data=[];
    foreach($c as $k=> $vl){
        $data['data'][$k]['id']=$vl->id;
        $data['data'][$k]['imagen']=$vl->imagen;
        $data['data'][$k]['orden']=$vl->orden;
        $data['data'][$k]['titulo']=$vl->titulo;
        $data['data'][$k]['subtitulo']=$vl->subtitulo;        
    }
    return json_encode($data);
 }

public function deleteProducts($id){
     DB::table('productos')->where('id',$id)->delete();
    return 1;
}

public function deleteSlider($id){
    DB::table('carrousel')->where('id',$id)->delete();
   return 1;
}


}
