<?php

declare(strict_types=1);

namespace Medas\Console;

/**
 * Implemented by application-defined enums that expose a fixed palette of named, reusable styles
 * — e.g. `enum AppStyle implements NamedStyle { case Success; case Error; ... }` with a `style()`
 * method matching each case to a {@see Style}. Mirrors how {@see Formats\SafeColor} is a fixed,
 * enum-declared palette of colors, one level up: a fixed, enum-declared palette of whole styles.
 */
interface NamedStyle
{
    public function style(): Style;
}
