<?php

namespace Blume\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class ModulesService
{
    protected $modulesPath;

    public function __construct()
    {
        $this->modulesPath = app('path.modules');
    }

    public function storedModules(): Collection
    {
        return $this->storedModulesNames()
            ->map(function ($name) {
                return $name;
            })
            ->filter()
            ->values();
    }

    public function storedModulesNames(): Collection
    {
        return collect(File::directories($this->modulesPath))
            ->map(function ($directory) {
                return $this->getModuleName($directory);
            })
            ->filter()
            ->values();
    }

    public function loadModules(): Collection
    {
        $modules = collect();

        $modulesNames = array_map('basename', File::directories($this->modulesPath));

        foreach ($modulesNames as $module) {
            if ($moduleClass = $this->getModuleNamespace($module)) {
                $modules->push($moduleClass);
            }
        }

        return $modules->filter()
            ->values();
    }

    public function getModuleDirectory($name): string
    {
        return realpath("{$this->modulesPath}/{$name}");
    }

    public function getModuleName($directory): string
    {
        return pathinfo($directory, PATHINFO_BASENAME);
    }

    public function getModuleNamespace($name): string|null
    {
        $name = ucfirst($name);

        $namespace = "Modules\\{$name}\\{$name}ServiceProvider";

        if (class_exists($namespace)) {
            return $namespace;
        }

        return null;
    }
}
