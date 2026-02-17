<?php

declare(strict_types=1);

namespace Medas\Console;

class Text implements Printable
{
    /** @param Formats\Format|Formats\Format[] $format */
    public static function create(string $text, ...$format): self
    {
        return new self($text, ...$format);
    }

    /** @var Formats\Format[] */
    public array $format;

    /** @param Formats\Format|Formats\Format[] $format */
    public function __construct(
        public string  $text,
        Formats\Format ...$format,
    )
    {
        $this->format = $format;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
