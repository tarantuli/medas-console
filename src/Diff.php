<?php

declare(strict_types=1);

namespace Medas\Console;

readonly class Diff implements Printable
{
    public function __construct(
        public string $output,
    )
    {
    }
}
