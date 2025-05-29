<?php

namespace HatHatch\LaravelControlPanel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use DB;

class StatusController
{
    const string OK = 'ok';
    const string NOK = 'nok';

    public function index(): JsonResponse
    {
        try {
            $pdo = DB::connection()->getPdo();
        } catch (\Exception $e) {
            $pdo = null;
        }

        return new JsonResponse([
            'database' => $pdo !== null ? self::OK : self::NOK,
        ]);
    }
}
