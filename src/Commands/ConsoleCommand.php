<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

interface ConsoleCommand
{
    public function group(): ConsoleCommandGroup;

    public function name(): string;

    public function fullCommand(): string;

    /**
     * This should return an array of alias words.
     *
     * Each word can be used as a direct alias to this command, bypassing both the group name and the command name when
     * invoking. Each alias should consist of lowercase letters, numbers, dots, and dashes only and must be at least two
     * characters long.
     *
     * Commands that create something should start with "c.", e.g. "c.entity"
     */
    public function aliases(): array;

    /**
     * This should start with a capital and not end in a period.
     */
    public function description(): string;

    /**
     * This should return an array of Option objects. If an option is passed that is not defined here, it will throw an exception.
     *
     * @return Option[]
     */
    public function options(): array;

    /**
     * The minimum number of arguments that must be passed to this command.
     */
    public function minArgumentCount(): int;

    /**
     * The maximum number of arguments that can be passed to this command.
     */
    public function maxArgumentCount(): int;

    public function process(CommandInput $input): void;
}
