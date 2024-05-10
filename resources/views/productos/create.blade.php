@extends('layouts.app')

@section('content')



<div class="container mt-4">
   
    <div class="card pt-2" > 
          
        <div class="card-body">
            <h5 class="card-title">Crecion de Productos</h5>
            <p class="card-text">Ingrese los productos del almacen.</p>


            <form  action="{{ url('prd-submit') }}" enctype="multipart/form-data" method="post">
            @csrf
           <div class="row m-2">               
                <div class="col-lg-6">
                <strong>Titulo :  <span class="text-danger">*</span></strong>
                <input class="form-control" name="titulo" type="text"  placeholder="Ingrese Titulo" >                    
                </div>
                <div class="col-lg-6">
                    <strong>Descripcion corta:</strong>
                    <input  class="form-control" type="text" name="descripcion" placeholder="Ingrese Descripcion">
            </div>                        
            <br>
            <div class="row pt-3">               
                <div class="col-lg-6">
                <strong>Detalle :  <span class="text-danger">*</span></strong>
                <textarea   class="form-control" id="detalle" name="detalle" rows="7" cols="70"></textarea>
                </div>
                <div class="col-lg-3">
                    <strong>Descuento:</strong>
                    <input  class="form-control" type="number" name="descuento">
                </div>            
                <div class="col-lg-3">
                    <strong>Imagen:</strong>
                    <input  class="form-control" type="file" name="imagen">
                </div>            
            <div class="col-lg-4 offset-4 pt-5">
                    <button type="submit" class="btn btn-success btn-block"  style="border-radius:5px;">Registrar Producto  <i class="mdi mdi-content-save"></i></button>
                </div> 
            
            


    </div>


    

    </form>
        </div>
        </div>

</div>


<!-- Modal -->


@endsection


@push('scripts')

    <script src="{{ asset('/lib/home.js') }}"></script>    

@endpush
