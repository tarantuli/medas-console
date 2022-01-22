<?php

declare(strict_types=1);

use Medas\ConfigManager\ConfigManager;
use Medas\ServiceManager\ServiceManager;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Contracts\Cache\CacheInterface;

require_once __DIR__ . '/bootstrap.php';

$sm = ServiceManager::get();

$cache = new ApcuAdapter('entity-manager');
$cache->clear();
$sm->bindService($cache, CacheInterface::class);

$config = $sm->resolve(ConfigManager::class);

$config->addDirectory(__DIR__ . '/config');
$config->readEnv(__DIR__);
