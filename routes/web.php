<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\TemplateController;
use App\Http\Middleware\AuthLogin;
use App\Http\Middleware\IfAlreadyLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => [IfAlreadyLogin::class]], static function() {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('process_login');
    Route::get('/forgot_password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
    Route::post('/reset_password', [AuthController::class, 'processResetPassword'])->name('reset_password');
    Route::post('/verify_reset_password', [AuthController::class, 'verifyResetPassword'])->name('verify_reset_password');
    Route::post('/update_password', [AuthController::class, 'updatePassword'])->name('update_password');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('process_register');
    Route::post('/verify_register', [AuthController::class, 'verifyRegister'])->name('verify_register');
    Route::post('/verify_new_location', [AuthController::class, 'verifyNewLocation'])->name('verify_new_location');
    Route::get('/{social}/redirect', [SocialLoginController::class, 'redirect'])->name('redirect');
    Route::get('/{social}/callback', [SocialLoginController::class, 'callback'])->name('callback');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => [AuthLogin::class]], static function () {
    Route::group(['prefix' => 'template', 'as' => 'template.'], static function () {
        Route::get('/', [TemplateController::class, 'index'])->name('index');
        Route::get('/create', [TemplateController::class, 'create'])->name('create');
        Route::post('/create', [TemplateController::class, 'store'])->name('store');
        Route::get('/edit/{template}', [TemplateController::class, 'edit'])->name('edit');
        Route::put('/update/{template}', [TemplateController::class, 'update'])->name('update');
        Route::put('/toggle_active/{template}', [TemplateController::class, 'toggleActive'])->name('toggle_active');
        Route::delete('/{template}', [TemplateController::class, 'destroy'])->name('destroy');
    });
});


Route::get('/test', function () {
    $cron = new Cron\CronExpression('0 */4 * * *');
    dd( $cron->getNextRunDate()->format('Y-m-d H:i:s'));
})->name('test');
Route::get('/send', [SendMailController::class, 'sendMail']);

Route::group(['prefix' => 'social', 'middleware' => AuthLogin::class], static function () {
    Route::get('/login', [SocialLoginController::class, 'login']);

});
Route::post('/test123', function (Request $request) {
    dd($request->all());
})->name('postok');
