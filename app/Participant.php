<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participant extends Authenticatable
{
    protected $fillable = [
        'name','email','password','phone','kota','ktp','point','status'
    ];

    public function history() {
        return $this->hasMany('App\History');
    }
}
