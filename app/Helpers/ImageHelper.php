<?php

if (!function_exists('ImageHelper')) {
    function showImage(?string $path = null, string $default = 'administrator/assets/images/logo-sm.png'): string
    {
        if (!$path) {
            return asset($default);
        }

        // full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // storage/app/public
        if (file_exists(storage_path('app/public/' . $path))) {
            return asset('storage/' . $path);
        }

        return asset($default);
    }
}