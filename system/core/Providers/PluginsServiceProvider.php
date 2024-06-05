<?php

namespace Blume\Providers;

use Blume\Models\Plugins;
use Blume\Services\PluginService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Schema;

class PluginsServiceProvider extends EventServiceProvider
{
    public function boot()
    {
        parent::boot();

        if (Schema::hasTable((new Plugins)->getTable())) {
            $pluginService = new PluginService();

            $pluginService->loadPlugins();
        }
    }
}
