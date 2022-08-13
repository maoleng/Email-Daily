<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyRegisterRequest;
use App\Jobs\SystemSendMail;
use App\Mail\Register;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        $expire_verify_time = Carbon::make($user->email_verified_at)->addMinutes(User::TIME_VERIFY);
        if ($expire_verify_time->lt(now())) {
            $token_verify = random_int(1000, 9999);
            $user->update([
                'token_verify' => $token_verify,
                'email_verified_at' => now(),
            ]);
            $send_mail = new SystemSendMail([
                'email' => $data['email'],
                'mail_content' => new Register($token_verify),
            ]);
            dispatch($send_mail);
            Session::flash('message', 'Mã xác thực của bạn đã hết hạn, chúng tôi đã gửi 1 mã mới');
            return view('auth.otp', [
                'email' => $data['email'],
            ]);
        }

        if ($user->token_verify !== $data['token_verify']) {
            Session::flash('message', 'Sai mã xác thực');
            return view('auth.otp', [
                'email' => $data['email'],
            ]);
        }
        $user->update(['active' => true]);

        // TODO: Chuyển hướng login
        dd('thanh cong, se chuyen huong');

    }

    public function processLogin(LoginRequest $request)
    {
        $data = $request->validated();
        $auth = $this->auth($data['email'], $data['password']);
        $status = $auth['status'];
        $user = $auth['user'];
        if (empty($status) && $status !== false) {
            Session::flash('message', 'Sai tài khoản hoặc mật khẩu');
            return redirect()->back();
        }
        if (!$status) {
            $token_verify = random_int(1000, 9999);
            $user->update([
                'token_verify' => $token_verify,
                'email_verified_at' => now(),
            ]);
            $send_mail = new SystemSendMail([
                'email' => $data['email'],
                'mail_content' => new Register($token_verify),
            ]);
            dispatch($send_mail);
            Session::flash('message', 'Tài khoản chưa được kích hoạt, chúng tôi đã gửi đến bạn 1 mã xác thực, vui lòng xác thực tài khoản');
            return view('auth.otp', [
                'email' => $data['email'],
            ]);
        }

        // TODO: Chuyển hướng login
        dd('thanh cong, se chuyen huong');
    }

    public function auth($email, $password): array
    {
        $user = User::query()->where('email', $email)->first();
        if (empty($user)) {
            return [
                'status' => null,
                'user' => $user,
            ];
        }
        if (!$user->verify($password)) {
            return [
                'status' => null,
                'user' => $user,
            ];
        }
        if (!$user->active) {
            return [
                'status' => false,
                'user' => $user,
            ];
        }
        return [
            'status' => true,
            'user' => $user,
        ];
    }


}
