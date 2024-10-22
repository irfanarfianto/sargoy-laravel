<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;

        // Unsplash API configuration
        $unsplashAccessKey = 'iRn6hoVxynx1gNiRLmIaNy8Q4AgjTh_LXX9LPgKbntQ';
        $unsplashBaseUrl = 'https://api.unsplash.com/photos/random';
        $unsplashParams = [
            'client_id' => $unsplashAccessKey,
            'query' => 'fashion', // example query to get fashion-related images
            'orientation' => 'landscape', // optional: set image orientation
            'w' => 1200, // width of the image
            'h' => 800, // height of the image
        ];

        // Fetch a random image from Unsplash
        $client = new Client();
        $response = $client->request('GET', $unsplashBaseUrl, [
            'query' => $unsplashParams,
        ]);
        $imageData = json_decode($response->getBody()->getContents(), true);

        // Handle case when there is no valid image data
        if (!$imageData || !isset($imageData['urls']['regular'])) {
            return [];
        }

        // Save the image to storage
        $coverPath = '';
        $imageContent = file_get_contents($imageData['urls']['regular']);
        $coverPath = 'public/blog_images/' . uniqid() . '_image.jpg'; // Generate a unique filename
        Storage::put($coverPath, $imageContent);


        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'author' => $this->faker->name,
            'tags' => json_encode(array_map(
                fn ($tag) => ucwords(strtolower($tag)),
                explode(' ', $this->faker->words(6, true))
            )),
            'cover' => $coverPath,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
