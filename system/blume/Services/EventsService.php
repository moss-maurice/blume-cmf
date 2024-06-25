<?php

namespace Blume\Services;

use Blume\Foundation\Events\Interfaces\EventInterface;
use Blume\Models\Events;
use Blume\Models\EventsListeners;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

class EventsService
{
    public function createEvent(string $name, string $handler): Events|null
    {
        $event = $this->getEvent($name);

        if (!$event) {
            return Events::create([
                'name' => $name,
                'handler' => $handler,
            ]);
        }

        return null;
    }
    public function deleteEvent(string $name): bool
    {
        if ($this->getEvent($name)) {
            return Events::where([
                'name' => $name,
            ])
                ->delete();
        }

        return !$this->getEvent($name);
    }

    public function getEvent(string $name): Events|null
    {
        return Events::with('listeners')
            ->where('name', $name)
            ->first();
    }

    public function getEventListeners(string $name): Collection
    {
        $event = Events::with('listeners')
            ->where('name', $name)
            ->first();

        if ($event) {
            return $event->listeners;
        }

        return collect();
    }

    public function createEventListener($name, $listenerHandle): EventsListeners|null
    {
        if ($event = $this->getEvent($name)) {
            return EventsListeners::create([
                'event_id' => $event->id,
                'handler' => $listenerHandle,
            ]);
        }

        return null;
    }

    public function deleteEventListener($name, $listenerHandle): bool
    {
        if ($event = $this->getEvent($name)) {
            EventsListeners::where('event_id', $event->id)
                ->where('handler', $listenerHandle)
                ->delete();

            $listener = EventsListeners::where('event_id', $event->id)
                ->where('handler', $listenerHandle)
                ->first();

            return !$listener ? true : false;
        }

        return false;
    }

    public function getEventHandler($name): string|null
    {
        $event = $this->getEvent($name);

        if ($event = $this->getEvent($name)) {
            return $event->handler;
        }

        return null;
    }

    public function handleEvent($name): EventInterface|null
    {
        if ($handler = $this->getEventHandler($name)) {
            return new $handler;
        }

        return null;
    }

    public function registerEventsListeners(): void
    {
        Events::with('listeners')
            ->get()
            ->each(function (Events $event) {
                $event->listeners
                    ->each(function (EventsListeners $listener) use ($event) {
                        Event::listen($event->handler, $listener->listener);
                    });
            });
    }
}
