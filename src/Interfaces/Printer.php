<?php

declare(strict_types=1);

namespace Medas\Console\Interfaces;

use Medas\Console\Printable;

interface Printer
{
    public function print(Printable ...$blocks): self;
}
