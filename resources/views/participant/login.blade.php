@extends('layouts.auth')

@section('content')
    <div class="rata-tengah mb-5">
        <img src="{{ asset('images/iyk.png') }}" alt="">
    </div>
    <form action="{{ route('login.action') }}" method="POST" class="mt-5">
        {{ csrf_field() }}
        @if ($errors->count() != 0)
            @foreach ($errors->all() as $err)
                <div class="bg-merah-transparan mb-2 rounded p-2">
                    {{ $err }}
                </div>
            @endforeach
        @endif
        @if ($message != "")
            <div class="bg-hijau-transparan mb-2 rounded p-2">
                {{ $message }}
            </div>
        @endif
        <div>Email :</div>
        <input type="email" class="box" name="email" required>
        <div class="mt-2">Password :</div>
        <input type="password" class="box" name="password" required>
        <button class="lebar-100 biru mt-3">Login</button>

        <div class="rata-tengah mt-3">
            Don't have an account? <a href="{{ route('register') }}">register</a>
        </div>
    </form>
@endsection