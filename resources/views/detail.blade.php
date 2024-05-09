@extends('layout.master')

@section('title', 'Detalle Producto')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Detalle Producto</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}">Inicio</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><a href="{{ route('shop') }}">Tienda</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Detalle Producto</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{ $product->img }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <p class="mb-4">{{ $product->description }}</p>
            <div class="d-flex align-items-center mb-4 pt-2">
                <a href="https://api.whatsapp.com/send?phone=573102086587&text=Hola%20,te%20asesoramos%20por%20whatsapp%20gestiona%20tu%20compra%20por%20este%20canal" title="Chat whatsapp" target="_blank">
                    <button class="d-flex justify-content-center align-items-center btn btn-success px-3">
                        <i class="fab fa-whatsapp fa-2x mr-1" aria-hidden="true"></i>
                        Contactar un asesor
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Descripci&oacute;n</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Descripcion del producto</h4>
                    <p>{{ $product->extended_description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Tambi&eacute;n te puede interesar</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($trendProducts as $product)
                <div class="card product-item border-0">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        @if($product->discount && $product->discount > 0)
                        <p class="text-right w-100 position-absolute">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-certificate fa-stack-2x text-danger"></i>
                                <span class="fa fa-stack-1x text-light">
                                    <span class="align-top" style="font-size: 0.7em;">
                                        {{ $product->discount }}%
                                    </span>
                                </span>
                            </span>
                        </p>
                        @endif
                        <img class="img-fluid w-100" src="{{ $product->img }}" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                    </div>
                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="{{ $product->route }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Ver m&aacute;s
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@stop
