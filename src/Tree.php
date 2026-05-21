<?php

declare(strict_types=1);

namespace Medas\Console;

/**
 * A tree that consists of nodes with labels and children
 */
class Tree implements Printable
{
    public function __construct(
        public mixed    $rootNode,

        /** @param Closure(mixed): Printable|string $label */
        public \Closure $label,

        /** @param Closure(mixed): iterable&\Countable $children */
        public \Closure $children,
    )
    {
    }
}
