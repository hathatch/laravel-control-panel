<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Foundation\Http\Events\RequestHandled;

class ResponseReceivedListener
{
    public function __construct() {}

    public function handle(RequestHandled $event): void
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : $event->request->server('REQUEST_TIME_FLOAT');
        $duration = $startTime ? floor((microtime(true) - $startTime) * 1000) : null;

        if ($duration && $duration >= config('control-panel.measurements.requests.slow')) {
            ControlPanel::measure('slow-requests');
        }
    }
}
