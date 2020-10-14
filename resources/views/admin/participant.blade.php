@extends('layouts.dashboard')

@section('title', 'Data Peserta')

@section('content')
<div class="bagi lebar-15" id="filter">
    <select class="box">
        <option>Lihat Daftar</option>
        <option>Lihat Sesuai Produk</option>
    </select>
</div>
<div class="bagi lebar-5">&nbsp;</div>
<div class="bagi lebar-80">
    <form action="{{ route('admin.participant') }}" id="searchForm">
        <input type="text" class="box" placeholder="Search..." name="q" value="{{ $q }}">
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Total Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($participants as $participant)
            <tr>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->email }}</td>
                <td>{{ $participant->phone }}</td>
                <td>{{ $participant->kota }}</td>
                <td>{{ $participant->point }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection