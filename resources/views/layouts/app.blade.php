<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Skincare Dua Naga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon & Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<script>
    //checkout.blade.js
document.getElementById('jenis_pembayaran').addEventListener('change', function () {
    let jenis = this.value;
    let labelNo = document.getElementById('label_no');
    let noRek = document.getElementById('no_rekening');
    let bankSelect = document.querySelector('select[name="bank"]');

    // Reset default
    bankSelect.required = false;
    bankSelect.closest('.mb-3').style.display = 'none'; // sembunyikan jika tidak wajib

    if(jenis === 'virtual_account') {
        labelNo.textContent = 'Nomor Virtual Account';
        noRek.value = 'VA' + Math.floor(100000000 + Math.random() * 900000000);
        noRek.readOnly = true;
    } else if(jenis === 'debit' || jenis === 'visa') {
        labelNo.textContent = 'Nomor Kartu';
        noRek.value = '';
        noRek.readOnly = false;
    } else if(jenis === 'bank') {
        labelNo.textContent = 'Nomor Rekening';
        noRek.value = '';
        noRek.readOnly = false;

        // bank wajib kalau pilih "Bank"
        bankSelect.required = true;
        bankSelect.closest('.mb-3').style.display = 'block'; 
    } else {
        labelNo.textContent = 'Nomor Kartu / Rekening';
        noRek.value = '';
        noRek.readOnly = false;
    }
});

// Saat pertama kali load halaman, cek kondisi awal
window.addEventListener('DOMContentLoaded', function () {
    document.getElementById('jenis_pembayaran').dispatchEvent(new Event('change'));
});
    </script>


<style>

    .container-fluid.fixed-top {
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: var(--bs-primary, #0d6efd) !important; /* fallback biru */
        }

        body { 
            padding-top: 20px; 
            background: #fafafa;
        }

/* Biar mobile navbar tidak transparan */
.content-wrapper {
    margin-top: 120px; /* Sesuaikan dengan tinggi navbar */
}
@media (max-width: 1199px) {
    #navbarCollapse {
        background: #fff !important;
        text-align: center;
        box-shadow: none !important;  
        border-radius: 0 !important;  
    }
    #navbarCollapse .nav-link {
        color: #000 !important;
    }
}
/* checkout blade */

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


        /* contact css */
         .hero-kontak {
            background: url('{{ asset('assets/img/kontak.png') }}') no-repeat center center;
            background-size: cover;
            height: 400px; /* bisa diperbesar sesuai keinginan, misal 500px */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Overlay gelap biar teks jelas */
        .hero-kontak::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        /* Teks di dalam gambar */
        .hero-kontak h1 {
            position: relative;
            color: #fff;
            font-size: 3rem;
            font-weight: 700;
            z-index: 1;
        }
        .hero-kontak p {
            position: relative;
            color: #e0e0e0;
            font-size: 1.2rem;
            z-index: 1;
        }


        /* shop */
        /* GRID */
    .katalog-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
        align-items: stretch; /* samakan tinggi */
    }

    /* CARD */
    .katalog-card {
        border: 1px solid #eee;
        border-radius: 12px;
        background: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.2s;
        height: 100%;
        overflow: hidden;
    }

    .katalog-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }

    /* GAMBAR */
    .katalog-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background-color: #f9f9f9;
    }

    /* BODY */
    .katalog-body {
        flex: 1;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
    }

    .katalog-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        min-height: 40px; /* seragam judul */
    }

    .katalog-desc {
        font-size: 13px;
        color: #666;
        flex-grow: 1;
        overflow: hidden;
        line-height: 1.4;
        max-height: 38px; /* seragam deskripsi */
        margin-bottom: 8px;
    }

    .katalog-body .text-muted {
        font-size: 12px;
    }

    /* FOOTER */
    .katalog-footer {
        padding: 12px 16px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .harga {
        color: #198754;
        font-weight: bold;
        font-size: 14px;
    }

    .btn-cart {
        font-size: 13px;
        padding: 5px 10px;
        border: 1px solid #198754;
        color: #198754;
        background: white;
        border-radius: 20px;
        transition: 0.2s;
        cursor: pointer;
    }

    .btn-cart:hover {
        background: #198754;
        color: white;
    }

    .badge {
        position: absolute;
        background: #76c043;
        color: white;
        padding: 3px 8px;
        font-size: 11px;
        border-radius: 20px;
        top: 8px;
        right: 8px;
    }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .katalog-container { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 575px) {
        .katalog-container { grid-template-columns: repeat(1, 1fr); }
    }

    /* keranjang */
        .container {
            padding-top: 150px; /* Sesuaikan jika navbar lebih tinggi */
            background: #f5f6fa;
            min-height: 100vh;
        }
        h2 {
            font-weight: 700;
            margin-bottom: 30px;
        }
        .keranjang-table th, .keranjang-table td {
            vertical-align: middle;
        }
        .keranjang-table th {
            background-color: #A4DE02 !important;
            color: #1a1a1a !important;
            font-weight: 600;
        }
        .keranjang-footer {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .keranjang-footer h5 {
            font-weight: 600;
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
        @media (max-width: 992px) {
            body { padding-top: 80px; }
        }

        /* katalog */
            .btn-cart, .btn-outline-primary, .btn-outline-danger {
            border-radius: 20px;
        }
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* produk deskripsi */
        body { 
            padding-top: 140px; 
            font-family: 'Open Sans', sans-serif; 
        }
        .produk-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .produk-card {
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
            padding: 20px;
        }
        .produk-image img {
            width: 100%;
            border-radius: 10px;
            background-color: #f9f9f9;
            object-fit: contain;
        }
        .produk-details h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }
        .produk-details ul {
            padding-left: 18px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .btn-offer {
            background: black;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
            display: inline-block;
            margin-top: 15px;
        }
        .btn-offer:hover {
            background: #333;
        }
        /* Agar kategori tidak terpotong */
        .produk-kategori {
            font-size: 14px;
            color: #888;
            white-space: normal !important;
            word-break: break-word;
            line-height: 1.5;
            margin-bottom: 8px;
            display: block;
        }
        @media(max-width: 768px) {
            .produk-container {
                grid-template-columns: 1fr;
            }
        }
</style>

</head>
<body>



@include('layouts.navbar')
@yield('content')

 <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>