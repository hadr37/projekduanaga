
<body>
@extends('layouts.app')

@section('content')

<div class="container py-5">
    <h2>Halaman Checkout</h2>

    <div class="row g-4">
        <!-- Kiri: Ringkasan Pesanan + Alamat -->
        <div class="col-lg-8">
            <!-- Ringkasan Pesanan -->
            <div class="card mb-4">
                <div class="card-header">Ringkasan Pesanan</div>
                <div class="card-body p-3 p-md-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = $total; @endphp
                            @foreach($keranjang as $item)
                                @php $subtotal = $item->product->harga * $item->jumlah; @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->product->gambar) }}" 
                                                 alt="{{ $item->product->nama_barang }}" 
                                                 class="me-2" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            <span>{{ $item->product->nama_barang }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp {{ number_format($item->product->harga,0,',','.') }}</td>
                                    <td>Rp {{ number_format($subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Total</td>
                                <td>Rp {{ number_format($grandTotal,0,',','.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="card mb-4">
                <div class="card-header">Alamat Pengiriman</div>
                <div class="card-body p-3 p-md-4">
                    @if($alamat)
                        <p class="mb-1"><strong>{{ $alamat->namapenerima }}</strong></p>
                        <p class="mb-1">{{ $alamat->alamat }}</p>
                        <p class="mb-0">No. Telepon: {{ $alamat->no_telepon }}</p>
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                            <i class="fas fa-edit me-1"></i> Ganti Alamat
                        </a>
                    @else
                        <p class="text-muted mb-0">Belum ada alamat default.  
                            <a href="{{ route('profile.index') }}">Tambahkan di profil</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kanan: Metode Pembayaran -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Metode Pembayaran</div>
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('katalog.checkout.proses') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select class="form-select" name="jenis_pembayaran" id="jenis_pembayaran" required>
                                <option value="">-- Pilih --</option>
                                <option value="debit">Kartu Debit</option>
                                <option value="visa">Visa</option>
                                <option value="bank">Bank</option>
                                <option value="virtual_account">Virtual Account</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bank</label>
                            <select class="form-select" name="bank" required>
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="BSI">BSI</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="CIMB Niaga">CIMB Niaga</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik Rekening</label>
                            <input type="text" class="form-control" name="nama_rekening" required>
                        </div>

                        <div class="mb-3" id="input_no">
                            <label class="form-label" id="label_no">Nomor Kartu / Rekening</label>
                            <input type="text" class="form-control" name="no_rekening" id="no_rekening">
                        </div>

                        <input type="hidden" name="total" value="{{ $grandTotal }}">

                        <button type="submit" class="btn btn-success w-100 mt-2">
                            <i class="fas fa-check-circle me-2"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
