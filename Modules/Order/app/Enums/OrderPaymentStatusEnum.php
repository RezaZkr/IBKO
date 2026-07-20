<?php

namespace Modules\Order\Enums;

enum OrderPaymentStatusEnum: int
{
    case Unpaid = 1;
    case Paid = 2;
    case Failed = 3;

    public function label(): string
    {
        return trans('order::enum.order_payment_status.' . $this->value);
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }

}
