<?php

namespace Blume\Foundation\Core;

use Blume\Foundation\Core\Abstracts\ApiNode;
use Blume\Models\Plugins;
use Blume\Services\PluginService;
use Illuminate\Support\Collection;

class PluginsResolver extends ApiNode
{
    public function allPlugins(): Collection
    {
        return (new PluginService)->storedPlugins()
            ->map(function (Plugins $plugin) {
                return $plugin->setHidden([
                    'created_at',
                    'updated_at',
                ]);
            })
            ->values();
    }

    public function installedPlugins(): Collection
    {
        return Plugins::all()
            ->map(function (Plugins $plugin) {
                return $plugin->setHidden([
                    'created_at',
                    'updated_at',
                ]);
            })
            ->values();
    }

    public function notInstalledPlugins(): Collection
    {
        $installedPlugins = $this->installedPlugins();

        return $this->allPlugins()
            ->filter(function (Plugins $plugin) use ($installedPlugins) {
                $rawPlugin = $plugin;

                return !$installedPlugins->contains(function (Plugins $plugin) use ($rawPlugin) {
                    return $plugin->name === $rawPlugin->name;
                });
            })
            ->values();
    }

    public function isInstalledPlugin(string $name): bool
    {
        return $this->installedPlugins()
            ->contains(function (Plugins $plugin) use ($name) {
                return $plugin->name === $name;
            });
    }

    public function installPlugin(string $name): bool
    {
        if (!$this->isInstalledPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->save();
        }

        return $this->isInstalledPlugin($name);
    }

    public function uninstallPlugin(string $name): bool
    {
        if ($this->isInstalledPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->delete();
        }

        return !$this->isInstalledPlugin($name);
    }

    public function activedPlugins(): Collection
    {
        return $this->allPlugins()
            ->filter(function (Plugins $plugin) {
                return $plugin->active;
            })
            ->values();
    }

    public function notActivedPlugins(): Collection
    {
        return $this->allPlugins()
            ->filter(function (Plugins $plugin) {
                return !$plugin->active;
            })
            ->values();
    }

    public function isActivatedPlugin(string $name): bool
    {
        return $this->installedPlugins()
            ->contains(function (Plugins $plugin) use ($name) {
                return ($plugin->name === $name) ? $plugin->active : false;
            });
    }

    public function activatePlugin(string $name): bool
    {
        if (!$this->isActivatedPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->fill([
                    'active' => true,
                ])
                ->save();

            $this->registerPlugin($name);
        }

        return $this->isActivatedPlugin($name);
    }

    public function deactivatePlugin(string $name): bool
    {
        if ($this->isActivatedPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->fill([
                    'active' => false,
                ])
                ->save();

            $this->unregisterPlugin($name);
        }

        return !$this->isActivatedPlugin($name);
    }

    public function registerPlugin(string $name): void
    {
        if ($handler = (new PluginService)->handlePlugin($name)) {
            $handler->registerListeners();
        }
    }

    public function unregisterPlugin(string $name): void
    {
        if ($handler = (new PluginService)->handlePlugin($name)) {
            $handler->unregisterListeners();
        }
    }
}
