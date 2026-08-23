<?php

declare(strict_types=1);

namespace Medas\Console;

/**
 * A named, reusable bundle of the properties that are otherwise repeated by hand at every call
 * site: color/decoration (the existing {@see Format} axes) plus layout — width, alignment,
 * truncation, padding — which nothing in this package could previously express at all.
 *
 * `Style` itself implements {@see Format}, so it drops straight into the existing
 * `Text::create(string $text, Format ...$format)` signature alongside atomic formats:
 *
 *   Text::create('Done', AppStyle::Success->style())
 *   Text::create('Done', SafeColor::LightGreen, Decoration::Bold)   // still works, unchanged
 *
 * Only the *rendering* side needs to know what a `Style` is (it must expand it into atomic
 * formats for color, and apply its layout to the string before that) — this class itself stays
 * free of any ANSI/terminal knowledge, consistent with the rest of this package.
 *
 * Inside a {@see Table} column ({@see ColumnDef}), only the color/decoration half of a `Style`
 * is consulted — width, alignment and truncation are owned by the column itself, since those are
 * inherently a column-wide property, not a per-cell one. See {@see ColumnDef} for that split.
 */
readonly class Style implements Formats\Format
{
    public static function create(
        Formats\Format|null $foreground = null,
        Formats\Format|null $background = null,
        bool                $bold = false,
        bool                $dim = false,
        bool                $underlined = false,
        int|null            $width = null,
        Align               $align = Align::Left,
        bool                $truncate = false,
        string              $truncationSuffix = '…',
        int                 $paddingLeft = 0,
        int                 $paddingRight = 0,
    ): self
    {
        return new self(
            $foreground,
            $background,
            $bold,
            $dim,
            $underlined,
            $width,
            $align,
            $truncate,
            $truncationSuffix,
            $paddingLeft,
            $paddingRight,
        );
    }

    public function __construct(
        public Formats\Format|null $foreground = null,
        public Formats\Format|null $background = null,
        public bool                $bold = false,
        public bool                $dim = false,
        public bool                $underlined = false,
        public int|null            $width = null,
        public Align               $align = Align::Left,
        public bool                $truncate = false,
        public string              $truncationSuffix = '…',
        public int                 $paddingLeft = 0,
        public int                 $paddingRight = 0,
    )
    {
    }

    /**
     * The atomic {@see Format} values (foreground, background, decorations) this style expands
     * to. This is the only part of a `Style` a renderer needs in order to produce ANSI codes —
     * everything else (`width`, `align`, `truncate`, padding) is layout, handled separately by
     * {@see self::applyLayout()}.
     *
     * @return Formats\Format[]
     */
    public function colorFormats(): array
    {
        $formats = [];

        if ($this->foreground) {
            $formats[] = $this->foreground;
        }

        if ($this->background) {
            $formats[] = $this->background;
        }

        if ($this->bold) {
            $formats[] = Formats\Decoration::Bold;
        }

        if ($this->dim) {
            $formats[] = Formats\Decoration::Dim;
        }

        if ($this->underlined) {
            $formats[] = Formats\Decoration::Underlined;
        }

        return $formats;
    }

    public function hasLayout(): bool
    {
        return $this->width !== null || $this->paddingLeft > 0 || $this->paddingRight > 0;
    }

    /**
     * Applies this style's width, truncation, alignment and padding to a raw string. Pure text
     * transformation — no ANSI codes are involved, so this is safe to call before color-formatting.
     */
    public function applyLayout(string $text): string
    {
        if ($this->width !== null) {
            if ($this->truncate && mb_strwidth($text) > $this->width) {
                $suffixWidth = mb_strwidth($this->truncationSuffix);
                $keep = max(0, $this->width - $suffixWidth);
                $text = mb_substr($text, 0, $keep) . $this->truncationSuffix;
            }

            $padLength = $this->width - mb_strwidth($text);

            if ($padLength > 0) {
                $text = match ($this->align) {
                    Align::Left => $text . str_repeat(' ', $padLength),
                    Align::Right => str_repeat(' ', $padLength) . $text,

                    Align::Center
                        => str_repeat(' ', intdiv($padLength, 2))
                            . $text
                            . str_repeat(' ', $padLength - intdiv($padLength, 2)),
                };
            }
        }

        return str_repeat(' ', $this->paddingLeft) . $text . str_repeat(' ', $this->paddingRight);
    }
}
