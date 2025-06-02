<?php

namespace HatHatch\LaravelControlPanel\Http\Controllers;

use DB;
use HatHatch\LaravelControlPanel\MeasurementService;
use Illuminate\Http\JsonResponse;

class StatusController
{
    const string OK = 'ok';

    const string NOK = 'nok';

    public function index(MeasurementService $measurementService): JsonResponse
    {
        try {
            $pdo = DB::connection()->getPdo();
        } catch (\Exception $e) {
            $pdo = null;
        }

        $dataPoints = $measurementService->getDataPoints();
        $measurementService->clearDataPoints();

        return new JsonResponse([
            'database' => $pdo !== null ? self::OK : self::NOK,
            'measurements' => $dataPoints,
        ]);
    }
}
