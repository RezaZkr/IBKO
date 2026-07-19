<?php

namespace Modules\Attribute\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attribute\Enums\AttributeSelectTypeEnum;
use Modules\Attribute\Models\Attribute;
use Modules\General\Enums\BooleanEnum;

class AttributeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'        => 'رنگ',
                'select_type' => AttributeSelectTypeEnum::RadioButton,
                'filterable'  => BooleanEnum::ACTIVE,
                'values'      => [
                    [
                        'name'  => 'قرمز',
                        'value' => '#fc2c03'
                    ], [
                        'name'  => 'سبز',
                        'value' => '#03fc84'
                    ], [
                        'name'  => 'آبی',
                        'value' => '#03a9fc'
                    ]
                ]
            ],
            [
                'name'        => 'جنس',
                'select_type' => AttributeSelectTypeEnum::Select,
                'filterable'  => BooleanEnum::ACTIVE,
                'values'      => [
                    [
                        'name'  => 'چرم',
                        'value' => 'leather'
                    ],
                    [
                        'name'  => 'کتان',
                        'value' => 'cotton'
                    ],
                    [
                        'name'  => 'پارچه',
                        'value' => 'fabric',
                    ],
                ]
            ],
            [
                'name'        => 'اندازه',
                'select_type' => AttributeSelectTypeEnum::Select,
                'filterable'  => BooleanEnum::ACTIVE,
                'values'      => [
                    [
                        'name'  => 'تک نفره',
                        'value' => '1_seater',
                    ],
                    [
                        'name'  => 'دو نفره',
                        'value' => '2_seater',
                    ],
                    [
                        'name'  => 'سه نفره',
                        'value' => '3_seater',
                    ],
                ]
            ],
        ];
        foreach ($data as $attribute) {
            $model = Attribute::query()->updateOrCreate([
                'name' => $attribute['name']
            ], [
                'select_type' => $attribute['select_type'],
                'filterable'  => $attribute['filterable'],
            ]);
            foreach ($attribute['values'] as $attributeValue) {
                $model->values()->updateOrCreate([
                    'value' => $attributeValue['value']
                ], [
                    'name' => $attributeValue['name'],
                ]);

            }
        }

    }
}
