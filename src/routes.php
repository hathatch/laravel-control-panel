<?php

use HatHatch\LaravelControlPanel\Http\Controllers\StatusController;
use HatHatch\LaravelControlPanel\Http\Middleware\VerifySecretMiddleware;

Route::get('/cp-status', [StatusController::class, 'index'])
    ->name('cp.status')
    ->middleware([VerifySecretMiddleware::class])
    ->withoutMiddleware(['throttle:60,1']);
