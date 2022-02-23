<?php

declare(strict_types=1);

use Medas\ConsoleTest\MockUps\MockUpPackage;

require_once __DIR__ . '/bootstrap.php';

sm()->addPackage(MockUpPackage::instance());
