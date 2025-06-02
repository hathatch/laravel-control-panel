<?php

namespace HatHatch\LaravelControlPanel;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Http;
use Throwable;

class ControlPanel
{
    private static MeasurementService $measurementService;

    public function __construct(
        protected EventService $eventService,
    ) {}

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

    public function shouldRunEvent(string|Event $event): bool
    {
        return $this->eventService->shouldRunEvent($event);
    }

    public static function measure(string $name, int $amount = 1): void
    {
        $measurementService = self::$measurementService ??= new MeasurementService;
        $measurementService->addDataPoint($name, $amount);
    }

    public static function handles(Exceptions $exceptions): void
    {
        $exceptions->reportable(static function (Throwable $exception) {
            self::measure('exceptions');
        });
    }
}
