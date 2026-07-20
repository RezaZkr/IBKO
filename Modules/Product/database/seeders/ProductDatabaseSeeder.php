<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakeImagePath = __DIR__ . '\\fake_img.jpg';
        $fakeVideoPath = __DIR__ . '\\fake_video.mp4';

        $products = [
            [
                'title'       => 'مبل راحتی الیزه',
                'category_id' => 1,
                'description' => 'مبل راحتی با پارچه مخمل و اسکلت چوب راش.',
                'status'      => true,
                'attributes'  => [1, 2, 3],
                'variants'    => [
                    [
                        'sku'              => 'ELZ-001',
                        'price'            => 32500000,
                        'quantity'         => 8,
                        'status'           => true,
                        'attribute_values' => [1, 5, 8]
                    ],
                    [
                        'sku'              => 'ELZ-002',
                        'price'            => 34900000,
                        'quantity'         => 5,
                        'status'           => true,
                        'attribute_values' => [2, 5, 8]
                    ],
                ]
            ],
            [
                'title'       => 'مبل کلاسیک آریا',
                'category_id' => 2,
                'description' => 'مبل کلاسیک با منبت‌کاری ظریف و پارچه شانل.',
                'status'      => true,
                'attributes'  => [1, 2, 3],
                'variants'    => [
                    [
                        'sku'              => 'ARY-001',
                        'price'            => 48500000,
                        'quantity'         => 3,
                        'status'           => true,
                        'attribute_values' => [3, 6, 9]
                    ],
                ]
            ],
            [
                'title'       => 'مبل ال نیکا',
                'category_id' => 3,
                'description' => 'مبل ال مدرن مناسب آپارتمان‌های کوچک.',
                'status'      => true,
                'attributes'  => [1, 2, 3],
                'variants'    => [
                    [
                        'sku'              => 'NIK-001',
                        'price'            => 28900000,
                        'quantity'         => 6,
                        'status'           => true,
                        'attribute_values' => [1, 5, 10]
                    ],
                    [
                        'sku'              => 'NIK-002',
                        'price'            => 31500000,
                        'quantity'         => 4,
                        'status'           => true,
                        'attribute_values' => [3, 6, 9]
                    ],
                ]
            ],
            [
                'title'       => 'مبل چستر ویولت',
                'category_id' => 4,
                'description' => 'مبل چستر با روکش چرم طبیعی و دوخت لمسه.',
                'status'      => true,
                'attributes'  => [1, 2, 3],
                'variants'    => [
                    [
                        'sku'              => 'CHS-001',
                        'price'            => 55900000,
                        'quantity'         => 2,
                        'status'           => true,
                        'attribute_values' => [1, 6, 8]
                    ],
                ]
            ],
            [
                'title'       => 'مبل سلطنتی رویال',
                'category_id' => 5,
                'description' => 'مبل سلطنتی لوکس با چوب گردو و پارچه مخمل.',
                'status'      => true,
                'attributes'  => [1, 2, 3],
                'variants'    => [
                    [
                        'sku'              => 'ROY-001',
                        'price'            => 78000000,
                        'quantity'         => 2,
                        'status'           => true,
                        'attribute_values' => [2, 5, 9]
                    ],
                    [
                        'sku'              => 'ROY-002',
                        'price'            => 84500000,
                        'quantity'         => 1,
                        'status'           => true,
                        'attribute_values' => [2, 7, 8]
                    ],
                ]
            ],
        ];

        foreach ($products as $product) {
            try {
                $model = Product::query()->updateOrCreate([
                    'slug' => Str::slug($product['title']),
                ], [
                    'title'       => $product['title'],
                    'category_id' => $product['category_id'],
                    'description' => $product['description'],
                    'status'      => $product['status'],
                ]);

                $model->attributes()->sync($product['attributes']);
                $model->variants()->forceDelete();

                foreach ($product['variants'] as $variant) {
                    $variantModel = $model->variants()->updateOrCreate([
                        'sku'      => $variant['sku'],
                        'price'    => $variant['price'],
                        'quantity' => $variant['quantity'],
                        'status'   => $variant['status'],
                    ]);

                    $variantModel->attributeValues()->sync($variant['attribute_values']);

                    $variantModel->media()->delete();
                    $variantModel->addMedia($fakeImagePath)
                        ->preservingOriginal()
                        ->usingFileName(Str::random(10) . '.jpg')
                        ->toMediaCollection('images');
                    $variantModel->addMedia($fakeVideoPath)
                        ->preservingOriginal()
                        ->usingFileName(Str::random(10) . '.mp4')
                        ->toMediaCollection('videos');

                }
            } catch (\Throwable $exception) {
                continue;
            }
        }
    }
}
