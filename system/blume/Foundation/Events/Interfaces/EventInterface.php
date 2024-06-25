<?php

namespace Blume\Foundation\Events\Interfaces;

interface EventInterface
{
    public function broadcastOn(): array;
}
