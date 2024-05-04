@extends('layout.master')

@section('title', 'Inicio')

@section('carousel')

<div class="col-lg-12">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $key => $banner)
            <div class="carousel-item {{ ($key == 0)? 'active':'' }}" style="height: 410px;">
                <img class="img-fluid" src="{{ $banner->img }}" alt="{{ $banner->title }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 700px;">
                        <h4 class="text-light text-uppercase font-weight-medium mb-3">
                            {{ $banner->subtitle }}
                        </h4>
                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">{{ $banner->title }}</h3>
                        <a href="{{ $banner->link }}" class="btn btn-light py-2 px-3">{{ $banner->linkDescription }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon mb-n2"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#header-carousel" data-slide="next">
            <div class="btn btn-dark" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon mb-n2"></span>
            </div>
        </a>
    </div>
</div>
@endsection

@section('content')

<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Categor&iacute;as</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <div class="col">
            <div class="owl-carousel category-carousel">
                @foreach($categories as $category)
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <p class="text-right">{{ $category->quantity }} Productos</p>
                        <a href="{{ $category->route }}" class="cat-img position-relative overflow-hidden mb-3">
                            <img
                            class="img-fluid"
                            src="{{ $category->img }}"
                            alt="{{ $category->name }}"
                            style="height: 16.3em;"
                            >
                        </a>
                        <h5 class="font-weight-semi-bold m-0">{{ $category->name }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Categories End -->


<!-- Offer Start -->
<div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                <img src="{{ $offers[0]->img }}" alt="{{ $offers[0]->title }}">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">{{ $offers[0]->subtitle }}</h5>
                    <h1 class="mb-4 font-weight-semi-bold">{{ $offers[0]->title }}</h1>
                    <a href="{{ $offers[0]->link }}" class="btn btn-outline-primary py-md-2 px-md-3">
                        {{ $offers[0]->linkDescription }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                <img src="{{ $offers[1]->img }}" alt="{{ $offers[1]->title }}">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">{{ $offers[1]->subtitle }}</h5>
                    <h1 class="mb-4 font-weight-semi-bold">{{ $offers[1]->title }}</h1>
                    <a href="{{ $offers[1]->link }}" class="btn btn-outline-primary py-md-2 px-md-3">
                        {{ $offers[1]->linkDescription }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Productos en tendencia</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach($trendProducts as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
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
        </div>
        @endforeach
    </div>
</div>
<!-- Products End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Lo m&aacute;s nuevo</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($newProducts as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ $product->img }}" alt="{{ $product->name }}">
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
        </div>
        @endforeach
    </div>
</div>
<!-- Products End -->


<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                @foreach($brands as $brand)
                <div class="vendor-item border p-4">
                    <img src="{{ $brand->img }}" alt="">
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->

@endsection
