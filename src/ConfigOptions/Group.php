<?php

declare(strict_types=1);

namespace Medas\Console\ConfigOptions;

use Medas\ConfigOptions\ConfigGroup;
use Medas\ServiceManager\AsSingleton;

class Group implements ConfigGroup
{
    use AsSingleton;

    public function parent(): ConfigGroup|null
    {
        return null;
    }

    public function name(): string
    {
        return 'console';
    }
}
