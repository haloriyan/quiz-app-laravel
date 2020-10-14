@extends('layouts.participant')

@section('title', $standing[0]->quiz->title."'s result")

@section('head.dependencies')
<style>
    h3 { font-family: ProReg; }
    h3.bold { font-family: ProBold;color: #3498db; }
</style>
@endsection

@section('content')
<h2 class="mb-5">Standing</h2>
@foreach ($standing as $stand)
    <div class="item mb-3">
        <div class="d-inline-block lebar-50">
            <h3 class="ke-kiri {{ $stand->participant->id == $myData->id ? 'bold' : '' }}">{{ $stand->participant->name }}</h3>
        </div>
        <div class="d-inline-block lebar-45 rata-kanan">
            <p class="ke">{{ $stand->point_total }} poin</p>
        </div>
    </div>
@endforeach
@endsection