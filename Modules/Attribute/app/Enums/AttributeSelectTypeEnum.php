<?php

namespace Modules\Attribute\Enums;

enum AttributeSelectTypeEnum: int
{
    /**
     * RadioButton
     */
    case RadioButton = 1;

    /**
     * Select
     */
    case Select = 2;

    public function label(): string
    {
        return trans('attribute::enum.attribute_select_type.' . $this->value);
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }
}
