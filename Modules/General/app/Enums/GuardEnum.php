<?php

namespace Modules\General\Enums;

enum GuardEnum: string
{
    /**
     * CUSTOMER
     */
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return trans('general::enum.guard.' . $this->value);
    }

    public static function customer(): string
    {
        return self::CUSTOMER->value;
    }
}
