<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(RolePermissionSeeder::class);
        // $this->call(UserSeeder::class);

        // Product::factory()->count(10)->create()->each(function ($product) {
        //     $product->variants()->saveMany(ProductVariant::factory()->count(3)->make());
        //     $product->images()->saveMany(ProductImage::factory()->count(3)->make());
        // });

        User::factory()->count(1000)->create();
    }
}
