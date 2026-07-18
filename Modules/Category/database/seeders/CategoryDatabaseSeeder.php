<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'مبل',
                'slug'  => 'مبل',
            ], [
                'title' => 'میز',
                'slug'  => 'میز',
            ], [
                'title' => 'صندلی',
                'slug'  => 'صندلی',
            ], [
                'title' => 'روشنایی',
                'slug'  => 'روشنایی',
            ], [
                'title' => 'تخت',
                'slug'  => 'تخت',
            ],
        ];

        Category::query()->upsert(
            $categories,
            ['slug'],
            ['title'],
        );
    }
}
