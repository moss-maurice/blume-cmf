<?php

namespace Blume\Plugins\Foo\Listeners;

use Blume\Foundation\Events\Event;
use Blume\Foundation\Events\EventListener;

class SomeEventListener extends EventListener
{
    public function handle(Event $event): void
    {
        dump('plugin is foo');
    }
}
