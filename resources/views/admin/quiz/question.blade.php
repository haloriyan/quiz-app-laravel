@extends('layouts.dashboard')

@section('title', 'Daftar Pertanyaan')

@section('content')
<hr size="2" color="#2c9cdb" />
<div id="action">
    <button id="action" onclick="munculPopup('#addQuestion')"><i class="fas fa-plus"></i> &nbsp; Pertanyaan</button>
</div>

@if ($message != "")
    <div class="bg-hijau-transparan mt-2 rounded p-2">
        {{ $message }}
    </div>
@endif

<div class="overflowAuto mt-2">
    <table>
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Opsi A</th>
                <th>Opsi B</th>
                <th>Opsi C</th>
                <th>Opsi D</th>
                <th>Poin</th>
                <th class="lebar-10"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quiz->question as $question)
                @php
                    $optionA = $question->option_a == $question->correct_option ? "<div class='bg-hijau p-1 pl-2 pr-2 rounded'>".$question->option_a."</div>" : $question->option_a;
                    $optionB = $question->option_b == $question->correct_option ? "<div class='bg-hijau p-1 pl-2 pr-2 rounded'>".$question->option_b."</div>" : $question->option_b;
                    $optionC = $question->option_c == $question->correct_option ? "<div class='bg-hijau p-1 pl-2 pr-2 rounded'>".$question->option_c."</div>" : $question->option_c;
                    $optionD = $question->option_d == $question->correct_option ? "<div class='bg-hijau p-1 pl-2 pr-2 rounded'>".$question->option_d."</div>" : $question->option_d;
                @endphp
                <tr>
                    <td>{{ $question->question }}</td>
                    <td>{!! $optionA !!}</td>
                    <td>{!! $optionB !!}</td>
                    <td>{!! $optionC !!}</td>
                    <td>{!! $optionD !!}</td>
                    <td>{{ $question->point }}</td>
                    <td class="rata-tengah">
                        <a href="{{ route('question.delete', $question->id) }}" class="teks-merah">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg"></div>
<div class="popupWrapper" id="addQuestion">
    <div class="popup">
        <div class="wrap">
            <h3>Tambah Pertanyaan Baru
                <i class="fas fa-times pointer ke-kanan" onclick="hilangPopup('#addQuestion')"></i>
            </h3>
            <form action="{{ route('question.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                <div class="mt-2">Pertanyaan :</div>
                <input type="text" class="box" name="question" required>
                <div class="bagi bagi-2">
                    <div class="mt-2">Opsi A :</div>
                    <input type="text" class="box" name="option_a" required>
                </div>
                <div class="bagi bagi-2">
                    <div class="mt-2">Opsi B :</div>
                    <input type="text" class="box" name="option_b" required>
                </div>
                <div class="bagi bagi-2">
                    <div class="mt-2">Opsi C :</div>
                    <input type="text" class="box" name="option_c" required>
                </div>
                <div class="bagi bagi-2">
                    <div class="mt-2">Opsi D :</div>
                    <input type="text" class="box" name="option_d" required>
                </div>

                <div class="mt-2">Opsi yang Benar :</div>
                <select name="correct_option" class="box">
                    <option value="option_a">Opsi A</option>
                    <option value="option_b">Opsi B</option>
                    <option value="option_c">Opsi C</option>
                    <option value="option_d">Opsi D</option>
                </select>

                <div class="mt-2">Bobot poin :</div>
                <input type="number" class="box" name="point" required>

                <button class="lebar-100 active mt-3 tinggi-50">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // munculPopup("#addQuestion")
</script>
@endsection