<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Customer\Models\Customer;

class CustomerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::query()->updateOrCreate([
            'email' => 'customer1@gmail.com',
        ], [
            'name'     => 'Customer 1',
            'password' => 12345678
        ]);
    }
}
