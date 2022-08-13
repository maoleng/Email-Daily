<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Models\Device;
use App\Models\User;

class VerifyRegisterRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'token_verify' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
                'exists:App\Models\User,email',
            ],
            'device_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $device = Device::query()
                        ->where('device_id', $value)
                        ->where('user_id', User::query()->where('email', $this->email)->first()->id)
                        ->first();
                    if (empty ($device)) {
                        return $fail(':attribute không hợp lệ');
                    }
                }
            ],
        ];
    }
}
