<?php

namespace Blume\Foundation\Core;

use Blume\Foundation\Core\Abstracts\ApiNode;
use Blume\Models\Events;
use Blume\Models\EventsListeners;
use Blume\Services\EventsService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

class EventsResolver extends ApiNode
{
    public function allEvents(): Collection
    {
        return Events::all()
            ->map(function (Events $plugin) {
                return $plugin->setHidden([
                    'created_at',
                    'updated_at',
                ]);
            })
            ->values();
    }

    public function isRegisteredEvent(string $name): bool
    {
        return (new EventsService)->getEvent($name) ? true : false;
    }

    public function registerEvent(string $name, string $handler): bool
    {
        blume()->events()->callEvent('event.onRegisterEvent.before');

        if (!$this->isRegisteredEvent($name)) {
            (new EventsService)->createEvent($name, $handler);

            blume()->events()->callEvent('event.onRegisterEvent');
        }

        if ($this->isRegisteredEvent($name)) {
            blume()->events()->callEvent('event.onRegisterEvent.success');
            blume()->events()->callEvent('event.onRegisterEvent.after');

            return true;
        }

        blume()->events()->callEvent('event.onRegisterEvent.error');
        blume()->events()->callEvent('event.onRegisterEvent.after');

        return false;
    }

    public function unregisterEvent(string $name): bool
    {
        blume()->events()->callEvent('event.onUnregisterEvent.before');

        if ($this->isRegisteredEvent($name)) {
            $this->unregisterAllListener($name);

            (new EventsService)->getEvent($name)
                ->delete();

            blume()->events()->callEvent('event.onUnregisterEvent');
        }

        if (!$this->isRegisteredEvent($name)) {
            blume()->events()->callEvent('event.onUnregisterEvent.success');
            blume()->events()->callEvent('event.onUnregisterEvent.after');

            return true;
        }

        blume()->events()->callEvent('event.onUnregisterEvent.error');
        blume()->events()->callEvent('event.onUnregisterEvent.after');

        return false;
    }

    public function callEvent(string $name): bool
    {
        (new EventsService)->callEvent('event.onCallEvent.before');

        if ((new EventsService)->callEvent($name)) {
            (new EventsService)->callEvent('event.onCallEvent');
            (new EventsService)->callEvent('event.onCallEvent.success');
            (new EventsService)->callEvent('event.onCallEvent.after');

            return true;
        }

        (new EventsService)->callEvent('event.onCallEvent.error');
        (new EventsService)->callEvent('event.onCallEvent.after');

        return false;
    }

    public function listeners(string $name): Collection
    {
        if ($this->isRegisteredEvent($name)) {
            if ($event = (new EventsService)->getEvent($name)) {
                return $event->listeners
                    ->map(function (EventsListeners $listener) {
                        return $listener->setHidden([
                            'created_at',
                            'updated_at',
                        ]);
                    })
                    ->values();
            }
        }

        return collect();
    }

    public function isRegisteredListener(string $name, string $listenerHandle): bool
    {
        if ($this->isRegisteredEvent($name)) {
            return $this->listeners($name)
                ->contains(function (EventsListeners $listener) use ($listenerHandle) {
                    return $listener->handler === $listenerHandle;
                });
        }

        return false;
    }

    public function registerListener(string $name, string $listenerHandle): bool
    {
        blume()->events()->callEvent('event.onRegisterListener.before');

        if ($this->isRegisteredEvent($name) and !$this->isRegisteredListener($name, $listenerHandle)) {
            if ((new EventsService)->createEventListener($name, $listenerHandle)) {
                Event::listen((new EventsService)->getEventHandler($name), $listenerHandle);

                blume()->events()->callEvent('event.onRegisterListener');
            }
        }

        if ($this->isRegisteredListener($name, $listenerHandle)) {
            blume()->events()->callEvent('event.onRegisterListener.success');
            blume()->events()->callEvent('event.onRegisterListener.after');

            return true;
        }

        blume()->events()->callEvent('event.onRegisterListener.error');
        blume()->events()->callEvent('event.onRegisterListener.after');

        return false;
    }

    public function unregisterListener(string $name, string $listenerHandle): bool
    {
        blume()->events()->callEvent('event.onUnregisterListener.before');

        if ($this->isRegisteredEvent($name) and $this->isRegisteredListener($name, $listenerHandle)) {
            if ((new EventsService)->deleteEventListener($name, $listenerHandle)) {
                Event::forget((new EventsService)->getEventHandler($name), $listenerHandle);

                blume()->events()->callEvent('event.onUnregisterListener');
            }
        }

        if (!$this->isRegisteredListener($name, $listenerHandle)) {
            blume()->events()->callEvent('event.onUnregisterListener.success');
            blume()->events()->callEvent('event.onUnregisterListener.after');

            return true;
        }

        blume()->events()->callEvent('event.onUnregisterListener.error');
        blume()->events()->callEvent('event.onUnregisterListener.after');

        return false;
    }

    public function unregisterAllListener(string $name): bool
    {
        if ($this->isRegisteredEvent($name)) {
            $this->listeners($name)
                ->each(function (EventsListeners $listener) use ($name) {
                    $this->unregisterListener($name, $listener->handler);
                });
        }

        return $this->listeners($name)->count() ? true : false;
    }
}
