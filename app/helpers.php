<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings;

        if (!$settings) {
            $settings = Setting::first();
        }

        return $settings?->$key ?? $default;
    }
}

