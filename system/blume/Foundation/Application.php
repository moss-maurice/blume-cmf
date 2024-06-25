<?php

namespace Blume\Foundation;

use Illuminate\Foundation\Application as IlluminateApplication;
use RuntimeException;

class Application extends IlluminateApplication
{
    protected $modulesPath;

    protected $pluginsPath;

    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        $this->instance('path.modules', $this->modulesPath());
        $this->instance('path.plugins', $this->pluginsPath());
    }

    public function modulesPath($path = '')
    {
        return $this->joinPaths(realpath($this->modulesPath ?: $this->publicPath('modules')), $path);
    }

    public function useModulesPath($path)
    {
        $this->modulesPath = $path;

        $this->instance('path.modules', $path);

        return $this;
    }

    public function pluginsPath($path = '')
    {
        return $this->joinPaths(realpath($this->pluginsPath ?: $this->publicPath('plugins')), $path);
    }

    public function usePluginsPath($path)
    {
        $this->pluginsPath = $path;

        $this->instance('path.plugins', $path);

        return $this;
    }

    public function publicPath($path = '')
    {
        return $this->joinPaths(realpath($this->publicPath ?: $this->basePath('../')), $path);
    }

    public function path($path = '')
    {
        return $this->joinPaths(realpath($this->appPath ?: $this->basePath('blume')), $path);
    }

    public function getNamespace()
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->publicPath('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->publicPath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }
}
