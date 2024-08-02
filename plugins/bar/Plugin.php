<?php

namespace Blume\Plugins\Bar;

use Blume\Foundation\Plugins\Plugin as BasePlugin;
use Blume\Plugins\Bar\Listeners\SomeEventListener;

class Plugin extends BasePlugin
{
    protected $listeners = [
        'onTest' => [
            SomeEventListener::class,
        ],
    ];
}
