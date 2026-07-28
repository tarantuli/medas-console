<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

readonly class CommandInput
{
    public function __construct(
        /**
         * Arguments passed to the command, keyed by the `name` of the matching
         * Argument declared in ConsoleCommand::arguments().
         */
        private array $arguments,

        /**
         * An associative array of options passed to the command.
         * A value of true indicates that no value was passed.
         */
        private array $options,
    )
    {
    }

    /**
     * Returns if the argument with the given name (matching an Argument::$name
     * from ConsoleCommand::arguments()) is set.
     */
    public function hasArgument(string $name): bool
    {
        return array_key_exists($name, $this->arguments);
    }

    /**
     * Returns the value of the argument with the given name (matching an
     * Argument::$name from ConsoleCommand::arguments()), null if it is not set.
     */
    public function getArgument(string $name): mixed
    {
        return $this->arguments[$name] ?? null;
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
