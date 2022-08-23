<?php

declare(strict_types=1);

namespace Medas\Console;

interface Printer
{
    public function print(Printable ...$blocks): self;
}
