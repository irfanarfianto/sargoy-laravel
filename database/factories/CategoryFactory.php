<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = ['sarung', 'fashion', 'aksesories'];
        $name = $this->faker->randomElement($categories);

        // Generate slug with prefix 'kategori-'
        $slug = 'kategori-' . Str::slug($name);

        return [
            'name' => ucfirst($name), // Uppercase the first letter
            'slug' => $slug,
        ];
    }
}
