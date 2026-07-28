<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\{
    CommandRepository,
    Commands\Argument,
    Commands\BaseConsoleCommand,
    Commands\CommandInput,
    Commands\ConsoleCommandGroup,
    Formats\SafeColor,
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

    public function arguments(): array
    {
        return [new Argument('filter', false)];
    }

    public function process(CommandInput $input): void
    {
        $data = [];

        $filter = $input->hasArgument('filter')
            ? '/' . preg_quote($input->getArgument('filter'), '/') . '/i'
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
                Text::create($command->fullCommand(), SafeColor::Green),
                Text::create(implode(', ', $command->aliases()), SafeColor::LightYellow),
                Text::create($command->description(), SafeColor::LightGray),
            ];
        }

        $this->printer
            ->printLine()
            ->printLine(Text::create('Available commands', SafeColor::White))
            ->printLine()
            ->printLine(Table::create(['Command', 'Aliases', 'Description'], $data));
    }
}
