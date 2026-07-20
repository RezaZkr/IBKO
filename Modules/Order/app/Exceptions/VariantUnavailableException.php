<?php

namespace Modules\Order\Exceptions;

use Exception;

class VariantUnavailableException extends Exception
{
    public function __construct(public readonly int $variantId)
    {
        parent::__construct("Invalid variant #{$variantId}");
    }
}
