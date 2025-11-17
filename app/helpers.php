<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $row = Setting::first();
        return $row ? ($row->$key ?? $default) : $default;
    }
}
