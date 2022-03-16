<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

use Medas\ServiceManager\Attributes\Service;

#[Service]
class CommandProcessor
{
    public function __construct(
        private ProcessorFinder $processorFinder,
    )
    {
    }

    public function process(array $arguments): void
    {
        $processor = $this->processorFinder->find($arguments[0] ?? 'console:commands');

        $processor->process($arguments);
    }
}
