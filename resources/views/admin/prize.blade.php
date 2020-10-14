@extends('layouts.dashboard')

@section('title', 'Prizes for '.$quiz->title)

@php
    $positionsInput = [1,2,3];
    foreach ($prizes as $prize) {
        $posisi = array_search($prize->position, $positionsInput);
        array_splice($positionsInput, $posisi, 1);
    }
@endphp

@section('content')
<h2 class="mb-5">Prize for {{ $quiz->title }}</h2>

<hr size="2" color="#2c9cdb" />
@if ($prizes->count() < 3)
    <div id="action">
        <button id="action" onclick="munculPopup('#addPrize')"><i class="fas fa-plus"></i> &nbsp; New Prize</button>
    </div>
@endif

<div class="overflowAuto mt-3">
    <table>
        <thead>
            <tr>
                <th class="lebar-5">Position</th>
                <th>Prize Name</th>
                <th>Participant</th>
                <th class="lebar-10">Point</th>
                <th class="lebar-25"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prizes as $prize)
                @php
                    $hasMailed = $prize->standing->has_mailed_for_prize;
                    $participantName = $prize->standing->participant->name != "" ? $prize->standing->participant->name : "";
                @endphp
                <tr>
                    <td>{{ $prize->position }}</td>
                    <td>{{ $prize->name }}</td>
                    <td><a href="{{ route('admin.participant', ['q' => $participantName]) }}">{{ $participantName }}</a></td>
                    <td>{{ $prize->standing->point_total }}</td>
                    <td>
                        @if (!$hasMailed)
                            <button onclick="sendNotif(`{{ $prize }}`, this)" class="active"><i class="fas fa-envelope"></i> &nbsp; Send Notification</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="addPrize">
    <div class="popup">
        <div class="wrap">
            <h3>Add New Prizes
                <i class="fas fa-times ke-kanan pointer" onclick="hilangPopup('#addPrize')"></i>
            </h3>
            <form action="{{ route('prize.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                <div class="mt-2">Prize name :</div>
                <input type="text" class="box" name="name" required>
                <div class="mt-2">For position :</div>
                <select name="position" class="box">
                    @foreach ($positionsInput as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>

                <button class="lebar-100 active tinggi-45 mt-3">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    const sendNotif = (data, btn) => {
        btn.innerHTML = "<i class='fas fa-spinner'></i> &nbsp; Sending..."
        data = JSON.parse(data)
        let req = post("{{ route('api.sendPrizeNotif') }}", {
            data: data
        })
        .then(res => {
            btn.classList.remove('active')
            btn.classList.add('bg-hijau')
            btn.innerHTML = "<i class='fas fa-check'></i> &nbsp; Notif Sent"
            setTimeout(() => {
                btn.classList.add('d-none')
            }, 1700)
        })
    }
</script>
@endsection