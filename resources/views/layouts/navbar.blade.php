  <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Kec. Gatak, Kab. Sukoharjo, Jawa Tengah</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">marketing@duanaga.co.id</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
    <nav class="navbar navbar-light bg-white navbar-expand-xl">
    <a href="{{ route('home') }}" class="navbar-brand"><h1 class="text-primary display-6">Skincare Dua Naga</h1></a>
    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars text-primary"></span>
    </button>
    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
        <div class="navbar-nav mx-auto">
            <a href="{{ url('katalog') }}" class="nav-item nav-link {{ Request::is('katalog') ? 'text-success' : '' }}">Home</a>
            <a href="{{ route('katalog.shop') }}" class="nav-item nav-link {{ Request::is('katalog/shop*') ? 'text-success' : '' }}">Shop</a>
            @auth 
            <a href="" class="nav-item nav-link {{ Request::is('pesanan') ? 'text-success' : '' }}">Pesanan Saya</a>
            <a href="{{ route('keranjang.katalog') }}" class="nav-item nav-link {{ Request::is('keranjang*') ? 'text-success' : '' }}">Keranjang</a>
            @endauth
            <a href="{{ route('contact.index') }}" class="nav-item nav-link {{ Request::is('contact') ? 'text-success' : '' }}">Contact</a>
        </div>  
        <div class="d-flex m-3 me-0">
     @auth
    @php
        $totalKeranjang = \App\Models\Card::where('user_id', Auth::id())->sum('jumlah');
    @endphp
    <a href="{{ route('keranjang.katalog') }}" class="position-relative me-4 my-auto">
        <i class="fa fa-shopping-bag fa-2x"></i>
        @if($totalKeranjang > 0)
            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" 
                  style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                {{ $totalKeranjang }}
            </span>
        @endif
    </a>
@endauth

    <div class="dropdown my-auto">
        <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-2x me-2"></i> 
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            @guest
            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Register </a></li>
                @else
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>

            @endguest
        </ul>
    </div>
</div>

        @if(Auth::check())
            {{ Auth::user()->name }}
@endif
    </a>
            
</div>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->