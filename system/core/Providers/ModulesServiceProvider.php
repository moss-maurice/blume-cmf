<?php

namespace Blume\Providers;

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
        $modulesPath = app('path.modules');

        $modules = array_map('basename', File::directories($modulesPath));

        foreach ($modules as $module) {
            $module = ucfirst($module);

            $serviceProvider = "Modules\\{$module}\\{$module}ServiceProvider";

            if (class_exists($serviceProvider)) {
                $this->app->register($serviceProvider);
            }
        }
    }
}
