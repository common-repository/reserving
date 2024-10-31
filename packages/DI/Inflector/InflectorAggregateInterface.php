<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\Inflector;

use IteratorAggregate;
use Reserving_Packages\DI\ContainerAwareInterface;

interface InflectorAggregateInterface extends ContainerAwareInterface, IteratorAggregate
{
    public function add(string $type, callable $callback = null): Inflector;
    public function inflect(object $object);
}
