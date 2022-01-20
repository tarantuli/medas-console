<?php

declare(strict_types=1);

namespace Medas\Console;

use Medas\Console\Printer\Text;
use Medas\ServiceManager\Attributes\Service;

#[Service]
class Printer
{
    public function printLine(Text ...$texts): self
    {
        $this->print(... $texts);
        echo "\n";

        return $this;
    }

    public function print(Text ...$texts): self
    {
        foreach ($texts as $text) {
            if ($text->format === null) {
                echo $text->text;
            }
            else {
                $this->format($text->text, $text->format);
            }
        }

        return $this;
    }

    public function format(string $string, string|array $format): self
    {
        printf("\e[%sm%s\e[0m", is_array($format) ? implode(';', $format) : $format, $string);

        return $this;
    }
}
