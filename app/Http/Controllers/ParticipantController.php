<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Answer;
use App\History;
use App\Participant;
use Illuminate\Http\Request;

use App\Http\Controllers\QuizController as QuizCtrl;

class ParticipantController extends Controller
{
    public function me() {
        return Auth::guard('participant')->user();
    }
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return Participant::paginate(10);
        }
        return Participant::where($filter);
    }
    public function loginPage() {
        $message = Session::get('message');
        return view('participant.login', [
            'message' => $message
        ]);
    }
    public function login(Request $req) {
        $email = $req->email;
        $password = $req->password;

        $loggingIn = Auth::guard('participant')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$loggingIn) {
            return redirect()->route('login')->withErrors(['Kombinasi Username atau Password salah']);
        }

        return redirect('/');
    }
    public function logout() {
        $loggingOut = Auth::guard('participant')->logout();
        return redirect()->route('login');
    }
    public function registerPage() {
        return view('participant.register');
    }
    public function register(Request $req) {
        $saveData = Participant::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
            'phone' => $req->phone,
            'kota' => $req->city,
            'ktp' => '',
            'point' => 0,
            'status' => 1
        ]);

        return redirect()->route('register.success');
    }
    public function registerSuccess() {
        return view('participant.registerSuccess');
    }
    public function home() {
        date_default_timezone_set('Asia/Jakarta');
        $myData = $this->me();
        $dateNow = date('Y-m-d');

        $availableQuiz = QuizCtrl::get([
            ['expired_on', '=', $dateNow]
        ])
        ->with('question')
        ->get();

        $histories = History::where([
            ['participant_id', '=', $myData->id]
        ])->get();
        
        $answeredQuiz = [];
        foreach ($histories as $history) {
            array_push($answeredQuiz, $history->quiz_id);
        }

        $dataToReturn = [];
        foreach ($availableQuiz as $quiz) {
            if (!in_array($quiz->id, $answeredQuiz)) {
                $dataToReturn[] = $quiz;
            }
        }

        return view('participant.home', [
            'quiz' => $dataToReturn
        ]);
    }
    public function quiz($id, $questionID) {
        $myData = $this->me();
        $question = QuizCtrl::getQuestion([
            ['id', '=', $questionID]
        ])
        ->with('quiz')
        ->first();

        return view('participant.quiz', [
            'question' => $question,
            'myData' => $myData
        ]);
    }
    public function historyCheck($participantID, $quizID) {
        $myData = $this->me();

        return History::where([
            ['participant_id', '=', $myData->id],
            ['quiz_id', '=', $quizID]
        ])
        ->first();
    }
    public function submitAnswer(Request $req) {
        $myData = $this->me();

        $questionID = $req->question_id;
        $answer = $req->answer;
        $is_correct = $req->is_correct;

        $question = QuizCtrl::getQuestion([
            ['id', '=', $questionID]
        ])
        ->with('quiz')
        ->first();

        $allQuestions = QuizCtrl::getQuestion([
            ['quiz_id', '=', $question->quiz->id]
        ])
        ->get();
        
        $nextQuestion = $i = 0;
        foreach ($allQuestions as $questionList) {
            $iPP = $i++;
            if ($questionID == $questionList->id) {
                if ($allQuestions[$iPP] == $allQuestions[$allQuestions->count() - 1]) {
                    $setToComplete = History::where([
                        ['participant_id', '=', $myData->id]
                    ])
                    ->update([
                        'is_complete' => 'true'
                    ]);

                    return redirect()->route('quiz.result', $question->quiz->id);
                }
                $nextQuestion = $allQuestions[$iPP + 1];
            }
        }

        // checking participant is it has answered or not
        if (!$this->historyCheck($myData->id, $question->quiz->id)) {
            $saveToHistory = History::create([
                'participant_id' => $myData->id,
                'quiz_id' => $question->quiz->id,
                'point_total' => 0,
                'is_complete' => 'false',
                'has_mailed_for_prize' => 0
            ]);
        }

        $saveAnswer = Answer::create([
            'participant_id' => $myData->id,
            'question_id' => $questionID,
            'answer' => $answer,
            'is_correct' => $is_correct
        ]);

        if ($is_correct == "true") {
            $increasePoint = History::where([
                ['participant_id', '=', $myData->id],
                ['quiz_id', '=', $question->quiz->id]
            ])
            ->update([
                'point_total' => DB::raw("point_total + $question->point")
            ]);

            $increaseTotalPoint = Participant::where('id', $myData->id)->update([
                'point' => DB::raw("point + $question->point")
            ]);
        }

        return redirect()->route('quiz', [$question->quiz->id, $nextQuestion->id]);
    }
    public function quizResult($id) {
        $myData = $this->me();

        $standing = History::where([
            ['quiz_id', '=', $id]
        ])
        ->orderBy('point_total', 'DESC')
        ->with('participant')
        ->with('quiz')
        ->paginate(25);

        return view('participant.result', [
            'standing' => $standing,
            'myData' => $myData
        ]);
    }
    public function history() {
        $myData = $this->me();
        $histories = History::where([
            ['participant_id', '=', $myData->id]
        ])
        ->with('quiz')
        ->get();

        return view('participant.history', [
            'histories' => $histories
        ]);
    }
    public function standing() {
        $myData = $this->me();
        $participants = Participant::orderBy('point', 'DESC')->paginate(10);

        return view('participant.standing', [
            'participants' => $participants
        ]);
    }
}
