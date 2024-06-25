<?php

namespace Blume\Providers;

use Blume\Services\ModulesService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->modulesAutoload();
    }

    protected function modulesAutoload()
    {
        (new ModulesService)->loadModules()
            ->each(function (string $moduleServiceProvider) {
                $this->app->register($moduleServiceProvider);
            });
    }
}
