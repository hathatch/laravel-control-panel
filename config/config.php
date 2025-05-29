<?php

return [
    'url' => env('CONTROL_PANEL_URL'),

    'events' => [
        'paused' => [
            'cache_key' => 'control-panel-paused-events',
            'cache_ttl' => 5, // in minutes
        ],
    ],
];
