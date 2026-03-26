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
         * An associative array of options passed to the command. A value of true indicates that no value was passed.
         */
        public array $options,
    )
    {
    }

    /**
     * Returns if the given one-based index is set.
     */
    public function hasArgument(int $index): bool
    {
        return array_key_exists($index - 1, $this->arguments);
    }

    /**
     * Returns the value of the argument at the given one-based index, null if it is not set.
     */
    public function getArgument(int $index): mixed
    {
        return $this->arguments[$index - 1] ?? null;
    }

    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Returns the value of the option with the given name, null if it is not set.
     */
    public function getOption(string $name): mixed
    {
        return $this->options[$name] ?? null;
    }
}
