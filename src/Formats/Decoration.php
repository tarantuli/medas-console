<?php

declare(strict_types=1);

namespace Medas\Console\Formats;

enum Decoration implements Format
{
    case Bold;
    case Dim;
    case Underlined;
}
