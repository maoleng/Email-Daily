<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SendMailController;
use App\Http\Middleware\AuthLogin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth'], static function() {
    Route::get('/login', [AuthController::class, 'login']);
    Route::get('/{social}/redirect', [SocialLoginController::class, 'redirect'])->name('auth');
    Route::get('/{social}/callback', [SocialLoginController::class, 'callback'])->name('callback');
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send', [SendMailController::class, 'sendMail']);

Route::group(['prefix' => 'social', 'middleware' => AuthLogin::class], static function () {
    Route::get('/login', [SocialLoginController::class, 'login']);

});
