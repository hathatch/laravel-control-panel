<?php

namespace HatHatch\LaravelControlPanel;

use HatHatch\LaravelControlPanel\Commands\ControlPanelOptimize;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class ControlPanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Schedule $schedule, ControlPanel $scheduleManager): void
    {
        //        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'control-panel');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //        if (config('control-panel.ui.enabled')) {
        //            $this->loadViewsFrom(__DIR__.'/../resources/views', 'control-panel');
        //
        //            Livewire::component('control-panel-component', ScheduleManagerComponent::class);
        //        }

        //        if (config('control-panel.driver') === 'database') {
        //            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //        }

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

            //            $this->publishes([
            //                __DIR__.'/../public/vendor/control-panel/assets' => public_path('vendor/control-panel/assets'),
            //                __DIR__.'/../public/vendor/control-panel/manifest.json' => public_path('vendor/control-panel/manifest.json'),
            //            ], ['assets', 'control-panel', 'control-panel-assets']);

            //            $this->publishes([
            //                __DIR__.'/../resources/lang' => resource_path('lang/vendor/control-panel'),
            //            ], ['lang', 'control-panel', 'control-panel-lang']);

            foreach ($schedule->events() as $event) {
                $event->when(function () use ($event, $scheduleManager) {
                    return $scheduleManager->shouldRunEvent($event);
                });
            }
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
                $app->make(EventService::class)
            );
        });
    }
}
