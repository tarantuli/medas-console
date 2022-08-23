<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\{Commands\BaseConsoleCommand,
    Commands\ConsoleCommandGroup,
    Formats\Style,
    Interfaces\CommandRepository,
    Interfaces\Printer,
    Table,
    Text
};
use Medas\ServiceManager\Attributes\Service;

#[Service]
class CommandList extends BaseConsoleCommand
{
    public function __construct(
        private readonly Group             $group,
        private readonly Printer           $printer,
        private readonly CommandRepository $commandRepository,
    )
    {
    }

    public function group(): ConsoleCommandGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'command-list';
    }

    public function description(): string
    {
        return 'Prints a list of all available commands';
    }

    public function process(array $arguments): void
    {
        $data = [];

        foreach ($this->commandRepository->getAllCommands() as $command) {
            $data[] = [
                Text::create($command->fullCommand(), Style::Bold),
                Text::create($command->description()),
            ];
        }

        $this->printer
            ->print(Text::create('Available commands: '))
            ->print()
            ->print(Table::create(['command', 'description'], $data));
    }
}
