<?php

namespace Modules\General\Enums;

enum BooleanEnum: int
{
    /**
     * INACTIVE
     */
    case INACTIVE = 0;

    /**
     * ACTIVE
     */
    case ACTIVE = 1;

    public function label(): string
    {
        return trans('general::enum.boolean.' . $this->value);
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }

}
