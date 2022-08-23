<?php

declare(strict_types=1);

namespace Medas\Console\Formats;

enum Style implements Format
{
    case Bold;
    case Dim;
    case Underlined;
}
