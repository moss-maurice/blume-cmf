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
        blume()->events()->callEvent('plugin.onInstall.before');
        blume()->events()->callEvent('plugin.onInstall');

        if (!$this->isInstalledPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->save();

            blume()->events()->callEvent('plugin.onInstall.success');
        } else {
            blume()->events()->callEvent('plugin.onInstall.error');
        }

        blume()->events()->callEvent('plugin.onInstall.after');

        return $this->isInstalledPlugin($name);
    }

    public function uninstallPlugin(string $name): bool
    {
        blume()->events()->callEvent('plugin.onUninstall.before');
        blume()->events()->callEvent('plugin.onUninstall');

        if ($this->isInstalledPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->delete();

            blume()->events()->callEvent('plugin.onUninstall.success');
        } else {
            blume()->events()->callEvent('plugin.onUninstall.error');
        }

        blume()->events()->callEvent('plugin.onUninstall.after');

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
        blume()->events()->callEvent('plugin.onActivate.before');
        blume()->events()->callEvent('plugin.onActivate');

        if (!$this->isActivatedPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->fill([
                    'active' => true,
                ])
                ->save();

            $this->registerPlugin($name);

            blume()->events()->callEvent('plugin.onActivate.success');
        } else {
            blume()->events()->callEvent('plugin.onActivate.error');
        }

        blume()->events()->callEvent('plugin.onActivate.after');

        return $this->isActivatedPlugin($name);
    }

    public function deactivatePlugin(string $name): bool
    {
        blume()->events()->callEvent('plugin.onDeactivate.before');
        blume()->events()->callEvent('plugin.onDeactivate');

        if ($this->isActivatedPlugin($name)) {
            (new PluginService)->getPluginInstance($name)
                ->fill([
                    'active' => false,
                ])
                ->save();

            $this->unregisterPlugin($name);

            blume()->events()->callEvent('plugin.onDeactivate.success');
        } else {
            blume()->events()->callEvent('plugin.onDeactivate.error');
        }

        blume()->events()->callEvent('plugin.onDeactivate.after');

        return !$this->isActivatedPlugin($name);
    }

    public function registerPlugin(string $name): void
    {
        blume()->events()->callEvent('plugin.onRegister.before');
        blume()->events()->callEvent('plugin.onRegister');

        if ($handler = (new PluginService)->handlePlugin($name)) {
            $handler->registerListeners();

            blume()->events()->callEvent('plugin.onRegister.success');
        } else {
            blume()->events()->callEvent('plugin.onRegister.error');
        }

        blume()->events()->callEvent('plugin.onDeactivate.after');
    }

    public function unregisterPlugin(string $name): void
    {
        blume()->events()->callEvent('plugin.onUnregister.before');
        blume()->events()->callEvent('plugin.onUnregister');

        if ($handler = (new PluginService)->handlePlugin($name)) {
            $handler->unregisterListeners();

            blume()->events()->callEvent('plugin.onUnregister.success');
        } else {
            blume()->events()->callEvent('plugin.onUnregister.error');
        }
    }
}
