<?php

namespace HatHatch\LaravelControlPanel\Commands;

use HatHatch\LaravelControlPanel\ControlPanel;
use HatHatch\LaravelControlPanel\Traits\EventPrintable;
use Illuminate\Console\Command;

class ControlPanelOptimize extends Command
{
    use EventPrintable;

    protected $signature = 'control-panel:optimize';

    protected $description = 'Syncing all data to Control Panel';

    public function handle(ControlPanel $controlPanel): int
    {
        $controlPanel->configureApplication();

        return self::SUCCESS;
    }
}
