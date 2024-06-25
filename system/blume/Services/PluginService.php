<?php

namespace Blume\Services;

use Blume\Foundation\Plugins\Interfaces\PluginInterface;
use Blume\Foundation\Plugins\Plugin;
use Blume\Models\Plugins;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class PluginService
{
    protected $pluginsPath;

    public function __construct()
    {
        $this->pluginsPath = app('path.plugins');
    }

    public function storedPlugins(): Collection
    {
        return $this->storedPluginsNames()
            ->map(function ($name) {
                return $this->getPluginInstance($name);
            })
            ->filter()
            ->values();
    }

    public function storedPluginsNames(): Collection
    {
        return collect(File::directories($this->pluginsPath))
            ->map(function ($directory) {
                return $this->getPluginName($directory);
            })
            ->filter()
            ->values();
    }

    public function loadPlugins(): void
    {
        $plugins = Plugins::where('active', true)->get();

        foreach ($plugins as $plugin) {
            $this->loadPlugin($plugin);
        }
    }

    public function loadPlugin(Plugins $plugin): void
    {
        $pluginClass = $plugin->class;

        if (class_exists($pluginClass) and in_array(PluginInterface::class, class_implements($pluginClass))) {
            $pluginInstance = new $pluginClass();

            if (method_exists($pluginInstance, 'registerListeners')) {
                $pluginInstance->registerListeners();
            }
        }
    }

    public function getPluginInstance($name): Plugins|null
    {
        $plugin = Plugins::where('name', $name)
            ->first();

        if (!$plugin) {
            $stored = $this->storedPluginsNames()
                ->contains(function (string $value) use ($name) {
                    return $value === $name;
                });

            if (!$stored) {
                return null;
            }

            $plugin = (new Plugins)->fill([
                'id' => null,
                'name' => $name,
                'handler' => $this->getPluginHandler($name),
            ]);
        }

        return $plugin;
    }

    public function getPluginDirectory($name): string
    {
        return realpath("{$this->pluginsPath}/{$name}");
    }

    public function getPluginName($directory): string
    {
        return pathinfo($directory, PATHINFO_BASENAME);
    }

    public function getPluginHandler($name): string|null
    {
        $pluginDirectory = $this->getPluginDirectory($name);

        $pluginFile = realpath("{$pluginDirectory}/Plugin.php");

        if (File::exists($pluginFile)) {
            $name = $this->getPluginName($pluginDirectory);

            return $this->getPluginNamespace($name);
        }

        return null;
    }

    public function getPluginNamespace($name): string|null
    {
        $name = ucfirst($name);

        $namespace = "Plugins\\{$name}\\Plugin";

        if (class_exists($namespace)) {
            return $namespace;
        }

        return null;
    }

    public function handlePlugin($name): Plugin|null
    {
        if ($handler = $this->getPluginHandler($name)) {
            return new $handler;
        }

        return null;
    }
}
