<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRegisterRequest;
use App\Jobs\SystemSendMail;
use App\Mail\Register;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

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
        $token_verify = random_int(1000, 9999);
        $user = User::query()->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'name' => $data['name'],
            'token_verify' => $token_verify,
            'email_verified_at' => now(),
        ]);
        (new DeviceController())->createDevice($user, $data['device_id']);

        $send_mail = new SystemSendMail([
            'email' => $data['email'],
            'mail_content' => new Register($token_verify),
        ]);
        dispatch($send_mail);

        return view('auth.otp', [
            'email' => $data['email'],
        ]);
    }

    public function verifyRegister(VerifyRegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();
        if (empty($user)) {
            return redirect()->route('auth.register');
        }
        if ($user->token_verify !== $data['token_verify']) {
            Session::flash('message', 'Wrong code');
            return view('auth.otp', [
                'email' => $data['email'],
            ]);
        }
        $user->update(['active' => true]);
        dd('thanh cong, se chuyen huong');

    }

    public function processLogin()
    {

    }



}
