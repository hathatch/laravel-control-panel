<?php

namespace HatHatch\LaravelControlPanel\Http\Controllers;

use HatHatch\LaravelControlPanel\CommandService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandRunsController
{
    public function run(Request $request, $id, CommandService $commandService): JsonResponse
    {
        $commandService->run($id, $request->input('command'));

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
