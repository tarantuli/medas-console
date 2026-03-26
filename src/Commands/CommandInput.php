<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

readonly class CommandInput
{
    public function __construct(
        /**
         * A numeric list of arguments passed to the command.
         */
        public array $arguments,

        /**
         * An associative array of options passed to the command. A value of null indicates that no value was passed.
         */
        public array $options,
    )
    {
    }
}
