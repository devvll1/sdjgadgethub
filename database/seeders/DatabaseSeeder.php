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
    Gender::factory()->create(['gender' => 'Male']);
    Gender::factory()->create(['gender' => 'Female']);

    User::factory()->create();

    Category::factory()->create(['category_name' => 'Phones']); 
    Category::factory()->create(['category_name' => 'Laptops']);
    Category::factory()->create(['category_name' => 'Watch']);
    Category::factory()->create(['category_name' => 'Tablets']);

    Product::factory()->create([
        'name' => 'HUAWEI MatePad Pro',
        'description' => '12.6" OLED FullView Display Kirin 9000E Chipset',
        'price'=> '55999',
        'stock_quantity'=> '100',
        'category_id'=> '4'
    ]);

    Product::factory()->create([
        'name' => 'Dell XPS 13',
        'description' => '13.4" FHD+ Display, Intel Core i7-1185G7',
        'price'=> '99999',
        'stock_quantity'=> '100',
        'category_id'=> '2'
    ]);

    Product::factory()->create([
        'name' => 'MacBook Pro 16-inch',
        'description' => '16" Retina Display, M1 Pro Chip, 16GB RAM, 1TB SSD',
        'price'=> '239999',
        'stock_quantity'=> '100',
        'category_id'=> '2'
    ]);

    Product::factory()->create([
        'name' => 'Samsung Galaxy Watch 4',
        'description' => '40mm, GPS, Bluetooth, Black',
        'price'=> '24999',
        'stock_quantity'=> '100',
        'category_id'=> '3'
    ]);
    
    }
}
