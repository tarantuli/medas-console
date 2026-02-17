<?php

declare(strict_types=1);

namespace Medas\Console;

interface Printer
{
    /** Prints the given blocks inline */
    public function print(Printable ...$blocks): self;

    /** Prints the given blocks inline and ends with a newline */
    public function printLine(Printable ...$blocks): self;

    /** Prints the given text as an inline block */
    public function printText(string $text, mixed $format = null): self;

    /** Prints a newline */
    public function printEol(): self;
}
