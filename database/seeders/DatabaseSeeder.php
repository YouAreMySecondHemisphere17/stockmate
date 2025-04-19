<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Purchase;
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

        Category::factory()->count(20)->create();
        Vendor::factory()->count(20)->create();
        Product::factory()->count(20)->create();
        Customer::factory()->count(20)->create();
        Purchase::factory()->count(50)->create();
    }
}
