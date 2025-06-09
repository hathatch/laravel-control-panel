<?php

namespace HatHatch\LaravelControlPanel;

use HatHatch\LaravelControlPanel\Commands\ControlPanelOptimize;
use HatHatch\LaravelControlPanel\Listeners\CommandStartingListener;
use HatHatch\LaravelControlPanel\Listeners\GateEvaluatedListener;
use HatHatch\LaravelControlPanel\Listeners\JobFailedListener;
use HatHatch\LaravelControlPanel\Listeners\JobProcessedListener;
use HatHatch\LaravelControlPanel\Listeners\JobQueuedListener;
use HatHatch\LaravelControlPanel\Listeners\QueryExecutedListener;
use HatHatch\LaravelControlPanel\Listeners\ResponseReceivedListener;
use Illuminate\Auth\Access\Events\GateEvaluated;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ControlPanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        Http::macro('controlPanel', function () {
            return Http::baseUrl(config('control-panel.url'));
        });

        $this->commands([
            ControlPanelOptimize::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->optimizes(
                optimize: 'control-panel:optimize',
            );

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('control-panel.php'),
            ], ['config', 'control-panel', 'control-panel-config']);

            Event::listen(CommandStarting::class, CommandStartingListener::class);
        }

        if (config('control-panel.measurements.jobs.enabled')) {
            Event::listen(JobQueued::class, JobQueuedListener::class);
            Event::listen(JobProcessed::class, JobProcessedListener::class);
            Event::listen(JobFailed::class, JobFailedListener::class);
        }
        if (config('control-panel.measurements.gates.enabled')) {
            Event::listen(GateEvaluated::class, GateEvaluatedListener::class);
        }
        if (config('control-panel.measurements.requests.enabled')) {
            Event::listen(RequestHandled::class, ResponseReceivedListener::class);
        }
        if (config('control-panel.measurements.queries.enabled')) {
            Event::listen(QueryExecuted::class, QueryExecutedListener::class);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'control-panel');

        $this->app->singleton(EventService::class, function (Application $app) {
            return new EventService(
                $app->make(Schedule::class)
            );
        });

        $this->app->singleton('control-panel', function (Application $app) {
            return new ControlPanel(
                $app->make(EventService::class),
                $app->make(CommandService::class)
            );
        });
    }
}
