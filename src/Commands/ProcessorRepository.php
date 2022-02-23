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
        return $this->cache->get([$this::class, 'getGroups', $parent ? $parent::class : 'null'], function () use ($parent) {
            return $this->findGroups($parent);
        });
    }

    private function findGroups(ConsoleCommandGroup|null $parent): array
    {
        $groups = [];

        foreach (get_declared_classes() as $className) {
            $class = new \ReflectionClass($className);

            if (!$class->implementsInterface(ConsoleCommandGroup::class)) {
                continue;
            }

            /** @var ConsoleCommandGroup $group */
            $group = service($className);

            if ($group->parent() === $parent) {
                $groups[] = $group;
            }
        }

        return $groups;
    }

    /** @return ConsoleCommand[] */
    public function getProcessors(ConsoleCommandGroup $parent): array
    {
        return $this->cache->get([$this::class, 'getProcessors', $parent::class], function () use ($parent) {
            return $this->findProcessors($parent);
        }

        );
    }

    /** @return ConsoleCommand[] */
    private function findProcessors(ConsoleCommandGroup $parent): array
    {
        $processors = [];
        foreach (get_declared_classes() as $className) {
            $class = new \ReflectionClass($className);

            if (!$class->implementsInterface(ConsoleCommand::class)) {
                continue;
            }

            /** @var ConsoleCommand $processor */
            $processor = service($className);

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

        foreach (get_declared_classes() as $className) {
            $class = new \ReflectionClass($className);

            if ($class->isAbstract()) {
                continue;
            }

            if (!$class->implementsInterface(ConsoleCommand::class)) {
                continue;
            }

            $processors[] = service($className);
        }

        return $processors;
    }
}
