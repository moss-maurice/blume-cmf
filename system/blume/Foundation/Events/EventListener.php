<?php

namespace Blume\Foundation\Events;

use Blume\Foundation\Events\Event;
use Blume\Foundation\Events\Interfaces\EventListenerInterface;

abstract class EventListener implements EventListenerInterface
{
    public function handle(Event $event): void
    {
        return;
    }
}
