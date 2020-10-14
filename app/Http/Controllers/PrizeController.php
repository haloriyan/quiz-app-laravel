<?php

namespace App\Http\Controllers;

use App\Prize;
use App\History;
use App\Mail\MailPrize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrizeController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return Prize::all();
        }
        return Prize::where($filter);
    }
    public function store(Request $req) {
        $quizID = $req->quiz_id;
        $name = $req->name;
        $position = $req->position;

        $saveData = Prize::create([
            'quiz_id' => $quizID,
            'name' => $name,
            'position' => $position,
        ]);

        return redirect()->route('admin.prize', $quizID);
    }
    public static function update($id, $toUpdate) {
        return Prize::where('id', $id)->update($toUpdate);
    }
    public function sendNotif(Request $req) {
        $data = $req->data;
        $name = $data['standing']['participant']['name'];
        $email = $data['standing']['participant']['email'];
        $prizeName = $data['name'];

        $setMailStatus = History::where([
            ['participant_id', '=', $data['standing']['participant_id']],
            ['quiz_id', '=', $data['standing']['quiz_id']]
        ])->update([
            'has_mailed_for_prize' => 1
        ]);

        Mail::to($email)->send(new MailPrize([
            'name' => $name,
            'prizeName' => $prizeName,
            'from' => [
                'name' => config('email.APP_NAME'),
                'email' => config('email.CONTACT_EMAIL')
            ]
        ]));

        return response()->json([
            'data' => $prizeName
        ]);
    }
}
