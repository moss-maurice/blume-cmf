<?php

namespace Plugins\Bar\Listeners;

use Blume\Events\ExampleEvent;

class SomeEventListener
{
    public function handle(ExampleEvent $event)
    {
        dump('plugin is bar');
    }
}
