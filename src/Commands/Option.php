<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

class Option
{
    public function __construct(
        public string      $longCode,
        public string|null $shortCode = null,
        public bool        $valueRequired = false,
    )
    {
    }
}
