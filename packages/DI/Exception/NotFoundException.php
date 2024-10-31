<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\Exception;

use Reserving_Packages\Psr\NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
