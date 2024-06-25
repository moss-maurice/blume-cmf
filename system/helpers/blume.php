<?php

use Blume\Services\CoreService;

if (!function_exists('blume')) {
    function blume()
    {
        return app(CoreService::class);
    }
}
