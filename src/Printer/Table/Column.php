<?php

declare(strict_types=1);

namespace Medas\Console\Printer\Table;

class Column
{
    public function __construct(
        public string $header,
        public int $maxWidth
    )
    {
    }
}
