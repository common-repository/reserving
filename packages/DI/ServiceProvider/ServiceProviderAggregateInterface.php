<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\ServiceProvider;

use IteratorAggregate;
use Reserving_Packages\DI\ContainerAwareInterface;

interface ServiceProviderAggregateInterface extends ContainerAwareInterface, IteratorAggregate
{
    public function add(ServiceProviderInterface $provider): ServiceProviderAggregateInterface;
    public function provides(string $id): bool;
    public function register(string $service): void;
}
