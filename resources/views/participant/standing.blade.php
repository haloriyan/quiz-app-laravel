@extends('layouts.participant')

@section('title', 'Standing')

@section('head.dependencies')
<style>
    .winner {
        display: inline-block;
        width: 32.5%;
        text-align: center;
        background-color: #3498db;
        color: #fff;
        padding: 25px;
        box-sizing: border-box;
        vertical-align: bottom;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
    }
    .winner p { color: #fff; }
    #winner1 { height: 250px; }
    #winner2 { height: 200px; }
    #winner3 { height: 150px; }
    .item h3 { font-size: 18px; }
</style>
@endsection

@section('content')
@php
    $i = 1;
@endphp
@foreach ($participants as $participant)
    @php
        $iPP = $i++;
    @endphp
    <div class="item mb-3 {{ $iPP <= 3 ? 'winner' : '' }}" id="{{ $iPP <= 3 ? 'winner'.$iPP : '' }}">
        <h3>{{ $participant->name }}</h3>
        <p>{{ $participant->point }} poin</p>
    </div>
@endforeach
@endsection