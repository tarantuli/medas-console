<?php

declare(strict_types=1);

namespace Medas\Console\Exceptions;

use Medas\Core\Exceptions\BaseException;

class UndeclaredArgumentRequested extends BaseException
{
    /** @param string[] $declaredArguments */
    public function __construct(string $name, array $declaredArguments)
    {
        parent::__construct($name, implode(', ', $declaredArguments));
    }

    public function pattern(): string
    {
        return 'Argument "%s" was requested but is not declared by the command (declared: %s)';
    }
}
