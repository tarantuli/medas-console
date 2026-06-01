<?php

declare(strict_types=1);

namespace Medas\Console\Formats;

enum SafeColor: string implements Format
{
    case Red = '#d70000';
    case Green = '#00af00';
    case Yellow = '#ffff00';
    case Blue = '#0087ff';
    case Magenta = '#af00af';
    case Cyan = '#00afaf';
    case Orange = '#ff8700';
    case White = '#ffffff';
    case Black = '#000000';
    case Gray = '#808080';
    case LightGray = '#d0d0d0';
    case LightRed = '#ff5f5f';
    case LightGreen = '#5fff87';
    case LightBlue = '#5fafff';
    case LightYellow = '#ffffd7';
    case LightCyan = '#afffff';
    case LightMagenta = '#ff87ff';
    case DarkGray = '#444444';
    case DarkRed = '#af0000';
    case DarkGreen = '#005f00';
    case DarkYellow = '#d7af00';
}
