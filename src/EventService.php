<?php

namespace HatHatch\LaravelControlPanel;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class EventService
{
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
                'expression' => $event->expression,
                'command' => $event->normalizeCommand($event->command ?? ''),
            ])
            ->values();
    }
}
