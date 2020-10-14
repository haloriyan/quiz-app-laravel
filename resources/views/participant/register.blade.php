@extends('layouts.auth')

@section('head.dependencies')
<style>
    .container {
        top: 0px;bottom: auto !important;
    }
    a { color: #3498db; }
</style>
@endsection

@section('content')
    <div class="rata-tengah mb-5">
        <img src="{{ asset('images/iyk.png') }}" alt="">
    </div>
    {{-- <h2 style="margin-top: 30px;" class="mb-5">Register</h2> --}}
    <form action="{{ route('register.action') }}" method="POST">
        {{ csrf_field() }}
        @if ($errors->count() != 0)
            @foreach ($errors->all() as $err)
                <div class="bg-merah-transparan mb-2 rounded p-2">
                    {{ $err }}
                </div>
            @endforeach
        @endif
        <div class="mt-2">Name :</div>
        <input type="text" class="box" name="name" required>
        <div class="mt-2">Email :</div>
        <input type="email" class="box" name="email" required>
        <div class="mt-2">Password :</div>
        <input type="password" class="box" name="password" required>
        <div class="mt-2">Phone / Whatsapp :</div>
        <input type="text" class="box" name="phone" required>
        <div class="mt-2">City :</div>
        <input type="text" class="box" name="city" required>
        
        <button class="lebar-100 biru mt-3">Register</button>

        <div class="rata-tengah mt-3">
            already have account? <a href="{{ route('login') }}">login</a>
        </div>
    </form>
@endsection