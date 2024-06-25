<?php

namespace Blume\Listeners;

use Blume\Foundation\Events\EventListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExampleListener extends EventListener
{
    public function handle(object $event): void
    {
        dump('Example event handle');
    }
}
