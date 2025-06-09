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
        protected CommandService $commandService,
    ) {}

    public function configureApplication(): void
    {
        Http::controlPanel()->post('settings', [
            'environment' => config('app.env'),
            'url' => config('control-panel.app-url'),
            'name' => config('app.name'),
            'version' => app()->version(),
            'jobs_dashboard_url' => $this->getJobsDashboardUrl(),
            'exceptions_dashboard_url' => $this->getExceptionsDashboardUrl(),
            'telescope_dashboard_url' => $this->getTelescopeDashboardUrl(),
            'schedules' => $this->eventService->schedules(),
            'commands' => $this->commandService->commands(),
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

    private function getJobsDashboardUrl()
    {
        if (config('control-panel.dashboard.jobs')) {
            return config('control-panel.dashboard.jobs');
        }

        if (! empty(config('horizon'))) {
            return config('horizon.url', trim(config('app.url'), '/').'/'.trim(config('horizon.path'), '/'));
        }

        return null;
    }

    private function getTelescopeDashboardUrl()
    {
        if (config('control-panel.dashboard.telescope')) {
            return config('control-panel.dashboard.telescope');
        }

        if (config('telescope.enabled')) {
            return config('telescope.url', trim(config('app.url'), '/').'/'.trim(config('telescope.path'), '/'));
        }

        return null;
    }

    private function getExceptionsDashboardUrl()
    {
        return config('control-panel.dashboard.exceptions');
    }
}
