<?php

declare(strict_types=1);

namespace Medas\Console;

use Medas\ConfigOptions\Attributes\ConfigValue;
use Medas\Console\ConfigOptions\NullGlyph;
use Medas\Console\Printer\Table\TablePrinter;
use Medas\Console\Printer\Text;
use Medas\ServiceManager\Attributes\Service;

#[Service]
class Printer
{
    public function __construct(
        #[ConfigValue(NullGlyph::class)]
        private string       $nullGlyph,
        private TablePrinter $tablePrinter,
    )
    {
    }

    public function printLine(Text ...$texts): self
    {
        $this->print(... $texts);
        echo "\n";

        return $this;
    }

    public function print(Text ...$texts): self
    {
        foreach ($texts as $text) {
            if ($text === null) {
                echo $this->nullGlyph;
            }
            elseif ($text->format === null) {
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

    public function printTable(Printer\Table $table): self
    {
        $this->tablePrinter->print($table);

        return $this;
    }
}
