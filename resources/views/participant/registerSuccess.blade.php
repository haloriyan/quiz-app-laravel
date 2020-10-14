@extends('layouts.auth')

@section('title', 'Register Success')

@section('head.dependencies')
<style>
    p { line-height: 38px; }
    button {
        position: fixed;
        bottom: 0px;left: 0px;right: 0px;
        border-radius: 0px;
    }
</style>
@endsection

@section('content')
    <h1 style="margin-top: 115px;">Register Success!</h1>
    <p class="mt-3">
        Before you can login, please verify your account by clicking a link that sent to your email address.
    </p>

    <button class="biru lebar-100 mt-3">Resend Verification Link</button>
@endsection