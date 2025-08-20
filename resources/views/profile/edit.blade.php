<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Skincare Dua Naga</title>
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
            padding-top: 130px; /* Sesuaikan jika navbar lebih tinggi */
        }
</style>
<body>
    @include('layouts.navbar')

    <div class="container py-5">
        <h2 class="mb-4">Edit Alamat</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('profile.update', $alamat->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="namapenerima" class="form-control" 
                               value="{{ old('namapenerima', $alamat->namapenerima) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" 
                               value="{{ old('no_telepon', $alamat->no_telepon) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $alamat->alamat) }}</textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" 
                               name="is_default" value="1" 
                               {{ old('is_default', $alamat->is_default) ? 'checked' : '' }}>
                        <label class="form-check-label">Jadikan Alamat Default</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
