<?php

namespace Modules\Order\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(
        public readonly int $variantId,
    )
    {
        parent::__construct("Not enough stock for variant #{$variantId}");
    }
}
