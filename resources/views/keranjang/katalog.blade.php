<!-- resources/views/katalog/keranjang.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang - Skincare Dua Naga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon & Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>

        .container-fluid.fixed-top {
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        background: var(--bs-primary, #0d6efd) !important; /* fallback ke biru */
    }
        body {
            padding-top: 150px; /* Sesuaikan jika navbar lebih tinggi */
        }
        .btn-cart, .btn-outline-primary, .btn-outline-danger {
            border-radius: 20px;
        }
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Keranjang Section -->
    <div class="container py-4">

        <h4 class="mb-4">🛒 Keranjang Saya ({{ count($keranjang) }})</h4>

        {{-- Alert pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Alert pesan error --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <!-- Daftar Item Keranjang -->
            <div class="col-lg-8">
                @forelse($keranjang as $item)
                    <div class="card mb-3 shadow-sm border-0 rounded-3">
                        <div class="row g-0 align-items-center">

                            <!-- Gambar Barang -->
                            <div class="col-md-2 text-center">
                                @php
                                    $gambar = $item->product->gambar ?? null;
                                    if ($gambar) {
                                        if (\Illuminate\Support\Str::startsWith($gambar, ['http', 'assets/'])) {
                                            $gambarUrl = asset($gambar);
                                        } else {
                                            $gambarUrl = asset('storage/' . $gambar);
                                        }
                                    } else {
                                        $gambarUrl = 'https://via.placeholder.com/100x100?text=No+Image';
                                    }
                                @endphp
                                <img src="{{ $gambarUrl }}" alt="{{ $item->product->nama_barang }}" class="product-image">
                            </div>

                            <!-- Detail Barang -->
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h6 class="card-title mb-1">{{ $item->product->nama_barang }}</h6>
                                    <p class="card-text text-success fw-bold mb-2">
                                        Rp {{ number_format($item->product->harga, 0, ',', '.') }}
                                    </p>

                                    <div class="d-flex align-items-center">
                                        {{-- Kurangi Jumlah --}}
                                        @if($item->jumlah > 1)
                                            <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="me-2">
                                                @csrf
                                                <input type="hidden" name="jumlah" value="{{ $item->jumlah - 1 }}">
                                                <button class="btn btn-sm btn-outline-primary" type="submit">-</button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary me-2" disabled>-</button>
                                        @endif

                                        <span class="mx-2 fw-bold">{{ $item->jumlah }}</span>

                                        {{-- Tambah Jumlah --}}
                                        <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="ms-2">
                                            @csrf
                                            <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                            <button class="btn btn-sm btn-outline-primary" type="submit">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Subtotal & Tombol Hapus -->
                            <div class="col-md-4 text-end p-3">
                                <p class="fw-bold text-success mb-2">
                                    Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}
                                </p>
                                <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit" 
                                            onclick="return confirm('Yakin ingin menghapus item ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                        <h5>Keranjang masih kosong</h5>
                        <p>Yuk mulai belanja produk skincare terbaik kami!</p>
                        <a href="{{ route('katalog.shop') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Sidebar Ringkasan Belanja -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h5 class="mb-3">Ringkasan Belanja</h5>

                        @if(count($keranjang) > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-2">
                                    <thead>
                                        <tr class="border-bottom">
                                            <th class="text-start">Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($keranjang as $item)
                                            <tr>
                                                <td><small>{{ \Illuminate\Support\Str::limit($item->product->nama_barang, 15) }}</small></td>
                                                <td class="text-center">{{ $item->jumlah }}</td>
                                                <td class="text-end">
                                                    <small>Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}</small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Ongkir:</span>
                                <span>Gratis</span>
                            </div>
                            <hr>
                            <p class="d-flex justify-content-between fw-bold fs-5 mb-3">
                                <span>Total:</span>
                                <span class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </p>

                            <form action="{{ route('keranjang.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 py-2" 
                                        onclick="return confirm('Lanjutkan ke checkout?')">
                                    <i class="fas fa-credit-card me-2"></i>Checkout Sekarang
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning mb-0 text-center">
                                <i class="fas fa-info-circle me-2"></i>Keranjang kosong
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
