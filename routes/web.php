<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function() {
    Route::get('login', 'AdminController@loginPage')->name('admin.loginPage');
    Route::post('login', 'AdminController@login')->name('admin.login');
    Route::get('logout', 'AdminController@logout')->name('admin.logout');

    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard')->middleware('Admin');
    Route::get('{id}/report', 'AdminController@questionReport')->name('admin.questionReport')->middleware('Admin');

    Route::get('admin', 'AdminController@admin')->name('admin.admin')->middleware('Admin');
    Route::post('store', 'AdminController@store')->name('admin.store')->middleware('Admin');
    Route::post('update', 'AdminController@update')->name('admin.update')->middleware('Admin');

    Route::get('participant', 'AdminController@participant')->name('admin.participant')->middleware('Admin');

    Route::get('quiz/{id}/prize', 'AdminController@prize')->name('admin.prize')->middleware('Admin');
    
    Route::get('quiz', 'AdminController@quiz')->name('admin.quiz')->middleware('Admin');
    Route::get('quiz/create', 'QuizController@create')->name('admin.quiz.create')->middleware('Admin');
    Route::get('quiz/{id}/question', 'AdminController@question')->name('admin.question')->middleware('Admin');
    Route::get('quiz/{id}/answers', 'AdminController@quizAnswer')->name('admin.quizAnswer')->middleware('Admin');
});

Route::group(['prefix' => 'quiz'], function() {
    Route::post('store', 'QuizController@store')->name('quiz.store')->middleware('Admin');
    Route::get('{id}/delete', 'QuizController@delete')->name('quiz.delete')->middleware('Admin');
    Route::post('update', 'QuizController@update')->name('quiz.update')->middleware('Admin');
});

Route::group(['prefix' => 'question'], function() {
    Route::post('store', 'QuizController@storeQuestion')->name('question.store')->middleware('Admin');
    Route::get('{id}/delete', 'QuizController@deleteQuestion')->name('question.delete')->middleware('Admin');
    Route::post('update', 'QuizController@updateQuestion')->name('question.update')->middleware('Admin');
});

Route::group(['prefix' => 'prize'], function() {
    Route::post('store', 'PrizeController@store')->name('prize.store')->middleware('Admin');
});

Route::get('/', 'ParticipantController@home')->name('home')->middleware('User');
Route::get('history', 'ParticipantController@history')->name('history')->middleware('User');
Route::get('standing', 'ParticipantController@standing')->name('standing')->middleware('User');
Route::get('quiz/{id}/question/{QuestionID}', 'ParticipantController@quiz')->name('quiz')->middleware('User');
Route::get('quiz/{id}/result', 'ParticipantController@quizResult')->name('quiz.result')->middleware('User');
Route::post('submit-answer', 'ParticipantController@submitAnswer')->name('submitAnswer')->middleware('User');

Route::get('login', 'ParticipantController@loginPage')->name('login');
Route::get('logout', 'ParticipantController@logout')->name('logout');
Route::get('register', 'ParticipantController@registerPage')->name('register');
Route::get('register-success', 'ParticipantController@registerSuccess')->name('register.success');
Route::post('login', 'ParticipantController@login')->name('login.action');
Route::post('register', 'ParticipantController@register')->name('register.action');
