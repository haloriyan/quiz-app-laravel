<?php

namespace App\Http\Controllers;

use Storage;
use App\Quiz;
use App\History;
use App\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return Quiz::paginate(10);
        }
        return Quiz::where($filter);
    }
    public static function standing($id, $limit = NULL) {
        if ($limit == NULL) {
            $limit = 10;
        }
        return History::where([
            ['quiz_id', '=', $id]
        ])
        ->orderBy('point_total', 'DESC')
        ->with('participant')
        // ->with('quiz')
        ->paginate($limit);
    }
    public static function getQuestion($filter = NULL) {
        if ($filter == NULL) {
            return Question::paginate(10);
        }
        return Question::where($filter);
    }
    public function store(Request $req) {
        $title = $req->title;
        $description = $req->description;
        $expired_on = $req->expired_on;
        $countdown_time_per_question = $req->countdown_time_per_question;

        $saveData = Quiz::create([
            'title' => $title,
            'description' => $description,
            'expired_on' => $expired_on,
            'countdown_time_per_question' => $countdown_time_per_question
        ]);

        return redirect()->route('admin.quiz')->with([
            'message' => "Kuis baru berhasil dibuat"
        ]);
    }
    public function update(Request $req) {
        $id = $req->quiz_id;
        $quiz = Quiz::where('id', $id)->update([
            'title' => $req->title,
            'description' => $req->description,
            'expired_on' => $req->expired_on,
            'countdown_time_per_question' => $req->countdown_time_per_question
        ]);

        return redirect()->route('admin.quiz')->with([
            'message' => "Data kuis berhasil diubah"
        ]);
    }
    public function delete($id) {
        $quiz = Quiz::where('id', $id)->delete();
        
        return redirect()->route('admin.quiz')->with([
            'message' => "Kuis berhasil dihapus"
        ]);
    }
    public function storeQuestion(Request $req) {
        $quiz_id = $req->quiz_id;
        $correctOption = $req->correct_option;

        $saveData = Question::create([
            'quiz_id' => $quiz_id,
            'question' => $req->question,
            'option_a' => $req->option_a,
            'option_b' => $req->option_b,
            'option_c' => $req->option_c,
            'option_d' => $req->option_d,
            'correct_option' => $req->$correctOption,
            'point' => $req->point
        ]);

        return redirect()->route('admin.question', $quiz_id)->with([
            'message' => "Pertanyaan baru telah ditambahkan"
        ]);
    }
    public function deleteQuestion($id) {
        $question = Question::where('id', $id);
        $quiz_id = $question->first()->quiz_id;
        $question->delete();
        
        return redirect()->route('admin.question', $quiz_id)->with([
            'message' => "Pertanyaan berhasil dihapus"
        ]);
    }
}
