<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\Argument;

interface ResolvableArgumentInterface extends ArgumentInterface
{
    public function getValue(): string;
}
