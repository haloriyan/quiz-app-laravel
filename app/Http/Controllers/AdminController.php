<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Prize;
use App\Admin;
use App\History;
use Illuminate\Http\Request;

use App\Http\Controllers\QuizController as QuizCtrl;
use App\Http\Controllers\PrizeController as PrizeCtrl;
use App\Http\Controllers\ParticipantController as ParticipantCtrl;

class AdminController extends Controller
{
    public function loginPage() {
        return view('admin.login');
    }
    public function login(Request $req) {
        $username = $req->username;
        $password = $req->password;

        $loggingIn = Auth::guard('admin')->attempt([
            'username' => $username,
            'password' => $password
        ]);

        if (!$loggingIn) {
            return redirect()->route('admin.loginPage')->withErrors(['Kombinasi Username atau Password salah']);
        }

        return redirect()->route('admin.dashboard');
    }
    public function add() {
        return view('admin.admin.add');
    }
    public function store(Request $req) {
        $name = $req->name;
        $username = $req->username;
        $password = $req->password;
        $role = $req->role;

        $saveData = Admin::create([
            'name' => $name,
            'username' => $username,
            'password' => bcrypt($password),
            'role' => $role
        ]);

        return redirect()->route('admin.admin')->with([
            'message' => "New admin has successfully added"
        ]);
    }
    public function update(Request $req) {
        $id = $req->admin_id;

        $updateData = Admin::where('id', $id)->update([
            'name' => $req->name,
            'username' => $req->username,
            'role' => $req->role
        ]);

        return redirect()->route('admin.admin')->with([
            'message' => "Admin data has changed"
        ]);
    }
    public function dashboard() {
        return view('admin.dashboard');
    }
    public function quiz(Request $req) {
        $q = $req->q;
        $filter = $req->filter;

        if ($filter == "" || $filter == "All") {
            $f = [['expired_on', '!=', '%2105-02-02%']];
        }else {
            $dateNow = date_default_timezone_set('Asia/Jakarta');
            if ($filter == "Expired") {
                $f = [
                    ['expired_on', '>=', $dateNow]
                ];
            }else if ($filter == "Active") {
                $f = [
                    ['expired_on', '<=', $dateNow]
                ];
            }
        }
        if ($q != "") {
            array_push($filter, [
                'title', 'like', '%'.$q.'%'
            ]);
        }

        $quiz = QuizCtrl::get($f)->orderBy('expired_on', 'DESC')->paginate(10);
        $message = Session::get('message');

        return view('admin.quiz', [
            'quiz'=> $quiz,
            'message' => $message,
            'q' => $q,
            'filter' => $filter
        ]);
    }
    public function question($id) {
        $quiz = QuizCtrl::get([
            ['id', '=', $id]
        ])->with('question')->first();
        $message = Session::get('message');

        return view('admin.quiz.question', [
            'quiz' => $quiz,
            'message' => $message
        ]);
    }
    public function participant(Request $req) {
        $q = $req->q;
        $message = Session::get('message');
        
        $queryFilter = [['name', '!=' , ';']];
        if ($q != "") {
            array_push($queryFilter, [
                'name', 'like', '%'.$q.'%'
            ]);
        }
        
        $participants = ParticipantCtrl::get($queryFilter)->paginate(10);
        
        return view('admin.participant', [
            'message' => $message,
            'participants' => $participants,
            'q' => $q
        ]);
    }
    public function questionReport($id) {
        $standing = History::where([
            ['quiz_id', '=', $id]
        ])
        ->orderBy('point_total', 'DESC')
        ->with('participant')
        ->with('quiz')
        ->paginate(10);

        return view('admin.standing', [
            'standing' => $standing
        ]);
    }
    public function prize($quizID) {
        $quiz = QuizCtrl::get([
            ['id', '=', $quizID]
        ])->first();

        $prizes = PrizeCtrl::get([
            ['quiz_id', '=', $quizID]
        ])
        ->with('quiz')
        ->with('participant')
        ->orderBy('position', 'ASC')
        ->get();

        $standings = QuizCtrl::standing($quizID, 3);

        $i = 0;
        date_default_timezone_set('Asia/Jakarta');
        $dateNow = date('Y-m-d');

        foreach ($prizes as $prize) {
            $iPP = $i++;
            $standing = $standings[$prize->position - 1];
            $prize->standing = $standing;
            if ($prize->participant_id == null && $prize->quiz->expired_on > $dateNow) {
                $updateData = PrizeCtrl::update($prize->id, ['participant_id' => $participant->participant_id]);
            }
        }

        return view('admin.prize', [
            'quiz' => $quiz,
            'prizes' => $prizes
        ]);
    }
    public function admin() {
        $admins = Admin::all();
        $message = Session::get('message');

        return view('admin.admin', [
            'admins' => $admins,
            'message' => $message
        ]);
    }
}
