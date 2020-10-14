@extends('layouts.participant')

@section('title', $question->quiz->title)

@section('head.dependencies')
<style>
    .container { top: 140px; }
    .options { font-size: 24px; }
    .options .smallPadding .wrap { margin: 10% 15%; }
    .options button {
        width: 100%;
        background-color: #fff;
        padding: 0px;
        height: auto;
    }
    .wrongAnswer { opacity: 0.3; }
    .countdownTimer { 
        font-size: 35px;
        border-radius: 90px;
        color: #fff;
        position: fixed;
        top: 90px;right: 5%;
        line-height: 80px;
        width: 80px;
        text-align: center;
        background-color: #2c9cdb;
        z-index: 5;
    }
    @media (max-width: 480px) {
        .countdownTimer {
            width: 50px;
            line-height: 50px;
            font-size: 20px;
            top: 6px;right: 15%;
            font-family: ProBold;
        }
        .container { top: 90px; }
    }
</style>
@endsection

@section('content')
<div class="countdownTimer">{{ $question->quiz->countdown_time_per_question }}</div>
<form action="{{ route('submitAnswer') }}" method="POST" id="formQuiz">

    {{ csrf_field() }}
    <input type="hidden" id="countdown" value="{{ $question->quiz->countdown_time_per_question }}">

    <input type="hidden" name="participant_id" value="{{ $myData->id }}">
    <input type="hidden" name="question_id" value="{{ $question->id }}">
    <input type="hidden" name="answer" id="answer">
    <input type="hidden" name="is_correct" id="isCorrect">

    <h2>{{ $question->question }}</h2>
    <div class="bagi bagi-2 options">
        <div class="wrap">
            @php $isCorrect = $question->option_a == $question->correct_option ? "correct" : "" @endphp
            <div class="smallPadding rounded pointer bg-merah {{ $isCorrect }}" onclick="answer(`{{ $question->option_a }}`, this)">
                <div class="wrap">
                    <h3>&#x25B2; &nbsp;<span id="answer">{{ $question->option_a }}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="bagi bagi-2 options">
        <div class="wrap">
            @php $isCorrect = $question->option_b == $question->correct_option ? "correct" : "" @endphp
            <div class="smallPadding rounded pointer bg-biru {{ $isCorrect }}" onclick="answer(`{{ $question->option_b }}`, this)">
                <div class="wrap">
                    <h3>&#x25C6; &nbsp;<i class="fas fa-triangle"></i> <span id="answer">{{ $question->option_b }}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="bagi bagi-2 options">
        <div class="wrap">
            @php $isCorrect = $question->option_c == $question->correct_option ? "correct" : "" @endphp
            <div class="smallPadding rounded pointer bg-kuning {{ $isCorrect }}" onclick="answer(`{{ $question->option_c }}`, this)">
                <div class="wrap">
                    <h3><i class="fas fa-circle"></i> &nbsp; <span id="answer">{{ $question->option_c }}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="bagi bagi-2 options">
        <div class="wrap">
            @php $isCorrect = $question->option_d == $question->correct_option ? "correct" : "" @endphp
            <div class="smallPadding rounded pointer bg-hijau {{ $isCorrect }}" onclick="answer(`{{ $question->option_d }}`, this)">
                <div class="wrap">
                    <h3><i class="fas fa-square"></i> &nbsp; <span id="answer">{{ $question->option_d }}</span></h3>
                </div>
            </div>
        </div>
    </div>
    <div id="notAnswered"></div>

    <button class="lebar-100 d-none mt-2 biru">Lanjut</button>
</form>
@endsection

@section('javascript')
<script>
    let state = {
        hasAnswered: false,
        answer: '',
        isCorrect: null,
        countdown: document.querySelector("#countdown").value
    }

    let counting = state.countdown
    let countingDown = setInterval(() => {
        let decreaseCount = counting--
        select(".countdownTimer").innerText = decreaseCount
        if (decreaseCount == 0) {
            answer("not_answered", select("#notAnswered"))
        }
    }, 1000)

    const answer = (optionAnswer, dom) => {
        if (state.hasAnswered) {
            return false
        }
        selectAll(".options > .wrap > div").forEach(opt => {
            if (!opt.classList.contains('correct')) {
                opt.classList.add('wrongAnswer')
            }
        })
        let isCorrect = dom.classList.contains('correct')
        if (!isCorrect) {
            state.isCorrect = false
            // dom.classList.add('wrongAnswer')
        }else {
            state.isCorrect = true
        }
        state.answer = optionAnswer
        state.hasAnswered = true
        clearInterval(countingDown)

        select(".correct").classList.add('correctActive')
        select("form #isCorrect").value = state.isCorrect
        select("form #answer").value = state.answer

        setTimeout(() => {
            select("#formQuiz").submit()
        }, 1500);
    }
</script>
@endsection