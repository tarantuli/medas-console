<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\Commands\{BaseConsoleCommand, ConsoleCommandGroup, ProcessorRepository};
use Medas\Console\Printer;
use Medas\ServiceManager\Attributes\Service;

#[Service]
class CommandsCommand extends BaseConsoleCommand
{
    public function __construct(
        private Printer             $printer,
        private ProcessorRepository $repository,
    )
    {
    }

    public function group(): ConsoleCommandGroup
    {
        return service(ConsoleGroup::class);
    }

    public function name(): string
    {
        return 'commands';
    }

    public function description(): string
    {
        return 'Prints a list of all available commands';
    }

    public function process(array $arguments)
    {
        $this->printer
            ->printLine(
                new Printer\Text('Available commands: ', Printer\BashFormat::LIGHT_GRAY)
            )
            ->printLine();

        foreach ($this->repository->getAllProcessors() as $processor) {
            $this->printer->printLine(
                new Printer\Text('   ' . $processor->fullCommand(), Printer\BashFormat::WHITE)
            );
        }
    }
}
