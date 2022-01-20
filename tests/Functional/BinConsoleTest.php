<?php

declare(strict_types=1);

namespace Medas\ConsoleTest\Functional;

class BinConsoleTest extends BaseTest
{
    public function testExecuteConsole(): void
    {
        $output = $this->execute('console:commands');
        self::assertStringContainsString('Available', implode("\n", $output));
    }
}
