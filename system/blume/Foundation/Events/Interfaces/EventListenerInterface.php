<?php

namespace Blume\Foundation\Events\Interfaces;

use Blume\Foundation\Events\Event;

interface EventListenerInterface
{
    public function handle(Event $event): void;
}
