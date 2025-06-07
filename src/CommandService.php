<?php

namespace HatHatch\LaravelControlPanel;

use Artisan;
use Concurrency;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandService
{
    public function __construct(
    ) {}

    public function commands(): Collection
    {
        $blacklist = config('control-panel.commands.blacklist', []);

        return collect(Artisan::all())
            ->filter(fn (Command $command) => ! in_array($command->getName(), $blacklist))
            ->map(fn (Command $command) => [
                'name' => $command->getName(),
                'description' => $command->getDescription(),
                'options' => collect($command->getDefinition()->getOptions())
                    ->map(fn (InputOption $option) => [
                        'name' => $option->getName(),
                        'description' => $option->getDescription(),
                        'required' => $option->isValueRequired(),
                    ])->values(),
                'arguments' => collect($command->getDefinition()->getArguments())
                    ->map(fn (InputArgument $argument) => [
                        'name' => $argument->getName(),
                        'description' => $argument->getDescription(),
                        'required' => $argument->isRequired(),
                    ])->values(),
            ])
            ->values();
    }

    public function run(int $id, string $command)
    {
        Concurrency::defer([
            function () use ($id, $command) {
                try {
                    $output = new BufferedOutput;
                    Artisan::call(
                        $command,
                        outputBuffer: $output
                    );

                    Http::controlPanel()->post("command-runs/$id/output", [
                        'success' => true,
                        'output' => $output->fetch(),
                    ]);
                } catch (\Throwable $e) {
                    Http::controlPanel()->post("command-runs/$id/output", [
                        'success' => false,
                        'output' => $e->getMessage(),
                    ]);
                }
            },
        ]);
    }
}
