<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\{
    CommandRepository,
    Commands\BaseConsoleCommand,
    Commands\ConsoleCommandGroup,
    Formats\Color,
    Printer,
    Table,
    Text
};
use Medas\Core\Attributes\Service;

#[Service]
readonly class CommandList extends BaseConsoleCommand
{
    public function __construct(
        private CommandRepository $commandRepository,
        private Group             $group,
        private Printer           $printer,
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
                Text::create(implode(', ', $command->aliases()), Color::LightYellow),
                Text::create($command->description(), Color::LightGray),
            ];
        }

        $this->printer
            ->printLine()
            ->printLine(Text::create('Available commands', Color::White))
            ->printLine()
            ->printLine(Table::create(['Command', 'Aliases', 'Description'], $data));
    }

    public function description(): string
    {
        return 'Prints a list of all available commands';
    }
}
