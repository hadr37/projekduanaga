<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Katalog Skincare</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    </head>
<script>
    const kategoriSelect = document.getElementById('filterKategori');
    const searchInput = document.getElementById('searchInput');

    kategoriSelect.addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });

    searchInput.addEventListener('input', function () {
        if (searchInput.value === '') {
            document.getElementById('filterForm').submit();
        }
    });
</script>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


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
    <a href="{{ route('home') }}" class="navbar-brand">
        <h1 class="text-primary display-6">Skincare Dua Naga</h1>
    </a>
    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars text-primary"></span>
    </button>
    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
<div class="navbar-nav mx-auto">
    <a href="{{ url('katalog') }}" class="nav-item nav-link {{ Request::is('katalog') ? 'text-success' : '' }}">Home</a>
    <a href="{{ route('katalog.shop') }}" class="nav-item nav-link {{ Request::is('katalog/shop*') ? 'text-success' : '' }}">Shop</a>
    <a href="" class="nav-item nav-link {{ Request::is('pesanan') ? 'text-success' : '' }}">Pesanan Saya</a>
    <a href="{{ route('keranjang.katalog') }}" class="nav-item nav-link {{ Request::is('keranjang*') ? 'text-success' : '' }}">Keranjang</a>
    <a href="{{ url('contact') }}" class="nav-item nav-link {{ Request::is('contact') ? 'text-success' : '' }}">Contact</a>
</div>
                        <div class="d-flex m-3 me-0">
    <a href="{{ route('keranjang.katalog') }}" class="position-relative me-4 my-auto">
        <i class="fa fa-shopping-bag fa-2x"></i>

        @php
            // Ambil total item di keranjang
            $totalKeranjang = session('keranjang') ? collect(session('keranjang'))->sum('jumlah') : 0;
        @endphp

        @if($totalKeranjang > 0)
        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" 
              style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
            {{ $totalKeranjang }}
        </span>
        @endif
    </a>

    <div class="dropdown my-auto">
        <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-2x me-2"></i> 
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            {{-- <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li> --}}
            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>
</div>

        @if(Auth::check())
            {{ Auth::user()->name }}
        @else
            Akun
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
        @if(Auth::check())
            <li>
                <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                </form>
            </li>
        @else
            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
        @endif
    </ul>
</div>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">100% Produk Asli</h4>
                        <h1 class="mb-5 display-3 text-primary">Rahasia Kulit Indah & Berseri
                            Tanpa Khawatir Kulit Rusak</h1>
                        </h1>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="{{ asset('assets/img/skincare1.jpeg') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Skincare</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="{{ asset('assets/img/skincare2.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Skincare</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->


        <!-- Featurs Section Start -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-car-side fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Free Shipping</h5>
                                <p class="mb-0">Free on order</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-user-shield fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Security Payment</h5>
                                <p class="mb-0">100% security payment</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-exchange-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>30 Day Return</h5>
                                <p class="mb-0">30 day money guarantee</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-phone-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>24/7 Support</h5>
                                <p class="mb-0">Support every time fast</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs Section End -->
        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Produk Kami</h1>
                        </div>

{{-- SCRIPT --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const filterKategori = document.getElementById('filterKategori');
    const cards = document.querySelectorAll('.katalog-card');

    function filterBarang() {
        const search = searchInput.value.toLowerCase();
        const kategori = filterKategori.value;

        cards.forEach(card => {
            const nama = card.dataset.nama;
            const kat = card.dataset.kategori;

            const cocokNama = nama.includes(search);
            const cocokKategori = !kategori || kategori === kat;

            if (cocokNama && cocokKategori) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterBarang);
    filterKategori.addEventListener('change', filterBarang);
</script>

<style>
.katalog-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 kolom */
    gap: 20px;
    padding: 20px;
    font-family: 'Segoe UI', sans-serif;
}

.katalog-card {
    border: 1px solid #d0e9b5;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    text-align: center;
    background-color: #fff;
    position: relative;
}

/* hover dihapus */
.katalog-card img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background-color: #f9f9f9;
}

.katalog-body {
    padding: 15px;
}

.katalog-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.katalog-desc {
    font-size: 13px;
    color: #666;
    height: 40px;
    overflow: hidden;
}

.katalog-stock {
    font-size: 13px;
    color: #555;
    margin-top: 5px;
}

.katalog-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-top: 1px solid #f0f0f0;
}

.harga {
    font-weight: bold;
    color: #198754;
    font-size: 16px;
}

.btn-cart {
    background-color: #fff;
    color: #198754;
    border: 2px solid #198754;
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: bold;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: 0.3s;
}

.btn-cart:hover {
    background-color: #198754;
    color: white;
}

.btn-cart i {
    font-size: 16px;
}
</style>

{{-- KATALOG --}}
<div id="katalog" class="katalog-container">
    @forelse ($barangs->take(6) as $barang) {{-- hanya ambil 6 produk --}}
        <div class="katalog-card position-relative">

            {{-- Badge kategori --}}
            <div class="badge">{{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}</div>

            {{-- Gambar barang --}}
            @php
                $gambar = $barang->gambar
                    ? (Str::startsWith($barang->gambar, ['http', 'assets/'])
                        ? asset($barang->gambar)
                        : asset('storage/' . $barang->gambar))
                    : 'https://via.placeholder.com/300x180?text=No+Image';
            @endphp
            <img src="{{ $gambar }}" alt="{{ $barang->nama_barang }}">

            {{-- Body --}}
            <div class="katalog-body">
                <div class="katalog-title">{{ $barang->nama_barang }}</div>
                <div class="katalog-desc">{{ $barang->deskripsi }}</div>
                <div class="text-muted mt-1" style="font-size:12px;">
                    Stok: {{ $barang->stok }}
                </div>
            </div>

            {{-- Footer --}}
            <div class="katalog-footer">
                <div class="harga">Rp {{ number_format($barang->harga, 0, ',', '.') }}</div>
                <a href="{{ route('produk.show', $barang->id) }}" class="btn-cart">Lihat Detail</a>
                <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-cart">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </form>
            </div>

        </div>
    @empty
        <p class="text-muted">Barang tidak ditemukan.</p>
    @endforelse
</div>


 {{-- Tombol Lihat Semua --}}
        <div class="text-center mt-3">
            <a href="{{ route('katalog.shop') }}" class="btn btn-outline-primary">
                Lihat Semua Produk
            </a>
        </div>
    </div>
</div>
<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Fruits Shop End-->


       <div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">

            <!-- Card 1 -->
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item rounded border border-secondary overflow-hidden">
                        <img src="{{ asset('assets/img/polosan1.jpg') }}" class="img-fluid w-100 service-img" alt="">
                        <div class="service-footer bg-success text-center p-4">
                            <h5 class="text-white">Aman Untuk Kulit</h5>
                            <h3 class="mb-0 text-white">100%</h3>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item rounded border border-dark overflow-hidden">
                        <img src="{{ asset('assets/img/polosan2.jpg') }}" class="img-fluid w-100 service-img" alt="">
                        <div class="service-footer bg-success text-center p-4">
                            <h5 class="text-white">Terdaftar di</h5>
                            <h3 class="mb-0 text-white">BPOM dan LPPOM</h3>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-4">
                <a href="#">
                    <div class="service-item rounded border border-primary overflow-hidden">
                        <img src="{{ asset('assets/img/polosan3.jpg') }}" class="img-fluid w-100 service-img" alt="">
                        <div class="service-footer bg-success text-center p-4">
                            <h5 class="text-white">Tidak Menimbulkan Iritasi</h5>
                            <h3 class="mb-0 text-white">100% Aman</h3>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .service-img {
        height: 250px; /* Samakan tinggi gambar */
        object-fit: cover;
        display: block;
    }

    .service-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .service-footer {
        flex-shrink: 0;
    }
</style>




    <div class="container vesitable py-5">
    <h1 class="mb-4 text-center">Katalog Kosmetik</h1>
    <div class="row g-4 justify-content-center">
        @foreach($kategoris as $kategori)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="border border-primary rounded position-relative vesitable-item" style="overflow: hidden;">
                <div class="vesitable-img" style="position: relative;">
                    <img src="{{ asset('storage/' . $kategori->gambar) }}" 
                         class="img-fluid w-100 rounded-top" 
                         alt="{{ $kategori->nama_kategori }}" 
                         style="height: 180px; object-fit: cover;">
                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" 
                         style="top: 10px; right: 10px; font-weight: bold; font-size: 0.85rem;">
                        {{ $kategori->nama_kategori }}
                    </div>
                </div>
                <div class="p-3 rounded-bottom text-center">
                    <h5 class="mb-0 fw-bold">{{ $kategori->nama_kategori }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Produk Kosmetik</h1>
                            <p class="fw-normal display-3 text-dark mb-4">Di Perusahaan Kami</p>
                            <p class="mb-4 text-dark">Produk yang kamu tawarkan adalah produk berkualitas dan lulus uji BPOM agar aman untuk digunakan untuk Customer</p>
                           <a href="{{ route('katalog.shop') }}" 
   class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">
   Lihat Produk
</a>

                        </div>
                    </div>
                    <div class="col-lg-6">
    <div class="position-relative">
        <!-- Gambar utama -->
        <img src="{{ asset('assets/img/polosan1.jpg') }}" 
             class="img-fluid w-100 rounded" 
             alt="Gambar Produk">

        <!-- Lingkaran ikon + teks -->
        <div class="d-flex flex-column align-items-center justify-content-center 
                    bg-white rounded-circle position-absolute shadow"
             style="width: 140px; height: 140px; top: 15px; left: 15px;">

            <!-- Ikon -->
            <div style="font-size: 48px; line-height: 1;">🧺</div>

            <!-- Teks -->
            <div class="text-center">
                <span class="h4 fw-bold d-block mb-0">For</span>
                <span class="small text-muted">Sale</span>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
        <!-- Banner Section End -->

        <!-- Fact Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>satisfied customers</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>quality of service</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>quality certificates</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Available Products</h4>
                                <h1>789</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Start -->


        <!-- Tastimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="testimonial-header text-center">
                    <h4 class="text-primary">Our Testimonial</h4>
                    <h1 class="display-5 mb-5 text-dark">Our Client Saying!</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('assets/img/testimonial-1.jpg') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('assets/img/testimonial-1.jpg') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item img-border-radius bg-light rounded p-4">
                        <div class="position-relative">
                            <i class="fa fa-quote-right fa-2x text-secondary position-absolute" style="bottom: 30px; right: 0;"></i>
                            <div class="mb-4 pb-4 border-bottom border-secondary">
                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing Ipsum has been the industry standard dummy text ever since the 1500s,
                                </p>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap">
                                <div class="bg-secondary rounded">
                                    <img src="{{ asset('assets/img/testimonial-1.jpg') }}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                </div>
                                <div class="ms-4 d-block">
                                    <h4 class="text-dark">Client Name</h4>
                                    <p class="m-0 pb-3">Profession</p>
                                    <div class="d-flex pe-5">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tastimonial End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h2 class="text-primary mb-0">Skincare Dua Naga</h2>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Your Email">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="https://www.instagram.com/dua.nagakosmetindo/?utm_source=ig_web_button_share_sheet"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="https://youtube.com/@duanagacosmetics?si=BwCUmyZeIUBZ8XvO"><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href="https://www.linkedin.com/company/dua-naga-corporation/"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">typesetting, remaining essentially unchanged. It was 
                                popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="">About Us</a>
                            <a class="btn-link" href="">Contact Us</a>
                            <a class="btn-link" href="">Privacy Policy</a>
                            <a class="btn-link" href="">Terms & Condition</a>
                            <a class="btn-link" href="">Return Policy</a>
                            <a class="btn-link" href="">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="">My Account</a>
                            <a class="btn-link" href="">Shop details</a>
                            <a class="btn-link" href="">Shopping Cart</a>
                            <a class="btn-link" href="">Wishlist</a>
                            <a class="btn-link" href="">Order History</a>
                            <a class="btn-link" href="">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address:  Kec. Gatak, Kab. Sukoharjo, Jawa Tengah</p>
                            <p>Email: marketing@duanaga.co.id</p>
                            <p>Phone: +62 823 4567 8910</p>
                            <p>Payment Accepted</p>
                            <img src="{{ asset('assets/img/payment.png') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If youd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>



    <script>
    const kategoriSelect = document.getElementById('filterKategori');
    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('filterForm');

    // Jika kategori diubah langsung kirim form
    kategoriSelect.addEventListener('change', function () {
        filterForm.submit();
    });

    // Jika input search dikosongkan, langsung tampilkan semua
    searchInput.addEventListener('input', function () {
        if (searchInput.value === '') {
            filterForm.submit();
        }
    });
</script>

@push('scripts')
<script>
    // Scroll ke bagian katalog hanya jika ada hasil search atau filter
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilter = urlParams.has('search') || urlParams.has('kategori');

        if (hasFilter) {
            const katalogSection = document.getElementById('katalog');
            if (katalogSection) {
            katalogSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
</script>
@endpush


    </body>

</html>