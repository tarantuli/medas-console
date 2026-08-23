<?php

declare(strict_types=1);

namespace Medas\Console;

/**
 * A declarative column for {@see Table}, in place of a plain string header. Lets a column's
 * width, alignment, truncation and color be declared once, instead of every row re-deriving the
 * same padding and color for that field by hand.
 *
 * `Table::create()` accepts a mix of plain strings and `ColumnDef`s in its `$headers` array —
 * a plain string behaves exactly as it does today (auto-sized to content, numeric values
 * right-aligned automatically, never truncated). Only columns declared with a `ColumnDef` get
 * fixed width / explicit alignment / truncation:
 *
 *   Table::create(
 *       headers: [
 *           ColumnDef::create('Artist', width: 30, style: SafeColor::LightYellow),
 *           ColumnDef::create('Title', width: 50, style: SafeColor::LightGreen),
 *           'Status', // still a plain header — auto-sized, uncolored
 *       ],
 *       data: $rows,
 *   );
 *
 * `$style` supplies color/decoration only — a full {@see Style} may be passed, but its own
 * `width`/`align`/`truncate` are ignored in this context, since those are owned by the column
 * (they must be uniform across every row; color does not need to be). `$style` may also be a
 * closure — `fn(mixed $value, array $row): Style|null` — for color that depends on the cell's
 * data rather than being fixed per column.
 */
readonly class ColumnDef
{
    public static function create(
        string              $header,
        int|null            $width = null,
        Align               $align = Align::Left,
        bool                $truncate = true,
        Style|\Closure|null $style = null,
    ): self
    {
        return new self($header, $width, $align, $truncate, $style);
    }

    public function __construct(
        public string              $header,
        public int|null            $width = null,
        public Align               $align = Align::Left,
        public bool                $truncate = true,
        public Style|\Closure|null $style = null,
    )
    {
    }

    /** Resolves this column's color/decoration style for one cell, given its value and full row. */
    public function resolveStyle(mixed $value, array $row): Style|null
    {
        if ($this->style instanceof \Closure) {
            return ($this->style)($value, $row);
        }

        return $this->style;
    }
}
