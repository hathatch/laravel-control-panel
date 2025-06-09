<?php

namespace HatHatch\LaravelControlPanel\Listeners;

use HatHatch\LaravelControlPanel\ControlPanel;
use Illuminate\Queue\Events\JobFailed;

class JobFailedListener
{
    public function __construct() {}

    public function handle(JobFailed $event): void
    {
        ControlPanel::measure('pending-jobs', -1);
        ControlPanel::measure('failed-jobs');
    }
}
