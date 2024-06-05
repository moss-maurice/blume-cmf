<?php

namespace Blume\Services;

use Blume\Models\Plugins;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

class PluginService
{
    protected $pluginPath;

    public function __construct()
    {
        $this->pluginPath = app('path.plugins');
    }

    public function loadPlugins()
    {
        $plugins = Plugins::where('active', true)->get();

        foreach ($plugins as $plugin) {
            $this->loadPlugin($plugin);
        }
    }

    protected function loadPlugin(Plugins $plugin)
    {
        $pluginClass = $plugin->class;

        if (class_exists($pluginClass)) {
            $pluginInstance = new $pluginClass();

            if (method_exists($pluginInstance, 'registerListeners')) {
                $pluginInstance->registerListeners();
            }
        }
    }

    public function discoverPlugins()
    {
        $directories = File::directories($this->pluginPath);

        $discoveredPlugins = [];

        foreach ($directories as $directory) {
            $pluginClass = $this->getPluginClassFromDirectory($directory);

            if ($pluginClass) {
                $discoveredPlugins[] = $pluginClass;
            }
        }

        return $discoveredPlugins;
    }

    protected function getPluginClassFromDirectory($directory)
    {
        $pluginFile = "{$directory}/Plugin.php";

        if (File::exists($pluginFile)) {
            $namespace = $this->getNamespaceFromFile($pluginFile);

            $pluginClass = "{$namespace}\\Plugin";

            return $pluginClass;
        }

        return null;
    }

    protected function getNamespaceFromFile($file)
    {
        $src = file_get_contents($file);

        if (preg_match('/namespace\s+([^;]+);/', $src, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
