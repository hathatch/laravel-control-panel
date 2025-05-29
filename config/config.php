<?php

return [
    'url' => env('CONTROL_PANEL_URL'),
    'app-url' => env('CONTROL_PANEL_APP_URL', config('app.url')),

    'events' => [
        'paused' => [
            'cache_key' => 'control-panel-paused-events',
            'cache_ttl' => 5, // in minutes
        ],
    ],
];
