@extends('layout.master')

@section('title', 'Tienda')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Nuestra tienda</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}">Inicio</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Tienda</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Category Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filtrar por categor&iacute;a</h5>
                <div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio"
                        name="category"
                        class="custom-control-input radio-category"
                        checked
                        id="all-categories"
                        value="-1"
                        data-url="{{ route('productsByCategory', -1) }}">
                        <label class="custom-control-label" for="all-categories">Todas las categor&iacute;as</label>
                        <?php
                        $numOfProducts = 0;

                        foreach($categories as $category){
                            $numOfProducts += $category->quantity;
                        }
                        ?>
                        <span class="badge border font-weight-normal">{{ $numOfProducts }}</span>
                    </div>
                    @foreach ($categories as $category)
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input
                        type="radio"
                        name="category"
                        class="custom-control-input radio-category"
                        value="{{ $category->id }}"
                        id="radio-category-{{ $category->id }}"/>
                        <label class="custom-control-label" for="radio-category-{{ $category->id }}">
                            {{ $category->titulo }}</label>
                        <span class="badge border font-weight-normal">{{ $category->quantity }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Category End -->

            <!-- Off Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filtrar por descuento</h5>
                <div id="discount-filter"></div>
            </div>
            <!-- Off End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchProduct" placeholder="Buscar por nombre">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="dropdown ml-4">
                            <button
                            class="btn border dropdown-toggle"
                            type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Listar
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item numOfListedElements" data-value="15">15</a>
                                <a class="dropdown-item numOfListedElements" data-value="30">30</a>
                                <a class="dropdown-item numOfListedElements" data-value="60">60</a>
                                <a class="dropdown-item numOfListedElements" data-value="100">100</a>
                                <a class="dropdown-item numOfListedElements" data-value="{{ count($products) }}">Todos</a>
                            </div>
                        </div>
                        <div class="dropdown ml-4">
                            <button
                            class="btn border dropdown-toggle"
                            type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                        Ordenar por
                                    </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item orderBy" data-value="1">Lo &uacute;ltimo</a>
                                <a class="dropdown-item orderBy" data-value="2">Descuento mayor a menor</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row w-100" id="products-list"></div>
                <div class="col-12 pb-1" id="page-navigation">
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
@endsection

@push('custom-scripts')
<script type="text/javascript">
    let allProducts = {!! json_encode($products) !!};

    @if($byCategory != 0)
    let byCategory = {{ $byCategory }};
    @endif

    @if($search != null)
    let search = '{{ $search }}';
    @endif
</script>

<script src="{{ asset('lib/shop.js') }}"></script>

@endpush
