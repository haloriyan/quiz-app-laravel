<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<header>
    <div id="tblMenu" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
    <h1>@yield('title')</h1>
    <div class="actionBtn">
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</header>

<nav class="menu">
    <a href="{{ route('home') }}">
        <li class="{{ Route::currentRouteName() == 'home' ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-home"></i></div>
            <div class="text">Home</div>
        </li>
    </a>
    <a href="{{ route('history') }}">
        <li class="{{ Route::currentRouteName() == 'history' ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-history"></i></div>
            <div class="text">History</div>
        </li>
    </a>
    <a href="{{ route('standing') }}">
        <li class="{{ Route::currentRouteName() == 'standing' ? 'active' : 'none' }}">
            <div class="icon"><i class="fas fa-list"></i></div>
            <div class="text">Standings</div>
        </li>
    </a>
</nav>

<div class="container">
    @yield('content')
</div>

{{-- <button class="actionButton"><i class="fas fa-plus"></i></button> --}}

<script src="{{ asset('js/base.js') }}"></script>
<script>
    let isMenuOpened = false

    const toggleMenu = () => {
        if (isMenuOpened) {
            select("nav.menu").classList.remove('active')
            select(".container").classList.remove('menuIsActive')
        }else {
            select("nav.menu").classList.add('active')
            select(".container").classList.add('menuIsActive')
        }
        isMenuOpened = !isMenuOpened
    }
</script>
@yield('javascript')

</body>
</html>