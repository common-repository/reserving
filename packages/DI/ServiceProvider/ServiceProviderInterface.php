<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\ServiceProvider;

use Reserving_Packages\DI\ContainerAwareInterface;

interface ServiceProviderInterface extends ContainerAwareInterface
{
    public function getIdentifier(): string;
    public function provides(string $id): bool;
    public function register(): void;
    public function setIdentifier(string $id): ServiceProviderInterface;
}
