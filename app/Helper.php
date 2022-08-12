<?php

use App\Models\Config;
use Illuminate\Support\Facades\App;

if (!function_exists('c')) {
    function c(string $key)
    {
        return App::make($key);
    }
}

if (!function_exists('getConfig')) {
    function getConfig($key)
    {
        $config = Config::query()->where('key', $key)->first();
        return $config->value ?? null;
    }
}
