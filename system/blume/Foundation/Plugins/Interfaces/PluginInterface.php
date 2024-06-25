<?php

namespace Blume\Foundation\Plugins\Interfaces;

interface PluginInterface
{
    public function registerListeners(): void;

    public function unregisterListeners(): void;
}
