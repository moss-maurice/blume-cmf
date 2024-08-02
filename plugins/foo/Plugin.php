<?php

namespace Blume\Plugins\Foo;

use Blume\Foundation\Plugins\Plugin as BasePlugin;
use Blume\Plugins\Foo\Listeners\SomeEventListener;

class Plugin extends BasePlugin
{
    protected $listeners = [
        'onTest' => [
            SomeEventListener::class,
        ],
    ];
}
