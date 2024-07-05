<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();
        $users = User::inRandomOrder()->get();

        foreach ($products as $product) {

            $numReviews = rand(1, 20);

            for ($i = 0; $i < $numReviews; $i++) {
                $user = $users->random();
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => rand(1, 5),
                    'comment' => $faker->paragraph(),
                    'is_read' => $faker->boolean(50)
                ]);
            }
        }
    }
}
