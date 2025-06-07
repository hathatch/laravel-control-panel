<?php

use HatHatch\LaravelControlPanel\Http\Controllers\CommandRunsController;
use HatHatch\LaravelControlPanel\Http\Controllers\StatusController;
use HatHatch\LaravelControlPanel\Http\Middleware\VerifySecretMiddleware;

Route::group([], function () {
    Route::get('/cp-status', [StatusController::class, 'index'])
        ->name('cp.status');

    Route::post('/command-runs/{id}/run', [CommandRunsController::class, 'run'])
        ->name('command-runs.run');
})->middleware([VerifySecretMiddleware::class]);
