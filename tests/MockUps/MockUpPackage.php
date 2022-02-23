<?php

declare(strict_types=1);

namespace Medas\ConsoleTest\MockUps;

use Medas\Cache\FilesystemCache;
use Medas\ConfigManager\ConfigManager;
use Medas\ServiceManager\AsSingleton;
use Medas\ServiceManager\BasePackage;

class MockUpPackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }

    public function initialize(): void
    {
        $cache = new FilesystemCache(__DIR__ . '/../../var/cache');
        $cache->clear();
        sm()->setCache($cache);

        $config = sm()->resolve(ConfigManager::class);

        $config->addDirectory(__DIR__ . '/../../config');
        $config->readEnv(__DIR__ . '/../..');

        parent::initialize();
    }
}
