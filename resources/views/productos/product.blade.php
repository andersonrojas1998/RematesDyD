@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
   <div class="row">
        <div class="card">       
        <div class="card-body">
            <h5 class="card-title">Administracion de Productos</h5>
            <p class="card-text">Ingrese los productos del almancen.</p>
    <div class="col-lg-12">

    <table class="table" id="table-product">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titulo</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Detalle</th>
      <th scope="col">Imagen</th>
      <th scope="col">Descuento</th>
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

    <script src="{{ asset('/lib/product.js') }}"></script>    

@endpush
