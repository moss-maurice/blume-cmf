<?php

namespace Blume\Foundation\Plugins;

use Blume\Foundation\Plugins\Interfaces\PluginInterface;

abstract class Plugin implements PluginInterface
{
    protected $listeners = [];

    public function registerListeners(): void
    {
        collect($this->listeners)->each(function ($listeners, $event) {
            collect($listeners)->each(function ($listener) use ($event) {
                blume()->events()
                    ->registerListener($event, $listener);
            });
        });
    }

    public function unregisterListeners(): void
    {
        collect($this->listeners)->each(function ($listeners, $event) {
            collect($listeners)->each(function ($listener) use ($event) {
                blume()->events()
                    ->unregisterListener($event, $listener);
            });
        });
    }
}
