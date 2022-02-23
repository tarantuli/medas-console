<?php

declare(strict_types=1);

namespace Medas\Console\Commands;

use Medas\ServiceManager\Attributes\Service;
use Medas\ServiceManager\Interfaces\Cache;

#[Service]
class ProcessorRepository
{
    private array $groups;
    private array $processors;

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
        if (!isset($this->groups)) {
            $groupNames = $this->cache->get([$this::class, 'getAllGroupNames'], function () {
                return $this->findAllGroupNames();
            });

            $this->groups = [];

            foreach ($groupNames as $groupName) {
                $this->groups[] = service($groupName);
            }
        }

        return $this->groups;
    }

    /** @return string[] */
    private function findAllGroupNames(): array
    {
        $groupNames = [];

        foreach (sm()->getServiceClassNames() as $className) {
            $class = new \ReflectionClass($className);

            if (!$class->implementsInterface(ConsoleCommandGroup::class)) {
                continue;
            }

            $groupNames[] = $className;
        }

        return $groupNames;
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
        if (!isset($this->processors)) {
            $processorNames = $this->cache->get([$this::class, 'getAllProcessorNames'], function () {
                return $this->findAllProcessorNames();
            });

            $this->processors = [];

            foreach ($processorNames as $processorName) {
                $this->processors[] = service($processorName);
            }
        }

        return $this->processors;
    }

    /** @return string[] */
    private function findAllProcessorNames(): array
    {
        $processorNames = [];

        foreach (sm()->getServiceClassNames() as $className) {
            $class = new \ReflectionClass($className);

            if ($class->isAbstract()) {
                continue;
            }

            if (!$class->implementsInterface(ConsoleCommand::class)) {
                continue;
            }

            $processorNames[] = $className;
        }

        return $processorNames;
    }
}
