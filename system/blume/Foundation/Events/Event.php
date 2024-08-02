<?php

namespace Blume\Foundation\Events;

use Blume\Foundation\Events\Interfaces\EventInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class Event implements EventInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn(): array
    {
        return [
            new Channel('broadcast'),
        ];
    }
}
