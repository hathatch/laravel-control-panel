<?php

namespace HatHatch\LaravelControlPanel;

use Illuminate\Support\Facades\Facade;

class ControlPanelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'control-panel';
    }
}
