<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<div class="panel">
    <div class="wrap">
        <div class="profile" bg-image="{{ asset('images/iyk.png') }}"></div>
        <br />
        <div class="menu">
            @if (Auth::guard('admin')->user()->role == 1)
                <li class="{{ Route::currentRouteName() == 'admin.admin' ? 'active' : '' }}">
                    <a href="{{ route('admin.admin') }}"><i class="fas fa-users"></i></a>
                </li>
            @endif
            <li class="{{ Route::currentRouteName() == 'admin.logout' ? 'active' : '' }}">
                <a href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt"></i></a>
            </li>
        </div>
    </div>
</div>

<nav class="nav">
    <li class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : 'none' }}">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="{{ Route::currentRouteName() == 'admin.quiz' ? 'active' : 'none' }}">
        <a href="{{ route('admin.quiz') }}">Quiz</a>
    </li>
    <li class="{{ Route::currentRouteName() == 'admin.participant' ? 'active' : 'none' }}">
        <a href="{{ route('admin.participant') }}">Standings</a>
    </li>
</nav>

<div class="container bayangan rounded">
    <div class="wrap">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/base.js') }}"></script>
@yield('javascript')

</body>
</html>