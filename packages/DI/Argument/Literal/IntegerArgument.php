<?php

declare(strict_types=1);

namespace Reserving_Packages\DI\Argument\Literal;

use Reserving_Packages\DI\Argument\LiteralArgument;

class IntegerArgument extends LiteralArgument
{
    public function __construct(int $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_INT);
    }
}
