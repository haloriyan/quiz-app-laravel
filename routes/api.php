<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('prize/sendNotif', 'PrizeController@sendNotif')->name('api.sendPrizeNotif');
