<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialLoginController extends Controller
{

    public function redirect($social, Request $request): RedirectResponse
    {
        session()->put('device_id', $request->get('device_id'));
        if ($social !== 'twitter') {
            return Socialite::driver($social)->stateless()->redirect();
        }

        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = $social !== 'twitter' ? (Socialite::driver($social)->stateless()->user()) : (Socialite::driver($social)->user());
        $user = User::query()->updateOrCreate(
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

        $device = (new DeviceController())->createDevice($user, session()->get('device_id'));
        session()->put('token', $device->token);

        return redirect()->route('template.index');

    }
}
