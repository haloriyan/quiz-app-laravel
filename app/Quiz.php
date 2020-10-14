<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title','description','expired_on','countdown_time_per_question'
    ];

    public function question() {
        return $this->hasMany('App\Question');
    }
    public function history() {
        return $this->hasMany('App\History');
    }
    public function answer() {
        return $this->hasMany('App\Answer');
    }
}
