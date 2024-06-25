<?php

namespace Blume\Foundation\Events;

use Blume\Foundation\Events\Interfaces\EventInterface;

abstract class Event implements EventInterface
{
    public function broadcastOn(): array
    {
        return [];
    }
}
