<?php

namespace Blume\Providers;

use Blume\Events\ExampleEvent;
use Blume\Listeners\ExampleListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventsServiceProvider extends ServiceProvider
{
    protected $listen = [
        ExampleEvent::class => [
            ExampleListener::class,
        ],
    ];
}
