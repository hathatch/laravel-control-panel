<?php

namespace HatHatch\LaravelControlPanel;

use Cache;
use Carbon\Carbon;

class MeasurementService
{
    private const string CACHE_KEY = 'control-panel.measurements';

    public function __construct() {}

    public function addDataPoint(string $name, int $amount = 1): void
    {
        defer(function () use ($name, $amount) {
            $measurements = Cache::store(config('control-panel.cache-store'))->get(self::CACHE_KEY, []);
            $measurements[$name] = ($measurements[$name] ?? 0) + $amount;

            Cache::store(config('control-panel.cache-store'))->put(
                self::CACHE_KEY,
                $measurements,
                Carbon::now()->addHours(2)
            );
        });
    }

    public function getDataPoints(): array
    {
        return Cache::store(config('control-panel.cache-store'))->get(self::CACHE_KEY, []);
    }

    public function clearDataPoints(): void
    {
        Cache::store(config('control-panel.cache-store'))->forget(self::CACHE_KEY);
    }
}
