<?php

declare(strict_types=1);

namespace Medas\Console;

class Table implements Printable
{
    /**
     * @param  (string|Printable|ColumnDef)[]  $headers  A plain string behaves as before
     *         (auto-sized, uncolored); a {@see ColumnDef} declares width/alignment/truncation/
     *         color for that column once, instead of per row.
     * @param  Printable[][]                    $data
     */
    public static function create(array $headers, array $data = []): self
    {
        return new self($headers, $data);
    }

    /**
     * @param  (string|Printable|ColumnDef)[]  $headers
     * @param  Printable[][]                    $data
     */
    public function __construct(
        public array $headers,
        public array $data = [],
    )
    {
    }
}
