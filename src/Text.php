<?php

declare(strict_types=1);

namespace Medas\Console;

class Text implements Printable
{
    /** @param Formats\Format|Formats\Format[] $format */
    public static function create(string|\Stringable $text, ...$format): self
    {
        return new self($text, ...$format);
    }

    private string $text;

    /** @var Formats\Format[] */
    public array $format;

    /** @param Formats\Format[] $format */
    public function __construct(
        string|\Stringable  $text,
        Formats\Format|null ...$format,
    )
    {
        $this->text = (string) $text;
        $this->format = $format;
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
