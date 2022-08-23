<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

abstract class BaseConsoleCommand implements ConsoleCommand
{
    public function fullCommand(): string
    {
        return $this->group()->path() . ':' . $this->name();
    }
}
