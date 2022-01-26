<?php

declare(strict_types=1);

namespace Medas\ConsoleTest\Functional\Printer;

use Medas\Console\ConsolePackage;
use Medas\Console\Printer\Table;
use Medas\Console\Printer\Table\TablePrinter;
use Medas\ConsoleTest\Functional\BaseTest;
use Medas\ServiceManager\ServiceManagerPackage;

class TablePrinterTest extends BaseTest
{
    public function testBasicTest(): void
    {
        ob_start();
        service(TablePrinter::class)->print(new Table(
            ['id', 'package'],
            [
                [1, ServiceManagerPackage::class],
                [2, ConsolePackage::class],
            ]
        ));

        $output = ob_get_clean();

        self::assertStringContainsString('Medas\\ServiceManager\\ServiceManagerPackage', $output);
        self::assertStringContainsString('─', $output);
    }
}
