<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<div class="illustration" bg-image="{{ asset('images/mbakmbakkorean-single.png') }}"></div>

<div class="message">
    <h2>Ikuti Kuis Medical Wellness Game</h2>
    <p>Menangkan hadiah harian dan Grand Prize Samsung S20 di akhir periode</p>
</div>

<div class="container">
    <div class="wrap">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/base.js') }}"></script>

</body>
</html>