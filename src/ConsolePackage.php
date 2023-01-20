<?php

declare(strict_types=1);

namespace Medas\Console;

use Medas\ServiceManager\{AsSingleton, BasePackage};

class ConsolePackage extends BasePackage
{
    use AsSingleton;

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
