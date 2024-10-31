<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\Exception;

use Reserving_Packages\Psr\ContainerExceptionInterface;
use RuntimeException;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}
