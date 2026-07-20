<?php

namespace Modules\Payment\Enums;

enum PaymentStatusEnum : int
{
    case Pending  = 1;
    case Success  = 2;
    case Failed  = 3;

    public function label(): string
    {
        return trans('payment::enum.payment_status.' . $this->value);
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }}
