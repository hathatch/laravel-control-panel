<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\EventService;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Scheduling\Schedule;

class CommandStartingListener
{
    public function __construct(private EventService $eventService) {}

    public function handle(CommandStarting $event): void
    {
        if ($event->command !== 'schedule:run' &&
            $event->command !== 'schedule:finish') {
            return;
        }

        collect(app(Schedule::class)->events())->each(function ($event) {
            $event->when(fn () => $this->eventService->shouldRunEvent($event))
                ->thenWithOutput(fn () => $this->eventService->logRun($event));
        });
    }
}
