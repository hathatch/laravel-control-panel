<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Queue\Events\JobProcessed;

class JobProcessedListener
{
    public function __construct() {}

    public function handle(JobProcessed $event): void
    {
        ControlPanel::measure('pending-jobs', -1);
    }
}
