<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontak Kami - Skincare Dua Naga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon & Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    @include('layouts.navbar')

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
        /* Hero section dengan background gambar */
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
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="hero-kontak text-center">
        <div>
            <h1>Kontak Kami</h1>
            <p>Hubungi kami untuk pertanyaan, pemesanan, atau informasi lebih lanjut</p>
        </div>
    </div>

    <!-- Konten -->
    <div class="container py-5">
        <div class="row g-4">

            <!-- Kolom Kiri -->
            <div class="col-lg-6">

                <!-- Form Hubungi Kami -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="text-success mb-3">Kirimkan pesan kepada kami di bawah dan kami akan menghubungi Anda sesegera mungkin!</h3>
                        <form>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" placeholder="Nama Anda">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control" id="pesan" rows="4" placeholder="Tulis pesan Anda..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Kirim Pesan</button>
                        </form>
                    </div>
                </div>

                <!-- Nomor Marketing -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="text-success mb-3">Nomor Marketing</h5>
                        <p>Kami akan senang untuk berbicara dengan Anda. Jangan ragu untuk menghubungi kami melalui link di bawah ini.</p>
                        <ul class="list-unstyled">
                            <li>📞 0812-3456-7890 (Marketing A)</li>
                            <li>📞 0813-9876-5432 (Marketing B)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-success mb-3">Alamat & Jam Kerja</h4>
                        <p>
                            📍 Jl. Contoh Alamat No. 123, Sukoharjo, Jawa Tengah  
                            ⏰ Senin - Jumat: 08.00 - 17.00  
                            📧 Email: info@duanaga.co.id
                        </p>
                        <hr>
                        <h5>Lokasi Kami</h5>
                        <div class="ratio ratio-16x9">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.396146580888!2d110.737027!3d-7.313020199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a14d95b7a8e5f%3A0xa5c935f8dd4228cb!2sDua%20Naga%20Kosmetindo!5e0!3m2!1sid!2sid!4v1692265678934!5m2!1sid!2sid" 
                                width="100%" height="400" style="border:0;" 
                                allowfullscreen="" loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

 <!-- Footer -->
    <footer class="bg-dark text-white pt-5 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold">PT. DUA NAGA KOSMETINDO</h5>
                    <p><i class="bi bi-geo-alt-fill"></i> Dk. GAMBIRAN, Ds. Krajan, Kec. Gatak, Kab. Sukoharjo, Jawa Tengah, (57557)</p>
                    <p><i class="bi bi-whatsapp"></i> CS 1: 0811 2717 464 <br> CS 2: 0811 2800 278</p>
                    <p><i class="bi bi-envelope"></i> marketing@duanaga.co.id</p>
                    <div>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>

                <div class="col-md-2">
                    <h6 class="fw-bold">Tentang Kami</h6>
                    <p class="small">PT Dua Naga Kosmetindo berdiri sejak tahun 2015, dipercaya memproduksi berbagai produk unggulan.</p>
                </div>

                <div class="col-md-2">
                    <h6 class="fw-bold">Pabrik</h6>
                    <ul class="list-unstyled small">
                        <li>Pabrikan</li>
                        <li>Tim R & D</li>
                        <li>Quality Control</li>
                        <li>Pameran Perdagangan</li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h6 class="fw-bold">Layanan Turnkey</h6>
                    <ul class="list-unstyled small">
                        <li>Formulasi Kustom</li>
                        <li>Kemasan Khusus</li>
                        <li>Layanan Desain</li>
                        <li>Produksi</li>
                        <li>Layanan Sertifikat</li>
                        <li>Logistik</li>
                    </ul>
                </div>
            </div>
            <hr class="border-light">
            <div class="text-center py-2">
                <small>© {{ date('Y') }} Skincare Dua Naga. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
