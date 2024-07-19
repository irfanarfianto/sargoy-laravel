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
        $this->call([
            RolePermissionSeeder::class, 
            UserSeeder::class,
            DemoUserSeeder::class,
            CategorySeeder::class,
            AdminProfileSeeder::class,
            ProductSeeder::class,
            ProductReviewSeeder::class,
            SellerProfileSeeder::class,
            VisitorProfileSeeder::class,
            FaqSeeder::class,
            VisitSeeder::class,
            BlogPostSeeder::class
        ]);
    }
}
