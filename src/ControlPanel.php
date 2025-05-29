<?php

namespace HatHatch\LaravelControlPanel;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Http;

class ControlPanel
{
    public function __construct(
        protected EventService $eventService,
    ) {}

    public function shouldRunEvent(string|Event $event): bool
    {
        return $this->eventService->shouldRunEvent($event);
    }

    public function configureApplication(): void
    {
        Http::controlPanel()->post('settings', [
            'environment' => config('app.env'),
            'url' => config('control-panel.app-url'),
            'name' => config('app.name'),
            'version' => app()->version(),
            'schedules' => $this->eventService->schedules(),
        ]);
    }
}
