<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use GuzzleHttp\Client;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $client = new Client();

        // Define categories
        $categories = [
            ['name' => 'Sarung', 'slug' => 'kategori-sarung'],
            ['name' => 'Fashion', 'slug' => 'kategori-fashion'],
            ['name' => 'Aksesoris', 'slug' => 'kategori-aksesoris'],
        ];

        // Unsplash API configuration
        $unsplashAccessKey = 'iRn6hoVxynx1gNiRLmIaNy8Q4AgjTh_LXX9LPgKbntQ';
        $unsplashBaseUrl = 'https://api.unsplash.com/photos/random';
        $unsplashParams = [
            'client_id' => $unsplashAccessKey,
            'query' => 'fashion', // example query to get fashion-related images
            'orientation' => 'landscape', // optional: set image orientation
            'w' => 640, // width of the image
            'h' => 480, // height of the image
        ];

        // Create categories with images from Unsplash API
        foreach ($categories as $categoryData) {
            // Fetch a random image from Unsplash
            $response = $client->request('GET', $unsplashBaseUrl, [
                'query' => $unsplashParams,
            ]);
            $image = json_decode($response->getBody()->getContents(), true);

            // Save the image to storage
            $imagePath = 'public/categories/' . $faker->uuid . '.jpg'; // generate a unique filename
            $imageContent = file_get_contents($image['urls']['regular']);
            Storage::put($imagePath, $imageContent);

            // Create the category with the generated image path
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'image' => $imagePath,
            ]);
        }
    }
}
