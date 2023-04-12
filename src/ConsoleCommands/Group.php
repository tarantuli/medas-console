<?php

declare(strict_types=1);

namespace Medas\Console\ConsoleCommands;

use Medas\Console\Commands\{BaseConsoleCommandGroup, ConsoleCommandGroup};
use Medas\ServiceManager\Service;

#[Service]
class Group extends BaseConsoleCommandGroup
{
    public function parent(): ConsoleCommandGroup|null
    {
        return null;
    }

    public function name(): string
    {
        return 'console';
    }
}
