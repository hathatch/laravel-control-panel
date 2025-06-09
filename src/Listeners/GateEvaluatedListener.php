<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Auth\Access\Events\GateEvaluated;

class GateEvaluatedListener
{
    public function __construct() {}

    public function handle(GateEvaluated $event): void
    {
        if ($event->result === false) {
            ControlPanel::measure('gate-denied');
        }
    }
}
