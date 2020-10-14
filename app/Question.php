<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id','question','option_a','option_b','option_c','option_d','correct_option','point'
    ];

    public function quiz() {
        return $this->belongsTo('App\Quiz', 'quiz_id');
    }
}
