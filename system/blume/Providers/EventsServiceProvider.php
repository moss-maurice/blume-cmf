<?php

namespace Blume\Providers;

use Blume\Models\Events;
use Blume\Services\EventsService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class EventsServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        $this->registerEventsListeners();
    }

    protected function registerEventsListeners()
    {
        if (Schema::hasTable((new Events)->getTable())) {
            (new EventsService)->registerEventsListeners();
        }
    }
}
