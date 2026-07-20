<?php

namespace Modules\Order\Enums;

enum OrderStatusEnum: int
{
    case Pending = 1;
    case Processing = 2;
    case Shipped = 3;
    case Cancelled = 4;

    public function label(): string
    {
        return trans('order::enum.order_status.' . $this->value);
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }

}
