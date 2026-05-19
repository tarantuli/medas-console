<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

class Range
{
    public static function exactly(int $value): static
    {
        return new static($value);
    }

    /**
     * If $max is null or not given, then the max is equal to $min. If $max is false, then the max is infinite.
     */
    public function __construct(
        public int            $min,
        public int|false|null $max = null,
    )
    {
        if ($this->max === null) {
            $this->max = $min;
        }
    }
}
