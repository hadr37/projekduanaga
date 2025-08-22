<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Skincare Dua Naga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        .container-fluid.fixed-top {
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: var(--bs-primary, #0d6efd) !important;
        }
        body { 
            padding-top: 120px; 
            background: #f5f6fa;
            font-family: 'Open Sans', sans-serif;
        }
        h2 { font-weight: 700; margin-bottom: 30px; }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .card-header {
            background-color: #A4DE02 !important;
            color: #1a1a1a !important;
            font-weight: 600;
            font-size: 1.1rem;
        }
        table { font-size: 0.95rem; }
        .table thead th { border-bottom: 2px solid #dee2e6; }
        .table tfoot td { font-weight: 600; font-size: 1rem; }
        .form-label { font-weight: 600; }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }
        .btn-success {
            background-color: #A4DE02;
            border-color: #A4DE02;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background-color: #8cc102;
            border-color: #8cc102;
        }
        @media (max-width: 992px) { body { padding-top: 80px; } }
    </style>
</head>
<body>

@include('layouts.navbar')

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

<script>
document.getElementById('jenis_pembayaran').addEventListener('change', function () {
    let jenis = this.value;
    let labelNo = document.getElementById('label_no');
    let noRek = document.getElementById('no_rekening');

    if(jenis === 'virtual_account') {
        labelNo.textContent = 'Nomor Virtual Account';
        noRek.value = 'VA' + Math.floor(100000000 + Math.random() * 900000000);
        noRek.readOnly = true;
    } else if(jenis === 'debit' || jenis === 'visa') {
        labelNo.textContent = 'Nomor Kartu';
        noRek.value = '';
        noRek.readOnly = false;
    } else {
        labelNo.textContent = 'Nomor Kartu / Rekening';
        noRek.value = '';
        noRek.readOnly = false;
    }
});
</script>

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
