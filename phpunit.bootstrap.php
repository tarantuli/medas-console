<?php

declare(strict_types=1);

use Medas\Console\ConsolePackage;
use Medas\ConsoleTest\MockUps\MockUpPackage;
use Medas\ServiceManager\ServiceManager;

ServiceManager::get()->addPackages([
    ConsolePackage::instance(),
    MockUpPackage::instance(),
]);
