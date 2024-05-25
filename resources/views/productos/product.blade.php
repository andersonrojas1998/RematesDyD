@extends('layouts.app')

@section('content')
<div class="container mt-4">
   <div class="row">
         <div class="card"> 
          <div class="card-header">
            <div class="d-flex justify-content-lg-end">
            <a class="btn btn-primary" href="{{ url('/products/create-product')}}">Crear Producto  </a>
            </div>            
          </div>      
        <div class="card-body">
            <h5 class="card-title">Administracion de Productos</h5>
            <p class="card-text">Ingrese los productos del almacen.</p>
    <div class="col-lg-12">
    <table class="table" id="table-product">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th>Categoria</th>
      <th scope="col">Titulo</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Detalle</th>
      <th scope="col">Imagen</th>
      <th scope="col">Descuento</th>
      <th></th>
    </tr>
  </thead>
  <tbody>   
  </tbody>
</table>                        
        </div>
        </div>
        </div>
</div>
</div>
<!-- Modal -->
<div class="container mt-4">
   <div class="row ">
         <div class="card col-lg-12"> 
         <div class="card-header">
            <div class="d-flex justify-content-lg-end">
            <a class="btn btn-primary" href="{{ url('/products/create-slider')}}">Crear Slider  </a>
            </div>            
          </div> 

          <div class="card-body">
            <h5 class="card-title">Administracion de Productos Panel Inicial</h5>
            <p class="card-text">Ingrese los productos del almacen en descuentos o promociones .</p>
    <div class="col-lg-12">
    <table class="table" id="table-slider">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th>Imagen</th>
      <th scope="col">Titulo</th>
      <th scope="col">Subtitulo</th>            
      <th></th>
    </tr>
  </thead>
  <tbody>   
  </tbody>
</table>                        
        </div>
        </div>



          </div>
</div>
</div>

@endsection


@push('scripts')

    <script src="{{ asset('/lib/home.js') }}"></script>    

@endpush
