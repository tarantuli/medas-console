<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

readonly abstract class BaseConsoleCommand implements ConsoleCommand
{
    public function fullCommand(): string
    {
        return $this->group()->path() . ':' . $this->name();
    }

    public function aliases(): array
    {
        return [];
    }

    public function options(): array
    {
        return [];
    }

    public function minArgumentCount(): int
    {
        return 0;
    }

    public function maxArgumentCount(): int
    {
        return 0;
    }
}
