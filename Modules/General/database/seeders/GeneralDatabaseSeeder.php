<?php

namespace Modules\General\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;

class GeneralDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CategoryDatabaseSeeder::class
        ]);
    }
}
