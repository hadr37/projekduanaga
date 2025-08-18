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
        /* Berikan padding-top sesuai tinggi navbar */
        body {
            padding-top: 130px; /* Sesuaikan jika navbar lebih tinggi */
        }

        /* Styling tambahan untuk keranjang */
        .btn-cart, .btn-outline-primary, .btn-outline-danger {
            border-radius: 20px;
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
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Daftar Item Keranjang -->
            <div class="col-lg-8">
                @forelse($keranjang as $id => $item)
                    <div class="card mb-3 shadow-sm border-0 rounded-3">
                        <div class="row g-0 align-items-center">
                            <!-- Gambar Barang -->
                            <div class="col-md-2 text-center">
                                @php
                                    $gambar = $item['gambar']
                                        ? (\Illuminate\Support\Str::startsWith($item['gambar'], ['http', 'assets/'])
                                            ? asset($item['gambar'])
                                            : asset('storage/' . $item['gambar']))
                                        : 'https://via.placeholder.com/100x100?text=No+Image';
                                @endphp
                                <img src="{{ $gambar }}" alt="{{ $item['nama'] }}" class="img-fluid rounded p-2">
                            </div>

                            <!-- Detail Barang -->
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h6 class="card-title mb-1">{{ $item['nama'] }}</h6>
                                    <p class="card-text text-success fw-bold mb-2">
                                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        {{-- Kurangi Jumlah --}}
                                        <form action="{{ route('keranjang.update', $id) }}" method="POST" class="me-2">
                                            @csrf
                                            <input type="hidden" name="jumlah" value="{{ max(1, $item['jumlah'] - 1) }}">
                                            <button class="btn btn-sm btn-outline-primary">-</button>
                                        </form>

                                        <span class="mx-2">{{ $item['jumlah'] }}</span>

                                        {{-- Tambah Jumlah --}}
                                        <form action="{{ route('keranjang.update', $id) }}" method="POST" class="ms-2">
                                            @csrf
                                            <input type="hidden" name="jumlah" value="{{ $item['jumlah'] + 1 }}">
                                            <button class="btn btn-sm btn-outline-primary">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Hapus -->
                            <div class="col-md-4 text-end p-3">
                                <form action="{{ route('keranjang.destroy', $id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">Keranjang masih kosong.</div>
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
                            <tr>
                                <th class="text-start">Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keranjang as $item)
                                <tr>
                                    <td>{{ $item['nama'] }}</td>
                                    <td class="text-center">{{ $item['jumlah'] }}</td>
                                    <td class="text-end">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <p class="d-flex justify-content-between fw-bold fs-6 mb-3">
                    <span>Total:</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </p>

                <form action="{{ route('keranjang.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">
                        Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>
            @else
                <div class="alert alert-warning mb-0">Keranjang kosong.</div>
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
