<?php

namespace Plugins\Foo;

use Blume\Events\ExampleEvent;
use Illuminate\Support\Facades\Event;
use Plugins\Foo\Listeners\SomeEventListener;

class Plugin
{
    public function registerListeners()
    {
        Event::listen(ExampleEvent::class, SomeEventListener::class);
    }
}
