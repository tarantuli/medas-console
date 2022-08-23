<?php

declare(strict_types=1);

namespace Medas\Console\Interfaces;

use Medas\Console\Commands\ConsoleCommand;

interface CommandRepository
{
    /** @return ConsoleCommand[] */
    public function getAllCommands(): array;
}

