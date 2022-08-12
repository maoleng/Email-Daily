<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Lib\JWT\JWT;
use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DeviceController extends Controller
{
    public function generateToken($user)
    {
        return c(JWT::class)->encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function createDevice(User $user, $device_id): Builder|Model
    {
        $device = Device::query()->firstOrNew([
            'device_id' => $device_id,
        ]);
        $device->user_id = $user->id;
        $device->device_id = $device_id;
        $device->token = $this->generateToken($user);
        $device->save();
        Device::query()
            ->where('device_id', $device_id)
            ->where('id', '!=', $device->id)
            ->delete();

        return $device;
    }

}
