<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send', [\App\Http\Controllers\SendMailController::class, 'sendMail']);
