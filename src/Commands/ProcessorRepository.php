<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

use Medas\ServiceManager\Attributes\Service;
use Medas\ServiceManager\Interfaces\Cache;

#[Service]
class ProcessorRepository
{
    public function __construct(
        private Cache $cache,
    )
    {
    }

    /** @return ConsoleCommandGroup[] */
    public function getGroups(ConsoleCommandGroup $parent = null): array
    {
        $groups = [];

        foreach ($this->getAllGroups() as $group) {
            if ($group->parent() === $parent) {
                $groups[] = $group;
            }
        }

        return $groups;
    }

    /** @return ConsoleCommandGroup[] */
    public function getAllGroups(): array
    {
        return $this->cache->get([$this::class, 'getAllGroups'], function () {
            return $this->findAllGroups();
        });
    }

    private function findAllGroups(): array
    {
        $sm = sm();
        $groups = [];

        foreach ($sm->getServiceClassNames() as $className) {
            $class = new \ReflectionClass($className);

            if (!$class->implementsInterface(ConsoleCommandGroup::class)) {
                continue;
            }

            /** @var ConsoleCommandGroup $group */
            $groups[] = $sm->resolve($className);
        }

        return $groups;
    }

    /** @return ConsoleCommand[] */
    public function getProcessors(ConsoleCommandGroup $parent): array
    {
        $processors = [];

        foreach ($this->getAllProcessors() as $processor) {
            if ($processor->group() === $parent) {
                $processors[] = $processor;
            }
        }

        return $processors;
    }

    /** @return ConsoleCommand[] */
    public function getAllProcessors(): array
    {
        return $this->cache->get([$this::class, 'getAllProcessors'], function () {
            return $this->findAllProcessors();
        });
    }

    private function findAllProcessors(): array
    {
        $processors = [];
        $sm = sm();

        foreach ($sm->getServiceClassNames() as $className) {
            $class = new \ReflectionClass($className);

            if ($class->isAbstract()) {
                continue;
            }

            if (!$class->implementsInterface(ConsoleCommand::class)) {
                continue;
            }

            $processors[] = $sm->resolve($className);
        }

        return $processors;
    }
}
