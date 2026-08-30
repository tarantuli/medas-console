<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

use Medas\Console\Exceptions\UndeclaredArgumentRequested;

readonly class CommandInput
{
    public function __construct(
        /**
         * Arguments passed to the command, keyed by the `name` of the matching
         * Argument declared in ConsoleCommand::arguments().
         */
        private array $arguments = [],

        /**
         * An associative array of options passed to the command.
         * A value of true indicates that no value was passed.
         */
        private array $options = [],
    )
    {
    }

    /**
     * Returns if the argument with the given name (matching an Argument::$name
     * from ConsoleCommand::arguments()) is set.
     */
    public function hasArgument(string $name): bool
    {
        return array_key_exists($name, $this->arguments) && $this->arguments[$name] !== null;
    }

    /**
     * Returns the value of the argument with the given name (matching an
     * Argument::$name from ConsoleCommand::arguments()). A declared but unsupplied
     * argument yields its default; requesting a name the command never declared
     * throws, since that's a programming error (typically a typo).
     */
    public function getArgument(string $name): mixed
    {
        if (!array_key_exists($name, $this->arguments)) {
            throw new UndeclaredArgumentRequested($name, array_keys($this->arguments));
        }

        return $this->arguments[$name];
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
