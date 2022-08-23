<?php

declare(strict_types=1);

use Medas\Console\ConsolePackage;
use Medas\ServiceManager\ServiceManager;

chdir(__DIR__);

$sm = ServiceManager::get();
$sm->addPackage(ConsolePackage::instance());
