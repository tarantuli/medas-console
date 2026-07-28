<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

/**
 * Declares a single named option accepted by a ConsoleCommand, e.g. `--format=csv` or `-f csv`.
 *
 * An option is always addressed by CommandInput::getOption()/hasOption() using its `longCode`.
 * Use one of the three named constructors to declare its value mode:
 * - noValue()       a flag, e.g. `--verbose` or `-v`
 * - valueAllowed()  an optionally valued option, e.g. `--format` or `--format=csv`
 * - valueRequired() a mandatory-valued option, e.g. `--format=csv`
 */
class Option
{
    /**
     * An option that may optionally take a value, e.g. `--format` or `--format=csv`.
     */
    public static function valueAllowed(
        string      $longCode,
        string|null $shortCode = null,
        string|null $description = null
    ): static
    {
        return new static($longCode, $shortCode, true, description: $description);
    }

    /**
     * An option that must be given a value, e.g. `--format=csv`.
     */
    public static function valueRequired(
        string      $longCode,
        string|null $shortCode = null,
        string|null $description = null
    ): static
    {
        return new static($longCode, $shortCode, true, true, description: $description);
    }

    /**
     * A flag option that never takes a value, e.g. `--verbose` or `-v`.
     * CommandInput::hasOption() returns true and CommandInput::getOption() returns true when passed.
     */
    public static function noValue(
        string      $longCode,
        string|null $shortCode = null,
        string|null $description = null
    ): static
    {
        return new static($longCode, $shortCode, description: $description);
    }

    public function __construct(
        /**
         * The name this option is addressed by, e.g. `--format`, and via CommandInput::getOption('format').
         */
        public string      $longCode,

        /**
         * An optional single-character shorthand, e.g. `-f` for `--format`.
         */
        public string|null $shortCode = null,

        /**
         * Whether this option may take a value.
         */
        public bool        $valueAllowed = false,

        /**
         * Whether this option must be given a value when passed.
         */
        public bool        $valueRequired = false,

        /**
         * A short, human-readable description shown in command help output.
         */
        public string|null $description = null,
    )
    {
    }
}
