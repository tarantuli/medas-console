<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

class Option
{
    public static function valueAllowed(string $longCode, string|null $shortCode = null): static
    {
        return new static($longCode, $shortCode, true);
    }

    public static function valueRequired(string $longCode, string|null $shortCode = null): static
    {
        return new static($longCode, $shortCode, true, true);
    }

    public static function noValue(string $longCode, string|null $shortCode = null): static
    {
        return new static($longCode, $shortCode);
    }

    public function __construct(
        public string      $longCode,
        public string|null $shortCode = null,
        public bool        $valueAllowed = false,
        public bool        $valueRequired = false,
    )
    {
    }
}
