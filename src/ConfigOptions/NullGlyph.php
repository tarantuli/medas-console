<?php

declare(strict_types=1);

namespace Medas\Console\ConfigOptions;

use Medas\ServiceManager\AsSingleton;
use Medas\ServiceManager\ConfigOptions\ConfigGroup;
use Medas\ServiceManager\ConfigOptions\ConfigOption;

class NullGlyph implements ConfigOption
{
    use AsSingleton;

    public function group(): ConfigGroup
    {
        return Group::instance();
    }

    public function name(): string
    {
        return 'null-glyph';
    }

    public function description(): string
    {
        return 'How to represent null values when printing';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): string
    {
        return '〜';
    }
}
