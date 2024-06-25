<?php

namespace Blume\Console\Commands;

use Blume\Console\Traits\AutoHandlerCommand;
use Illuminate\Console\Command;

class Discover extends Command
{
    use AutoHandlerCommand;

    protected $signature = 'blume:discover {method=all}';

    protected $description = 'Discover and register blume application components';

    public function discoverAll()
    {
        $this->discoverPlugins();
    }

    public function discoverPlugins()
    {
        $plugins = blume()->plugins()->notInstalledPlugins();

        if ($plugins->isNotEmpty()) {
            $plugins->each(function ($plugin) {
                if (blume()->plugins()->installPlugin($plugin->name)) {
                    $this->line("  > Plugin '{$plugin->name}' installed.");
                }
            });
        } else {
            $this->line("  > Unregistered plugins not found.");
        }

        $this->info('  ');
        $this->info('  Plugins discovered successfully.');
    }
}
