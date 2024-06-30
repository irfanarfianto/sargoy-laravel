<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class CategoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::all();

        foreach ($categories as $category) {
            if (!$category->image) {
                // Generate a temporary image
                $imagePath = $faker->image(storage_path('app/public/images/categories'), 640, 480, null, false);
                $imageFile = basename($imagePath);
                $category->update(['image' => "images/categories/{$imageFile}"]);
            }
        }
    }
}
