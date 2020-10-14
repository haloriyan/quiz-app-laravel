@extends('layouts.participant')

@section('title', "Quiz App")

@section('content')
@if (count($quiz) == 0)
    <h3>There is no available quiz to answer</h3>
@else
    @foreach ($quiz as $q)
        <a href="{{ route('quiz', [$q->id, $q->question[0]->id]) }}">
            <div class="item mb-3">
                <h3>{{ $q->title }}</h3>
                <p>{{ $q->question->count() }} pertanyaan</p>
            </div>
        </a>
    @endforeach
@endif
@endsection