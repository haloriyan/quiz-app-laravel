@extends('layouts.dashboard')

@section('content')
<h3>Standing {{ $standing[0]->quiz->title }}</h3>
<div class="overflowAuto mt-3">
    <table>
        <thead>
            <tr>
                <th>Participant Name</th>
                <th class="lebar-10">Point</th>
                <th class="lebar-20"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($standing as $stand)
                @php
                    $iPP = $i++;
                @endphp
                <tr>
                    <td>{{ $stand->participant->name }}</td>
                    <td>{{ $stand->point_total }}</td>
                    <td>
                        @if ($iPP <= 3 && $stand->has_mailed_for_prize == 0)
                            <button onclick="sendMail(this)" class="active"><i class="fas fa-envelope"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('javascript')
<script>
    const sendMail = btn => {
        btn.classList.remove('active')
        btn.classList.add('bg-hijau')
        btn.innerHTML = "<i class='fas fa-check'></i> Sent"
        setTimeout(() => {
            btn.classList.add('d-none')
        }, 1600);
    }
</script>
@endsection