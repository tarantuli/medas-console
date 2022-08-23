<?php

declare(strict_types=1);

namespace Medas\Console\Formats;

enum Color implements Format
{
    case Default;
    case Black;
    case Red;
    case Green;
    case Yellow;
    case Blue;
    case Magenta;
    case Cyan;
    case LightGray;
    case Gray;
    case LightRed;
    case LightGreen;
    case LightYellow;
    case LightBlue;
    case LightMagenta;
    case LightCyan;
    case White;
}
