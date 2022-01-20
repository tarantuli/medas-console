<?php

declare(strict_types=1);

use Medas\ConfigManager\ConfigManager;
use Medas\Console\ConsolePackage;
use Medas\ServiceManager\ServiceManager;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Contracts\Cache\CacheInterface;

$sm = ServiceManager::get();
$sm->addPackage(ConsolePackage::instance());

$cache = new ApcuAdapter('entity-manager');
$cache->clear();
$sm->bindService($cache, CacheInterface::class);

$config = $sm->resolve(ConfigManager::class);

$config->addDirectory(__DIR__ . '/config');
$config->readEnv(__DIR__);
