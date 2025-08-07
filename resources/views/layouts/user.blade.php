<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('ogani/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/elegant-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ogani/css/style.css') }}">
</head>
<body>

    @include('layouts.navbar') {{-- Jika ada navbar khusus --}}
    
    @yield('content')

    <!-- JS -->
    <script src="{{ asset('ogani/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('ogani/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ogani/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('ogani/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('ogani/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('ogani/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('ogani/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('ogani/js/main.js') }}"></script>
</body>
</html>
