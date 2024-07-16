<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;

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
            $this->command->info('No categories found. Please create categories first.');
            return;
        }

        // Define users who are sellers (assuming you have this role logic implemented)
        $sellers = User::role('seller')->pluck('id');
        if ($sellers->isEmpty()) {
            $this->command->info('No sellers found. Please create sellers first.');
            return;
        }

        // Unsplash API configuration
        $unsplashAccessKey = 'YOUR_UNSPLASH_CLIENT_ID';
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

            try {
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
            } catch (ClientException $e) {
                if ($e->getCode() == 403) {
                    // Handle rate limit exceeded error
                    // Log the error or show a message to the user
                    Log::error('Unsplash API rate limit exceeded: ' . $e->getMessage());
                    // Since seeding is not critical for the application, continue with remaining seeds
                    continue;
                } else {
                    // Handle other client exceptions
                    Log::error('Error fetching images from Unsplash: ' . $e->getMessage());
                    // Optionally throw or log an error for further investigation
                    continue;
                }
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
