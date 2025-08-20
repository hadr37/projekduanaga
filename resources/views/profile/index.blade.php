<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile - Skincare Dua Naga</title>
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
</head>

<style>
    body {
        padding-top: 130px; 
    }
</style>
<body>
    @include('layouts.navbar')

    <div class="container py-5">
        <div class="row">

            <!-- Bagian kiri: Profile User -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <p class="text-center mb-4"><h3> Profil User </h3> </p>
                        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Bagian kanan: Daftar Alamat -->
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Daftar Alamat</h4>
                    <a href="{{ route('profile.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Alamat
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        @if($alamats->count())
                            <ul class="list-group">
    @foreach($alamats as $alamat)
        <li class="list-group-item">
            <strong>
                {{ $alamat->namapenerima }}
                @if($alamat->is_default)
                    <span class="badge bg-success">Default</span>
                @endif
            </strong> 
            <br>
            <small class="text-muted">{{ $alamat->no_telepon }}</small> <br>
            {{ $alamat->alamat }} 

            <div class="mt-2">
                <a href="{{ route('profile.edit', $alamat->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('profile.destroy', $alamat->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>

                @if(!$alamat->is_default)
                    <form action="{{ route('profile.setDefault', $alamat->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check2-circle"></i> Jadikan Default
                        </button>
                    </form>
                @endif
            </div>
        </li>
    @endforeach
</ul>

                        @else
                            <p class="text-muted">Belum ada alamat tersimpan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
