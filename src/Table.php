<?php

declare(strict_types=1);

namespace Medas\Console;

class Table implements Printable
{
    public static function create(array $headers, array $data = []): self
    {
        return new self($headers, $data);
    }

    public function __construct(
        public array $headers,
        public array $data = [],
    )
    {
    }
}
