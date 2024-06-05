<?php

namespace Blume\Providers;

use Blume\Services\CoreService;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('core', function ($app) {
            return new CoreService;
        });
    }
}
