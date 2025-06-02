<?php

return [
    'url' => env('CONTROL_PANEL_URL'),
    'app-url' => env('CONTROL_PANEL_APP_URL', config('app.url')),

    'cache-store' => env('CONTROL_PANEL_CACHE_STORE', config('cache.default')),

    'events' => [
        'paused' => [
            'cache_key' => 'control-panel-paused-events',
            'cache_ttl' => 5, // in minutes
        ],
    ],

    'jobs' => [
        'dashboard_url' => env('CONTROL_PANEL_JOBS_DASHBOARD_URL'),
    ],

    'exceptions' => [
        'dashboard_url' => env('CONTROL_PANEL_EXCEPTIONS_DASHBOARD_URL'),
    ],
];
