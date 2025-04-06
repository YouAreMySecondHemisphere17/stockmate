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

        Category::factory()->count(10)->create();
        Vendor::factory()->count(30)->create();
        Product::factory()->count(50)->create();
        Customer::factory()->count(30)->create();
        Branch::factory()->count(10)->create();
        Company::factory()->count(10)->create();
    }
}
