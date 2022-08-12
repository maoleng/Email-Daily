<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SystemSendMail;
use App\Mail\Register;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot_password');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function processRegister(RegisterRequest $request): View
    {
        $data = $request->validated();
        $verify_code = random_int(1000, 9999);
        User::query()->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'name' => $data['name'],
            'token_verify' => $verify_code,
            'email_verified_at' => now(),
        ]);
        $send_mail = new SystemSendMail([
            'email' => $data['email'],
            'mail_content' => new Register($verify_code),
        ]);
        dispatch($send_mail);

        return view('auth.otp');
    }



}
