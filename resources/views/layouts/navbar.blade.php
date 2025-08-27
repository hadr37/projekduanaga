<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <!-- Topbar (desktop only) -->
    <div class="topbar bg-primary d-none d-lg-block px-0">
        <div class="d-flex justify-content-between px-3">
            <div class="top-info ps-2">
                <small class="me-3">
                    <i class="fas fa-map-marker-alt me-2 text-secondary"></i>
                    <a href="#" class="text-white">Kec. Gatak, Kab. Sukoharjo, Jawa Tengah</a>
                </small>
                <small class="me-3">
                    <i class="fas fa-envelope me-2 text-secondary"></i>
                    <a href="#" class="text-white">marketing@duanaga.co.id</a>
                </small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-light navbar-expand-xl shadow-sm" style="background-color: #fff !important;">
        <div class="container-fluid px-3">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="navbar-brand">
                <h1 class="text-primary display-6 m-0">Skincare Dua Naga</h1>
            </a>

            <!-- Toggler -->
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse mt-2 mt-xl-0 py-3 py-xl-0 px-3 px-xl-0" id="navbarCollapse">

                
                <!-- Menu Tengah -->
                <div class="navbar-nav mx-auto text-center">
                    <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'text-success fw-bold' : '' }}">Home</a>
                    <a href="{{ route('katalog.shop') }}" class="nav-item nav-link {{ Request::is('katalog/shop*') ? 'text-success fw-bold' : '' }}">Shop</a>
                    @auth
                        <a href="{{ route('katalog.pesanan') }}" class="nav-item nav-link {{ Request::is('pesanan') ? 'text-success fw-bold' : '' }}">Pesanan Saya</a>
                        <a href="{{ route('keranjang.katalog') }}" class="nav-item nav-link {{ Request::is('keranjang*') ? 'text-success fw-bold' : '' }}">Keranjang</a>
                    @endauth
                    <a href="{{ route('contact.index') }}" class="nav-item nav-link {{ Request::is('contact') ? 'text-success fw-bold' : '' }}">Contact</a>
                </div>

                <!-- Icon kanan -->
                <div class="d-flex align-items-center justify-content-center justify-content-xl-end ms-xl-3 mt-3 mt-xl-0">
                    @auth
                        @php
                            $totalKeranjang = \App\Models\Card::where('user_id', Auth::id())->sum('jumlah');
                        @endphp
                        <a href="{{ route('keranjang.katalog') }}" class="position-relative me-4 my-auto text-dark">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            @if($totalKeranjang > 0)
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" 
                                      style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                    {{ $totalKeranjang }}
                                </span>
                            @endif
                        </a>
                    @endauth

                    <!-- Dropdown user -->
                    <div class="dropdown my-auto">
                        <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-2x me-2"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            @guest
                                <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                            @endguest
                        </ul>
                    </div>

                    @if(Auth::check())
                        <span class="ms-2 d-none d-xl-inline">{{ Auth::user()->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar end -->

