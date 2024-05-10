<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use \DB;

class ProductsController extends Controller
{
public function getIndexCreate(){
    $categorias=Category::all();
    return view('productos.create',compact('categorias'));
}
public function create(\Request  $request){

        $destination=public_path('/img').'/'.$_FILES['imagen']['name'];
        $p = new Product();       
        $p->titulo = $request::input('titulo');
        $p->descripcion = $request::input('descripcion');
        $p->detalle = $request::input('detalle');
        $p->imagen ='/img/'.$_FILES['imagen']['name'];
        $p->descuento =$request::input('descuento');
        $p->categorias_id=$request::input('sel_category'); 
        copy($_FILES['imagen']['tmp_name'],$destination);
        $p->save();
        return redirect()->route('administrador');        
}
 public function getProducts(){
    $c=Product::All();
    $data=[];
    foreach($c as $k=> $vl){
        $data['data'][$k]['id']=$vl->id;
        $data['data'][$k]['categorias_id']=$vl->categorias_id;
        $data['data'][$k]['titulo']=$vl->titulo;
        $data['data'][$k]['descripcion']=$vl->descripcion;
        $data['data'][$k]['detalle']=$vl->detalle;
        $data['data'][$k]['imagen']=$vl->imagen;            
    }
    return json_encode($data);
 }

public function deleteProducts($id){
     DB::table('productos')->where('id',$id)->delete();
    return 1;


}

}
