<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Database\Events\QueryExecuted;

class QueryExecutedListener
{
    public function __construct() {}

    public function handle(QueryExecuted $event): void
    {
        if ($event->time >= config('control-panel.measurements.queries.slow')) {
            ControlPanel::measure('slow-queries');
        }
    }
}
