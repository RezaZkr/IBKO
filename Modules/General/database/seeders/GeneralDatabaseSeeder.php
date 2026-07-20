<?php

namespace Modules\General\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attribute\Database\Seeders\AttributeDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Customer\Database\Seeders\CustomerDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;

class GeneralDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CategoryDatabaseSeeder::class,
            AttributeDatabaseSeeder::class,
            ProductDatabaseSeeder::class,
            CustomerDatabaseSeeder::class,
        ]);
    }
}
