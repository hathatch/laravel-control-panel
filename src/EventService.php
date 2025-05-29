<?php

namespace HatHatch\LaravelControlPanel;

use HatHatch\LaravelControlPanel\Traits\EventPrintable;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class EventService
{
    use EventPrintable;

    public function __construct(
        protected Schedule $schedule,
    ) {}

    public function shouldRunEvent(string|Event $event): bool
    {
        $pausedEvents = \Cache::remember(
            config('control-panel.events.paused.cache_key'),
            now()->addMinutes(config('control-panel.events.paused.cache_ttl')),
            fn () => Http::controlPanel()->get('paused-events')->json()
        );

        return in_array(
            is_string($event) ? $event : $event->mutexName(),
            $pausedEvents
        );
    }

    public function schedules(): Collection
    {
        return collect($this->schedule->events())
            ->map(fn (Event $event) => [
                'command' => $this->normalizeEvent($event),
                'mutex_name' => $event->mutexName(),
            ])
            ->values();
    }
}
