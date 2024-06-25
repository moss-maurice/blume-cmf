<?php

namespace Plugins\Foo;

use Blume\Foundation\Plugins\Plugin as BasePlugin;
use Plugins\Foo\Listeners\SomeEventListener;

class Plugin extends BasePlugin
{
    protected $listeners = [
        'onTest' => [
            SomeEventListener::class,
        ],
    ];
}
