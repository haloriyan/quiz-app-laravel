@extends('layouts.dashboard')

@section('title', 'Create New Quiz')

@section('content')
<h2>Create New Quiz</h2>
<form action="#" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>Title :</div>
    <input type="text" class="box" name="name">
</form>
@endsection