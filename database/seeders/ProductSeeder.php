<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Define categories
        $categories = Category::pluck('id');

        // Define users who are sellers (assuming you have this role logic implemented)
        $sellers = User::role('seller')->pluck('id');

        // Seed products
        for ($i = 0; $i < 20; $i++) {
            $category = $categories->random();
            $seller = $sellers->random();

            $product = Product::create([
                'user_id' => $seller,
                'category_id' => $category,
                'name' => $faker->sentence(3),
                'slug' => \Illuminate\Support\Str::slug($faker->sentence(3)),
                'description' => $faker->paragraph(),
                'price' => $faker->randomNumber(4),
                'stock' => $faker->numberBetween(10, 100),
                'material' => $faker->word,
                'color' => $faker->safeColorName,
                'size' => $faker->randomElement(['S', 'M', 'L', 'XL']),
                'pattern' => $faker->word,
                'ecommerce_link' => $faker->url,
                'status' => $faker->boolean(90), // 90% chance of true (verified)
                'is_verified' => $faker->boolean(80), // 80% chance of true (verified)
            ]);

            // Seed product images
            for ($j = 0; $j < 3; $j++) {
                $imagePath = 'public/product_images/' . $faker->image('public/storage/product_images', 640, 480, null, false);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => Storage::url($imagePath),
                ]);
            }

            // Seed product variants
            for ($k = 0; $k < 2; $k++) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $faker->word,
                    'variant_value' => $faker->word,
                    'price' => $faker->randomNumber(4),
                    'stock' => $faker->numberBetween(5, 50),
                ]);
            }
        }
    }
}
