<?php

declare(strict_types=1);

namespace Reserving_Packages\DI;

interface ContainerAwareInterface
{
    public function getContainer(): DefinitionContainerInterface;
    public function setContainer(DefinitionContainerInterface $container): ContainerAwareInterface;
}
