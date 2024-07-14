<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
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
        // Generate a random image file for the cover
        $coverPath = 'blog_images/' . $this->faker->image('public/storage/blog_images', 400, 300, null, false);

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
