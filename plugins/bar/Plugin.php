<?php

namespace Plugins\Bar;

use Blume\Events\ExampleEvent;
use Illuminate\Support\Facades\Event;
use Plugins\Bar\Listeners\SomeEventListener;

class Plugin
{
    public function registerListeners()
    {
        Event::listen(ExampleEvent::class, SomeEventListener::class);
    }
}
