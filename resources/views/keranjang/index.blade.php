<!-- resources/views/katalog/keranjang.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts dan Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body { padding-top: 90px; font-family: 'Open Sans', sans-serif; }
        .keranjang-card {
            background: #fff;
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .keranjang-table th, .keranjang-table td {
            vertical-align: middle;
            text-align: center;
        }
        .keranjang-footer {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

@include('layouts.navbar')

<div class="container">
    <h3 class="mb-4">🛒 Keranjang Belanja</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(!empty($keranjangs) && count($keranjangs) > 0)

        <div class="keranjang-card">
            <form action="{{ route('keranjang.checkout') }}" method="POST">
                @csrf

                <table class="table table-bordered keranjang-table">
                    <thead class="table-success">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Stok</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($keranjangs as $item)
                            @php
                                $subtotal = $item->jumlah * $item->barang->harga;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td>Rp {{ number_format($item->barang->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->barang->stok }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="keranjang-footer">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" name="metode_pembayaran" required>
                                <option value="">-- Pilih --</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="COD">COD (Bayar di Tempat)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_pembayaran" class="form-label">Nomor Pembayaran</label>
                            <input type="text" name="nomor_pembayaran" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Total: Rp {{ number_format($total, 0, ',', '.') }}</h5>
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="alert alert-warning">Keranjang Anda kosong.</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
