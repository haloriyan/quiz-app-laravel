<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'participant_history';

    protected $fillable = [
        'participant_id','quiz_id','point_total','is_complete','has_mailed_for_prize'
    ];

    public function participant() {
        return $this->belongsTo('App\Participant', 'participant_id');
    }
    public function quiz() {
        return $this->belongsTo('App\Quiz', 'quiz_id');
    }
}
