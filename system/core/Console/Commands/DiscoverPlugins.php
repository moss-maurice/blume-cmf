<?php

namespace Blume\Console\Commands;

use Illuminate\Console\Command;
use Blume\Models\Plugins;
use Blume\Services\PluginService;

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
