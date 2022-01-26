<?php

declare(strict_types=1);

namespace Medas\Console\Printer;

class Table
{
    public function __construct(
        private array $headers = [],
        private array $data = []
    )
    {
    }

    /** @return Table\Column[] */
    public function columns(): array
    {
        $maxWidths = array_fill(0, count($this->headers), 0);

        foreach ($this->data as $record) {
            foreach ($record as $i => $value) {
                $maxWidths[$i] = max($maxWidths[$i], mb_strlen((string) $value));
            }
        }

        $columns = [];
        foreach ($this->headers as $i => $header) {
            $maxWidths[$i] = max($maxWidths[$i], mb_strlen($header));
            $columns[] = new Table\Column($header, $maxWidths[$i]);
        }

        return $columns;
    }

    public function data(): array
    {
        return $this->data;
    }
}
