<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Queue\Events\JobQueued;

class JobQueuedListener
{
    public function __construct() {}

    public function handle(JobQueued $event): void
    {
        ControlPanel::measure('pending-jobs');
    }
}
