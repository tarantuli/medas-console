<?php

declare(strict_types=1);

namespace Medas\Console\Formats;

use Medas\Console\Exceptions\InvalidHexColorException;

class HexColor implements Format
{
    public static function create(string $color): static
    {
        return new static($color);
    }

    public function __construct(
        private string $color,
    )
    {
        $this->color = strtolower($this->color);

        if (!preg_match('/^#[0-9a-f]{6}$/', $this->color)) {
            throw new InvalidHexColorException($this->color);
        }
    }

    public function color(): string
    {
        return $this->color;
    }
}
