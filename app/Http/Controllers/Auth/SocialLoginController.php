<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function redirect($social)
    {
        return Socialite::driver($social)->stateless()->redirect();
    }

    public function callback($social)
    {
        $user = Socialite::driver($social)->stateless()->user();

        User::query()->updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                $social . '_id' => $user->id,
                'avatar' => $user->avatar,
                'active' => true,
            ],
        );

        //TODO: xu li chuyen huong
        dd('thanh cong, se chuyen huong');

    }
}
