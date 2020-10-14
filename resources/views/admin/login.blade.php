@extends('layouts.auth')

@section('content')
    <h2 class="mb-5">Login Admin</h2>
    <form action="#" method="POST">
        {{ csrf_field() }}
        @if ($errors->count() != 0)
            @foreach ($errors->all() as $err)
                <div class="bg-merah-transparan mb-2 rounded p-2">
                    {{ $err }}
                </div>
            @endforeach
        @endif
        <div>Username :</div>
        <input type="text" class="box" name="username" required>
        <div class="mt-2">Password :</div>
        <input type="password" class="box" name="password" required>
        <button class="lebar-100 biru mt-3">Login</button>
    </form>
@endsection