@extends('layouts.app')

@section('content')



<div class="container mt-4">
   
    <div class="card pt-2" > 
          
        <div class="card-body">
            <h5 class="card-title text-center text-success">Crecion de Slider Panel Principal</h5>
            <p class="card-text">Ingrese los productos del almacen.</p>


            <form  action="{{ url('prd-submit-slider') }}" enctype="multipart/form-data" method="post">
            @csrf
           <div class="row m-2">               
                <div class="col-lg-6">
                <strong>Titulo :  <span class="text-danger">*</span></strong>
                <input class="form-control" name="titulo" type="text"  placeholder="Ingrese Titulo" >                    
                </div>
                <div class="col-lg-6">
                    <strong>Subtitulo:</strong>
                    <input  class="form-control" type="text" name="subtitulo" placeholder="Ingrese Descripcion">
                </div>                        
                
            <br>
            <div class="row pt-3">               
                        
                <div class="col-lg-6">
                    <strong>Imagen:</strong>
                    <input  class="form-control" type="file" name="imagen">
                </div>            

                <div class="col-lg-6">
                    <strong>Orden:</strong>
                    <input  class="form-control" type="number" name="orden" placeholder="Ingrese Orden">
                </div>                        
                
            <div class="col-lg-4 offset-4 pt-5">
                    <button type="submit" class="btn btn-success btn-block"  style="border-radius:5px;">Registrar  <i class="mdi mdi-content-save"></i></button>
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
