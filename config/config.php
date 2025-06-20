<?php

return [
    'url' => env('CONTROL_PANEL_URL'),
    'app-url' => env('CONTROL_PANEL_APP_URL', config('app.url')),

    'cache-store' => env('CONTROL_PANEL_CACHE_STORE', config('cache.default')),

    'measurements' => [
        'jobs' => [
            'enabled' => env('CONTROL_PANEL_MEASUREMENTS_JOBS_ENABLED', true),
        ],
        'gates' => [
            'enabled' => env('CONTROL_PANEL_MEASUREMENTS_GATES_ENABLED', true),
        ],
        'requests' => [
            'enabled' => env('CONTROL_PANEL_MEASUREMENTS_REQUESTS_ENABLED', true),
            'slow' => env('CONTROL_PANEL_MEASUREMENTS_REQUESTS_SLOW', 500), // in milliseconds
        ],
        'queries' => [
            'enabled' => env('CONTROL_PANEL_MEASUREMENTS_QUERIES_ENABLED', true),
            'slow' => env('CONTROL_PANEL_MEASUREMENTS_QUERIES_SLOW', 500), // in milliseconds
        ],
    ],

    'dashboard' => [
        'jobs' => env('CONTROL_PANEL_JOBS_DASHBOARD_URL'),
        'exceptions' => env('CONTROL_PANEL_EXCEPTIONS_DASHBOARD_URL'),
        'telescope' => env('CONTROL_PANEL_TELESCOPE_DASHBOARD_URL'),
    ],

    'events' => [
        'paused' => [
            'cache_key' => 'control-panel-paused-events',
            'cache_ttl' => 5, // in minutes
        ],
    ],

    'commands' => [
        'blacklist' => [
            '_complete',
            'breeze:install',
            'completion',
            'config:publish',
            'db',
            'db:monitor',
            'db:seed',
            'db:show',
            'db:table',
            'db:wipe',
            'docs',
            'env:decrypt',
            'env:encrypt',
            'event:generate',
            'help',
            'inertia:middleware',
            'inertia:start-ssr',
            'inertia:stop-ssr',
            'install:api',
            'install:broadcasting',
            'inspire',
            'invoke-serialized-closure',
            'key:generate',
            'lang:publish',
            'list',
            'make:cache-table',
            'make:cast',
            'make:channel',
            'make:class',
            'make:command',
            'make:component',
            'make:controller',
            'make:enum',
            'make:event',
            'make:exception',
            'make:factory',
            'make:interface',
            'make:job',
            'make:job-middleware',
            'make:listener',
            'make:mail',
            'make:middleware',
            'make:migration',
            'make:model',
            'make:notification',
            'make:notifications-table',
            'make:observer',
            'make:policy',
            'make:provider',
            'make:queue-batches-table',
            'make:queue-failed-table',
            'make:queue-table',
            'make:request',
            'make:resource',
            'make:rule',
            'make:scope',
            'make:seeder',
            'make:session-table',
            'make:test',
            'make:trait',
            'make:view',
            'migrate',
            'migrate:fresh',
            'migrate:install',
            'migrate:refresh',
            'migrate:reset',
            'migrate:rollback',
            'model:prune',
            'pail',
            'package:discover',
            'pest:dataset',
            'pest:test',
            'queue:listen',
            'queue:monitor',
            'queue:work',
            'sail:add',
            'sail:install',
            'sail:publish',
            'sanctum:prune-expired',
            'schedule:finish',
            'schedule:run',
            'schedule:test',
            'schedule:work',
            'serve',
            'stub:publish',
            'telescope:install',
            'telescope:publish',
            'test',
            'tinker',
            'vendor:publish',
            'ziggy:generate',
        ],
    ],
];
