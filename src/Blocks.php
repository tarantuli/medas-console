<?php

declare(strict_types=1);

namespace Medas\Console;

class Blocks implements Printable
{
    /** @var Printable|null[] */
    public array $blocks;

    public function __construct(Printable|null ...$blocks)
    {
        $this->blocks = $blocks;
    }
}
