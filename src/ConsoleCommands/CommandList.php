<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\{CommandRepository,
    Commands\BaseConsoleCommand,
    Commands\ConsoleCommandGroup,
    Formats\Color,
    Formats\Style,
    Printer,
    Table,
    Text};
use Medas\Core\Attributes\Service;

#[Service]
readonly class CommandList extends BaseConsoleCommand
{
    public function __construct(
        private Group             $group,
        private Printer           $printer,
        private CommandRepository $commandRepository,
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

    public function process(array $arguments): void
    {
        $data = [];

        foreach ($this->commandRepository->getAllCommands() as $command) {
            $data[] = [
                Text::create($command->fullCommand(), Color::Green),
                Text::create($command->description(), Color::LightGray),
            ];
        }

        $this->printer
            ->printLine()
            ->printLine(Text::create('Available commands: '))
            ->printLine()
            ->printLine(Table::create(['Command', 'Description'], $data));
    }

    public function description(): string
    {
        return 'Prints a list of all available commands';
    }
}
