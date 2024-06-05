<?php

namespace Modules\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'admin');
        $this->mergeConfigFrom(__DIR__ . '/../config/admin.php', 'admin');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
