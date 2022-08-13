<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SendMailController;
use App\Http\Middleware\AuthLogin;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], static function() {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('process_login');
    Route::get('/forgot_password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('process_register');
    Route::post('/verify_register', [AuthController::class, 'verifyRegister'])->name('verify_register');
    Route::get('/{social}/redirect', [SocialLoginController::class, 'redirect'])->name('redirect');
    Route::get('/{social}/callback', [SocialLoginController::class, 'callback'])->name('callback');
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send', [SendMailController::class, 'sendMail']);

Route::group(['prefix' => 'social', 'middleware' => AuthLogin::class], static function () {
    Route::get('/login', [SocialLoginController::class, 'login']);

});
