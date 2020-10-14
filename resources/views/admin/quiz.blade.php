@extends('layouts.dashboard')

@section('title', 'Quiz List')

@php
    $filters = ['' => "All", 1 => "Active", 0 => "Expired"];
@endphp

@section('head.dependencies')
    <link rel="stylesheet" href="{{ asset('js/flatpickr/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/flatpickr/dist/themes/material_blue.css') }}">
    <style>
        .action {
            position: absolute;
            right: 0px;
            border: none;
            background-color: #fff;
            margin-top: -5px;
            display: none;
            padding: 15px 25px;
            border: 1px solid #ddd;
        }
        td .toggleAction:hover ~ .action {
            display: block;
        }
        .action:hover {
            display: block;
        }
    </style>
@endsection

@section('content')
<div class="bagi lebar-15" id="filter">
    <select class="box" onchange="filter(this.value)">
        @foreach ($filters as $key => $f)
            @php $selected = $f == $filter ? "selected='selected'" : ""; @endphp
            <option {{ $selected }} value="{{ $f }}">{{ $f }}</option>
        @endforeach
    </select>
</div>
<div class="bagi lebar-5">&nbsp;</div>
<div class="bagi lebar-80">
    <form action="{{ route('admin.quiz') }}" id="searchForm">
        <input type="text" class="box" placeholder="Search..." name="q" value="{{ $q }}">
    </form>
</div>

@if (Auth::guard('admin')->user()->role == 1)
    <hr size="2" color="#2c9cdb" />
    <div id="action">
        <button id="action" onclick="munculPopup('#createQuiz')"><i class="fas fa-plus"></i> &nbsp; New Quiz</button>
    </div>
@endif

@if ($message != "")
    <div class="bg-hijau-transparan mt-2 rounded p-2">
        {{ $message }}
    </div>
@endif

@php
    use Carbon\Carbon;
@endphp

<div class="overflowAutoMobile mt-2">
    <table style="position: relative;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Participants</th>
                <th>Date</th>
                <th class="lebar-10"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quiz as $q)
                <tr>
                    <td>{{ $q->title }}</td>
                    <td>{{ $q->description }}</td>
                    <td></td>
                    <td>{{ Carbon::parse($q->expired_on)->format('d M Y') }}</td>
                    <td class="rata-kanan">
                        <button class="active toggleAction"><i class="fas fa-angle-down"></i></button>
                        <div class="action">
                            <a href="{{ route('admin.question', $q->id) }}"><button class="bordered"><i class="fas fa-question"></i></button></a>
                            <a href="{{ route('admin.prize', $q->id) }}"><button class="active"><i class="fas fa-trophy"></i></button></a>
                            <a href="{{ route('admin.questionReport', $q->id) }}"><button class="bg-hijau"><i class="fas fa-chart-line"></i></button></a>
                            @if (Auth::guard('admin')->user()->role == 1)
                                <button class="bg-biru" onclick="edit(`{{ $q }}`)"><i class="fas fa-edit"></i></button>
                                <a href="{{ route('quiz.delete', $q->id) }}"><button class="bg-merah"><i class="fas fa-trash"></i></button></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="createQuiz">
    <div class="popup">
        <div class="wrap">
            <h3>Buat Kuis Baru
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#createQuiz')"></i>
            </h3>
            @if ($errors->count() != 0)
                @foreach ($errors->all() as $err)
                    <div class="bg-merah-transparan mb-2 rounded p-2">
                        {{ $err }}
                    </div>
                @endforeach
            @endif
            <form action="{{ route('quiz.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="mt-2">Judul :</div>
                <input type="text" class="box" name="title" required>
                <div class="mt-2">Deskripsi :</div>
                <textarea name="description" class="box" required></textarea>
                <div class="mt-2">Untuk Tanggal :</div>
                <input type="text" class="box" name="expired_on" id="exp_on_createForm" required>
                <div class="mt-2">Countdown Timer Setiap Pertanyaan (detik) :</div>
                <input type="number" name="countdown_time_per_question" class="box" required value="10">

                <button class="active lebar-100 mt-2">Buat</button>
            </form>
        </div>
    </div>
</div>

<div class="popupWrapper" id="editQuiz">
    <div class="popup">
        <div class="wrap">
            <h3>Edit Kuis
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#editQuiz')"></i>
            </h3>
            @if ($errors->count() != 0)
                @foreach ($errors->all() as $err)
                    <div class="bg-merah-transparan mb-2 rounded p-2">
                        {{ $err }}
                    </div>
                @endforeach
            @endif
            <form action="{{ route('quiz.update') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_id" id="quiz_id">
                <div class="mt-1 teks-transparan">(Biarkan jika tidak ingin mengganti cover)</div>

                <div class="mt-2">Judul :</div>
                <input type="text" class="box" name="title" id="title" required>
                <div class="mt-2">Deskripsi :</div>
                <textarea name="description" class="box" id="description" required></textarea>
                <div class="mt-2">Untuk Tanggal :</div>
                <input type="text" class="box" name="expired_on" id="exp_on_editForm" required>
                <div class="mt-2">Countdown Timer Setiap Pertanyaan (detik) :</div>
                <input type="number" name="countdown_time_per_question" id="countdown" class="box" required value="10">

                <button class="active lebar-100 mt-2">Ubah</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/flatpickr/dist/flatpickr.min.js') }}"></script>
<script>
    flatpickr("#exp_on_createForm", {
        dateFormat: 'Y-m-d',
    })
    const edit = data => {
        flatpickr("#exp_on_editForm", {
            dateFormat: 'Y-m-d',
        })
        data = JSON.parse(jsonEscape(data))
        munculPopup("#editQuiz")
        select("#editQuiz #quiz_id").value = data.id
        select("#editQuiz #title").value = data.title
        select("#editQuiz #description").value = jsonUnescape(data.description)
        select("#editQuiz #exp_on_editForm").value = data.expired_on
    }
    const filter = data => {
        let url = new URL(document.URL)
        url.searchParams.set('filter', data)
        window.location = url.toString()
    }
</script>

@if ($errors->count() != 0)
    <script>
        munculPopup("#createQuiz")
    </script>
@endif
@endsection