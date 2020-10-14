<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $fillable = [
        'quiz_id','name','position'
    ];

    public function participant() {
        return $this->belongsTo('App\Participant', 'participant_id');
    }
    public function quiz() {
        return $this->belongsTo('App\Quiz', 'quiz_id');
    }
}
