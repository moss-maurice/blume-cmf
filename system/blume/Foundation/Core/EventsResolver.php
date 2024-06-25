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
        if (!$this->isRegisteredEvent($name)) {
            (new EventsService)->createEvent($name, $handler);
        }

        return $this->isRegisteredEvent($name);
    }

    public function unregisterEvent(string $name): bool
    {
        if ($this->isRegisteredEvent($name)) {
            $this->unregisterAllListener($name);

            (new EventsService)->getEvent($name)
                ->delete();
        }

        return !$this->isRegisteredEvent($name);
    }

    public function callEvent(string $name): bool
    {
        if ($this->isRegisteredEvent($name)) {
            event((new EventsService)->handleEvent($name));

            return true;
        }

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
        if ($this->isRegisteredEvent($name) and !$this->isRegisteredListener($name, $listenerHandle)) {
            if ((new EventsService)->createEventListener($name, $listenerHandle)) {
                Event::listen((new EventsService)->getEventHandler($name), $listenerHandle);
            }
        }

        return $this->isRegisteredListener($name, $listenerHandle);
    }

    public function unregisterListener(string $name, string $listenerHandle): bool
    {
        if ($this->isRegisteredEvent($name) and $this->isRegisteredListener($name, $listenerHandle)) {
            if ((new EventsService)->deleteEventListener($name, $listenerHandle)) {
                Event::forget((new EventsService)->getEventHandler($name), $listenerHandle);
            }
        }

        return !$this->isRegisteredListener($name, $listenerHandle);
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
