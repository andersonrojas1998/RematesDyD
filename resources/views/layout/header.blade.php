<!-- Topbar Start -->
<div class="container-fluid" style="background-color: #f8991a">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block" >
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo1.png') }}" alt="logo" class="h-100 w-100" />
            </a>
        </div>
        <div class="col-lg-4 col-9 ml-auto">
            <form action="{{ route('shop.search') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Buscar productos">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent">
                            <i class="fa fa-search text-white"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-2 col-3 ml-auto">
                <a href="{{ url('LoginPage')}}">
                <i class="fa fa-user-circle text-white" style="font-size:25px;"></i>
                    <p class="text-white">Mi cuenta</p>
                </a>
        </div>
    </div>
</div>
<!-- Topbar End -->
