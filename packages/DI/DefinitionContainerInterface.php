<?php

declare(strict_types=1);

namespace Reserving_Packages\DI;

use Reserving_Packages\DI\Definition\DefinitionInterface;
use Reserving_Packages\DI\Inflector\InflectorInterface;
use Reserving_Packages\DI\ServiceProvider\ServiceProviderInterface;
use Reserving_Packages\Psr\ContainerInterface;

interface DefinitionContainerInterface extends ContainerInterface
{
    public function add(string $id, $concrete = null): DefinitionInterface;
    public function addServiceProvider(ServiceProviderInterface $provider): self;
    public function addShared(string $id, $concrete = null): DefinitionInterface;
    public function extend(string $id): DefinitionInterface;
    public function getNew($id);
    public function inflector(string $type, callable $callback = null): InflectorInterface;
}
