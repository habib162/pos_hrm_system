<?php

if (! function_exists('setting')) {
    /**
     * Get a setting value by key.
     * Uses the Cache-backed Setting::get() for fast reads.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return \Modules\Settings\App\Entities\Setting::get($key, $default);
    }
}
