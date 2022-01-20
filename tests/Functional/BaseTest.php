<?php

declare(strict_types=1);

namespace Medas\ConsoleTest\Functional;

use Medas\ConfigManager\ConfigManager;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    public function execute(string $command): array
    {
        $pathToPhp = service(ConfigManager::class)->getValue('console.path-to-php');
        $pathToConsole = realpath(__DIR__ . '/../../bin/console');

        exec($pathToPhp . ' ' . $pathToConsole . ' ' . $command, $output);

        return $output;
    }
}
