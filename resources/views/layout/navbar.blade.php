<!-- Navbar Start -->
<div class="container-fluid px-0 {{(\Request::route()->getName() == 'home')? 'mb-5' : ''}}">
    <div class="row border-top px-0">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-0 px-0 text-center" aria-label="menu">
                <a class="d-block d-lg-none" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo1.png') }}" alt="logo" class="h-100 w-75" />
                </a>
                <div class="collapse navbar-collapse justify-content-center d-flex" id="navbarCollapse">
                    <div class="navbar-nav flex-row">
                        {{ html()
                        ->a(route('home'), 'Inicio ')
                        ->class('nav-item nav-link p-2')
                        ->classIf(\Request::route()->getName() == 'home', 'active')
                         }}
                        {{ html()
                        ->a(route('shop'), 'Tienda')
                        ->class('nav-item nav-link p-2')
                        ->classIf(
                            (\Request::route()->getName() == 'shop' || \Request::route()->getName() == 'shop.category'),
                            'active')
                        }}
                        <div class="nav-item dropdown @yield('categories-active')">
                            <a href="#" class="nav-link dropdown-toggle p-2" data-toggle="dropdown">
                                Categor&iacute;as
                            </a>
                            <div class="dropdown-menu rounded-0 m-0 position-absolute">
                                @foreach ($categories as $category)
                                    {{ html()->a($category->route, $category->titulo)->class('dropdown-item')}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        @yield('carousel')
    </div>
</div>
<!-- Navbar End -->
