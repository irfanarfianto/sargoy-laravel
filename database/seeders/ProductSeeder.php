<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use GuzzleHttp\Client;

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
        $client = new Client();

        // Define categories
        $categories = Category::pluck('id');
        if ($categories->isEmpty()) {
            // Handle case when categories are empty
            $this->command->info('No categories found. Please create categories first.');
            return;
        }

        // Define users who are sellers (assuming you have this role logic implemented)
        $sellers = User::role('seller')->pluck('id');
        if ($sellers->isEmpty()) {
            // Handle case when sellers are empty
            $this->command->info('No sellers found. Please create sellers first.');
            return;
        }

        // Unsplash API configuration
        $unsplashAccessKey = 'iRn6hoVxynx1gNiRLmIaNy8Q4AgjTh_LXX9LPgKbntQ';
        $unsplashBaseUrl = 'https://api.unsplash.com/photos/random';
        $unsplashParams = [
            'client_id' => $unsplashAccessKey,
            'query' => 'fashion', // example query to get fashion-related images
            'orientation' => 'landscape', // optional: set image orientation
            'count' => 3, // number of images to retrieve
            'w' => 640, // width of the image
            'h' => 480, // height of the image
        ];

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
                'material' => $faker->word,
                'color' => $faker->safeColorName,
                'size' => $faker->randomElement(['S', 'M', 'L', 'XL']),
                'pattern' => $faker->word,
                'ecommerce_link' => $faker->url,
                'status' => $faker->boolean(90), // 90% chance of true (verified)
                'is_verified' => $faker->boolean(80), // 80% chance of true (verified)
            ]);

            // Seed product images from Unsplash API
            $response = $client->request('GET', $unsplashBaseUrl, [
                'query' => $unsplashParams,
            ]);
            $images = json_decode($response->getBody()->getContents(), true);

            foreach ($images as $index => $image) {
                $imagePath = 'public/product_images/' . $product->id . '_image_' . $index . '.jpg';
                $imageContent = file_get_contents($image['urls']['regular']);
                Storage::put($imagePath, $imageContent);

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
                ]);
            }
        }
    }
}
