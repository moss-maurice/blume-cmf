<?php

namespace Lacora\Console\Commands;

use Illuminate\Console\Command;
use Lacora\Models\Plugins;
use Lacora\Services\PluginService;

class DiscoverPlugins extends Command
{
    protected $signature = 'plugins:discover';

    protected $description = 'Discover and register new plugins';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pluginService = new PluginService();

        $plugins = $pluginService->discoverPlugins();

        foreach ($plugins as $pluginClass) {
            if (!Plugins::where('class', $pluginClass)->exists()) {
                Plugins::create([
                    'name' => class_basename($pluginClass),
                    'class' => $pluginClass,
                    'active' => false,
                ]);
            }
        }

        $this->info('Plugins discovered successfully.');
    }
}
