<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

use Medas\Core\Interfaces\Validator;

/**
 * Declares a single positional argument accepted by a ConsoleCommand.
 *
 * The order in which Argument instances are returned from
 * ConsoleCommand::arguments() is significant:
 * - Required arguments should be listed before optional ones.
 * - At most one argument may be variadic, and it must be the last one in the list.
 */
class Argument
{
    /**
     * A required, non-variadic argument.
     */
    public static function required(
        string         $name,
        Validator|null $validator = null,
        string|null    $description = null,
        mixed          $default = null,
    ): static
    {
        return new static($name, true, false, $validator, $description, $default);
    }

    /**
     * An optional, non-variadic argument.
     */
    public static function optional(
        string         $name,
        Validator|null $validator = null,
        string|null    $description = null,
        mixed          $default = null,
    ): static
    {
        return new static($name, false, false, $validator, $description, $default);
    }

    /**
     * A variadic argument, gathering all remaining values. Must be the last
     * argument returned from ConsoleCommand::arguments(). Optional by default.
     */
    public static function variadic(
        string         $name,
        bool           $required = false,
        Validator|null $validator = null,
        string|null    $description = null,
        mixed          $default = null,
    ): static
    {
        return new static($name, $required, true, $validator, $description, $default);
    }

    public function __construct(
        /**
         * The name this argument is addressed by via CommandInput::getArgument().
         */
        public string         $name,

        /**
         * Whether this argument must be supplied. If false and the argument is
         * not supplied, CommandInput::getArgument() returns the default.
         */
        public bool           $required = true,

        /**
         * Whether this argument gathers all remaining positional values instead
         * of a single value. Only the last argument in the list may be variadic.
         */
        public bool           $isVariadic = false,

        /**
         * An optional validator applied to the supplied value(s).
         */
        public Validator|null $validator = null,

        /**
         * A short, human-readable description shown in command help output.
         */
        public string|null    $description = null,

        /**
         * The value to fall back to when this argument is not supplied.
         */
        public mixed          $default = null,
    )
    {
    }
}
