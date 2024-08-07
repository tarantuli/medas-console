<?php

declare(strict_types=1);

namespace Medas\Console;

class Blocks implements Printable
{
    /** @var Printable[] */
    public array $blocks;

    public function __construct(Printable ...$blocks)
    {
        $this->blocks = $blocks;
    }
}
