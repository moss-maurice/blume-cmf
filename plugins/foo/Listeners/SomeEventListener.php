<?php

namespace Plugins\Foo\Listeners;

use Blume\Events\ExampleEvent;

class SomeEventListener
{
    public function handle(ExampleEvent $event)
    {
        dump('plugin is foo');
    }
}
