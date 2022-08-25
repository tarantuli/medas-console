<?php

declare(strict_types=1);

namespace Medas\Console;

interface Printer
{
    public function print(Printable ...$blocks): self;

    public function printText(string $text, mixed $format = null): self;

    public function printEol(): self;
}
