<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gender;
use App\Models\Product;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    // Gender::factory()->create(['gender' => 'Male']);
    // Gender::factory()->create(['gender' => 'Female']);

    // User::factory()->create();

    // Category::factory()->create(['category_name' => 'Phones']); 
    // Category::factory()->create(['category_name' => 'Laptops']);
    // Category::factory()->create(['category_name' => 'Watch']);
    // Category::factory()->create(['category_name' => 'Tablets']);

    Product::factory()->create([
        'name' => 'HUAWEI MatePad Pro',
        'description' => '12.6" OLED FullView Display Kirin 9000E Chipset',
        'price'=> '55999',
        'stock_quantity'=> '100',
        'category_id'=> '4'
    ]); 
    
    }
}
