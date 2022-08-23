<?php

declare(strict_types=1);

namespace Medas\Console;

class Text implements Printable
{
    /** @param Formats\Format|Formats\Format[] $format */
    public static function create(string $text, mixed $format = null): self
    {
        return new self($text, $format);
    }

    /** @param Formats\Format|Formats\Format[] $format */
    public function __construct(
        public string $text,
        public mixed  $format = null,
    )
    {
    }
}
