<?php

declare(strict_types=1);

namespace Medas\ConsoleTest\MockUps;

use Medas\ConfigManager\ConfigManager;
use Medas\ConfigManager\ConfigManagerPackage;
use Medas\ServiceManager\AsSingleton;
use Medas\ServiceManager\BasePackage;

class MockUpPackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [
            ConfigManagerPackage::instance()
        ];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }

    public function initialize(): void
    {
        $config = sm()->resolve(ConfigManager::class);

        $config->addDirectory(__DIR__ . '/../../config');
        $config->readEnv(__DIR__ . '/../..');

        parent::initialize();
    }
}
