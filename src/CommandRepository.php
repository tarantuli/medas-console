<?php

declare(strict_types=1);

namespace Medas\Console;

interface CommandRepository
{
    /** @return Commands\ConsoleCommand[] */
    public function getAllCommands(): array;
}
