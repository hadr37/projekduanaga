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

    <style>
        /* ================= GLOBAL ================= */
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f6fa;
            padding-top: 120px; /* default untuk desktop */
        }
        @media (max-width: 992px) {
            body { padding-top: 80px; } /* lebih rendah untuk mobile */
        }

        .container-fluid.fixed-top {
            border-radius: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: var(--bs-primary, #0d6efd) !important;
        }

        .content-wrapper {
            margin-top: 120px;
        }

        /* ================= NAVBAR ================= */
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

        /* ================= CHECKOUT ================= */
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

        /* ================= KONTAK ================= */
        .hero-kontak {
            background: url('{{ asset('assets/img/kontak.png') }}') no-repeat center center;
            background-size: cover;
            height: 400px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-kontak::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }
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

        /* ================= SHOP / KATALOG ================= */
        .katalog-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            align-items: stretch;
        }
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
        .katalog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f9f9f9;
        }
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
            min-height: 40px;
        }
        .katalog-desc {
            font-size: 13px;
            color: #666;
            flex-grow: 1;
            line-height: 1.4;
            max-height: 38px;
            margin-bottom: 8px;
            overflow: hidden;
        }
        .katalog-body .text-muted { font-size: 12px; }
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
            background: #fff;
            border-radius: 20px;
            transition: 0.2s;
            cursor: pointer;
        }
        .btn-cart:hover {
            background: #198754;
            color: #fff;
        }
        .badge {
            position: absolute;
            background: #76c043;
            color: #fff;
            padding: 3px 8px;
            font-size: 11px;
            border-radius: 20px;
            top: 8px;
            right: 8px;
        }
        @media (max-width: 991px) {
            .katalog-container { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 575px) {
            .katalog-container { grid-template-columns: 1fr; }
        }

        /* ================= KERANJANG ================= */
        .keranjang-table th, .keranjang-table td { vertical-align: middle; }
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
        .keranjang-footer h5 { font-weight: 600; }

        /* ================= PRODUK DESKRIPSI ================= */
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
            background: #000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            text-decoration: none;
            transition: 0.2s;
            display: inline-block;
            margin-top: 15px;
        }
        .btn-offer:hover { background: #333; }
        .produk-kategori {
            font-size: 14px;
            color: #888;
            line-height: 1.5;
            margin-bottom: 8px;
            display: block;
            white-space: normal !important;
            word-break: break-word;
        }
        @media(max-width: 768px) {
            .produk-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')
    @yield('content')

    <!-- ================= SCRIPT ================= -->
    <script defer>
        // checkout.blade.js
        document.addEventListener("DOMContentLoaded", () => {
            const jenisPembayaran = document.getElementById('jenis_pembayaran');
            const labelNo = document.getElementById('label_no');
            const noRek = document.getElementById('no_rekening');
            const bankSelect = document.querySelector('select[name="bank"]');

            if (!jenisPembayaran) return; // amanin kalau element ga ada

            jenisPembayaran.addEventListener('change', function () {
                let jenis = this.value;

                // reset default
                bankSelect.required = false;
                bankSelect.closest('.mb-3').style.display = 'none';

                if (jenis === 'virtual_account') {
                    labelNo.textContent = 'Nomor Virtual Account';
                    noRek.value = 'VA' + Math.floor(100000000 + Math.random() * 900000000);
                    noRek.readOnly = true;
                } else if (jenis === 'debit' || jenis === 'visa') {
                    labelNo.textContent = 'Nomor Kartu';
                    noRek.value = '';
                    noRek.readOnly = false;
                } else if (jenis === 'bank') {
                    labelNo.textContent = 'Nomor Rekening';
                    noRek.value = '';
                    noRek.readOnly = false;
                    bankSelect.required = true;
                    bankSelect.closest('.mb-3').style.display = 'block';
                } else {
                    labelNo.textContent = 'Nomor Kartu / Rekening';
                    noRek.value = '';
                    noRek.readOnly = false;
                }
            });

            // trigger awal
            jenisPembayaran.dispatchEvent(new Event('change'));
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
