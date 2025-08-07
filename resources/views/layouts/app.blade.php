<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ogani - Catalog</title>

    {{-- CSS OGANI --}}
    <link rel="stylesheet" href="{{ asset('ogani/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/style.css') }}">
</head>
<body>

    {{-- Navbar Ogani --}}
    @include('layouts.navbar')

    {{-- Konten --}}
    <main>
        @yield('content')
    </main>

    {{-- JS OGANI --}}
    <script src="{{ asset('ogani/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('ogani/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ogani/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('ogani/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('ogani/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('ogani/js/main.js') }}"></script>
</body>
</html>
