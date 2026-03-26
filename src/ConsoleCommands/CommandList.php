<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\{
    CommandRepository,
    Commands\BaseConsoleCommand,
    Commands\CommandInput,
    Commands\ConsoleCommandGroup,
    Commands\Range,
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

    public function description(): string
    {
        return 'Prints a list of all available commands';
    }

    public function allowedArgumentCount(): Range
    {
        return new Range(0, 1);
    }

    public function process(CommandInput $input): void
    {
        $data = [];

        $filter = $input->hasArgument(1)
            ? '/' . preg_quote($input->getArgument(1), '/') . '/i'
            : null;

        foreach ($this->commandRepository->getAllCommands() as $command) {
            if ($filter) {
                $fullText = $command->fullCommand()
                    . ' '
                    . implode(', ', $command->aliases())
                    . ' '
                    . $command->description();

                if (preg_match($filter, $fullText) === 0) {
                    continue;
                }
            }

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
}
