<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create categories
        Category::factory()->count(10)->create()->each(function ($category) use ($faker) {
            // Generate an image if the category doesn't have one
            if (!$category->image) {
                $imagePath = $faker->image(storage_path('app/public/images/categories'), 640, 480, null, false);
                $imageFile = basename($imagePath);
                $category->update(['image' => "images/categories/{$imageFile}"]);
            }
        });
    }
}
