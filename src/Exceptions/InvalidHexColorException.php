<?php

declare(strict_types=1);

namespace Medas\Console\Exceptions;

use Medas\Core\Exceptions\BaseException;

class InvalidHexColorException extends BaseException
{
    public function __construct(string $code)
    {
        parent::__construct($code);
    }

    public function pattern(): string
    {
        return '%s is not a valid color code consisting of a # followed by six hexadecimal digits';
    }
}
