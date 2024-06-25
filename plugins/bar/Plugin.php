<?php

namespace Plugins\Bar;

use Blume\Foundation\Plugins\Plugin as BasePlugin;
use Plugins\Bar\Listeners\SomeEventListener;

class Plugin extends BasePlugin
{
    protected $listeners = [
        'onTest' => [
            SomeEventListener::class,
        ],
    ];
}
