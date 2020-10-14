@extends('layouts.participant')

@section('title', 'Quiz History')

@section('content')
@foreach ($histories as $history)
    <a href="{{ route('quiz.result', $history->quiz->id) }}">
        <div class="item mb-3">
            <h3>{{ $history->quiz->title }}</h3>
            <p>{{ $history->point_total }} poin</p>
        </div>
    </a>
@endforeach
@endsection