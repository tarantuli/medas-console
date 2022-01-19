<?php

declare(strict_types=1);

namespace Medas\Console;

use Medas\ServiceManager\BasePackage;

class ConsolePackage extends BasePackage
{
    public function dependencies(): array
    {
        return $this->dependenciesByClass([
        ]);
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
