@extends('layouts.app')

@section('content')
<style>
    .container-fluid.fixed-top {
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        background: var(--bs-primary, #0d6efd) !important; /* fallback ke biru */
    }
      body {
            padding-top: 130px; /* Sesuaikan jika navbar lebih tinggi */
        }
    .keranjang-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .keranjang-table th, .keranjang-table td {
        vertical-align: middle;
    }
    .keranjang-footer {
        border-top: 1px solid #ddd;
        padding-top: 15px;
        margin-top: 15px;
    } </style>
<body>
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
    @endsection
