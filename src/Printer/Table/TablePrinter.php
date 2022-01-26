<?php

declare(strict_types=1);

namespace Medas\Console\Printer\Table;

use Medas\Console\Printer;
use Medas\Console\Printer\Table;
use Medas\ServiceManager\Attributes\Service;

/**
 * @see https://en.wikipedia.org/wiki/Box-drawing_character#Box_Drawing for box drawing characters
 */
#[Service]
class TablePrinter
{
    private Printer $printer;

    private string $lineColor = Printer\BashFormat::COLOR256 . '22';
    private string $headerColor = Printer\BashFormat::WHITE;
    private int $leftIndent = 3;
    private int $columnSeparator = 3;

    /** @var Column[] */
    private array $columns;

    public function print(Table $table): void
    {
        $this->columns = $table->columns();
        $this->printer = service(Printer::class);

        $this->printHeader();
        $this->printHorizontalBorder();

        foreach ($table->data() as $record) {
            $this->printRecord($record);
        }
    }

    private function printHeader(): void
    {
        $elements = $this->initializeElements();

        foreach ($this->columns as $i => $column) {
            if ($i > 0) {
                $elements[] = new Printer\Text(str_repeat(' ', $this->columnSeparator), $this->lineColor);
            }

            $elements[] = new Printer\Text(sprintf('%-' . ($column->maxWidth) . 's', $column->header), $this->headerColor);
        }

        $this->printer->printLine(...$elements);
    }

    private function initializeElements(): array
    {
        return [new Printer\Text(str_repeat(' ', $this->leftIndent))];
    }

    private function printHorizontalBorder(): void
    {
        $elements = $this->initializeElements();
        foreach ($this->columns as $i => $column) {
            if ($i > 0) {
                $elements[] = new Printer\Text(str_repeat('─', $this->columnSeparator), $this->lineColor);
            }

            $elements[] = new Printer\Text(str_repeat('─', $column->maxWidth), $this->lineColor);
        }

        $this->printer->printLine(...$elements);
    }

    private function printRecord(mixed $record): void
    {
        $elements = $this->initializeElements();
        foreach ($record as $i => $value) {
            if ($i > 0) {
                $elements[] = new Printer\Text(str_repeat(' ', $this->columnSeparator), $this->lineColor);
            }

            $alignment = is_int($value) ? '' : '-';
            $elements[] = new Printer\Text(sprintf('%' . $alignment . ($this->columns[$i]->maxWidth) . 's', $value));
        }
        $this->printer->printLine(...$elements);
    }
}
