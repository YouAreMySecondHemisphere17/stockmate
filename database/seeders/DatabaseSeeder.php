<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sell;
use App\Models\User;
use App\Models\Vendor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'derek.cagualuc@ug.edu.ec'],
            [
                'name' => 'Derek',
                'email' => 'derek.cagualuc@ug.edu.ec',
                'password' => bcrypt('12345678'),
            ]
        );

        Category::factory()->count(5)->create();
        Vendor::factory()->count(10)->create();
        Product::factory()->count(14)->create();
        Customer::factory()->count(20)->create();
        Branch::factory()->count(9)->create();
        Company::factory()->count(3)->create();
    }
}
