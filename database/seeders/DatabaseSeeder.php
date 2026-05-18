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

    $adminUser = User::updateOrCreate(
        ['username' => 'admin'],
        [
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'gender_id' => 1,
            'password' => 'password123',
            'role' => 'admin',
        ]
    );

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "ADMIN ACCOUNT CREDENTIALS\n";
    echo str_repeat("=", 50) . "\n";
    echo "Email: " . $adminUser->email . "\n";
    echo "Username: " . $adminUser->username . "\n";
    echo "Password: password123\n";
    echo str_repeat("=", 50) . "\n\n";

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
