<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

interface ConsoleCommand
{
    public function group(): ConsoleCommandGroup;

    public function name(): string;

    /**
     * This should return an array of alias words.
     *
     * Each word can be used as a direct alias to this command, bypassing both the group name and the command name when
     * invoking. Each alias should consist of lowercase letters, dots and dashes only.
     *
     * Commands that create something should start with "c.", e.g. "c.entity"
     */
    public function aliases(): array;

    /**
     * This should start with a capital, and not end in a period.
     */
    public function description(): string;

    /**
     * See https://github.com/docopt/docopt.php#help-message-format for the format
     * of each usage string.
     *
     * Each string must consist of the definition after the command name itself,
     * e.g. if the command would be "php bin/console examples:command --output",
     * the usage string should be "--output"
     *
     * @return string[]
     */
    public function usages(): array;

    /**
     * See https://github.com/docopt/docopt.php#help-message-format for the format
     * of each option string.
     *
     * @return string[]
     */
    public function options(): array;

    public function fullCommand(): string;

    public function process(array $arguments): void;
}
