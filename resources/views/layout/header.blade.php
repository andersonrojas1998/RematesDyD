<!-- Topbar Start -->
<div class="container-fluid" style="background-color: #f8991a">
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 col-6" >
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo1.png') }}" alt="logo" style ="height: 90px;
        max-height: 70px;
        max-width: 290px;
        width: 290px;border-radius:15px;
        image-rendering: auto;
        " />
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left ml-auto">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar productos">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent">
                            <i class="fa fa-search text-white"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-2 col-2 text-left ml-auto">
                <a>
                <i class="fa fa-user-circle text-white" style="font-size:25px;"></i>
                    <p class="text-white">Mi cuenta</p>
                </a>
        </div>
    </div>
</div>
<!-- Topbar End -->
