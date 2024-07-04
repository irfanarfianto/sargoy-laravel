<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ambil user yang memiliki peran 'seller' atau 'admin'
        $sellerOrAdmin = User::role(['seller'])->get()->random();

        // Ambil ID kategori yang sudah ada dari basis data
        $category = Category::inRandomOrder()->first();

        return [
            'category_id' => $category->id, // Menggunakan factory Category untuk relasi
            'user_id' => $sellerOrAdmin->id,
            'name' => $this->faker->sentence(3), // Nama produk dengan kalimat acak
            'slug' => $this->faker->slug, // Slug produk, bisa digunakan untuk URL
            'description' => $this->faker->paragraph(3), // Deskripsi produk dengan beberapa paragraf acak
            'price' => $this->faker->randomFloat(2, 10, 1000), // Harga produk antara 10 dan 1000
            'stock' => $this->faker->numberBetween(0, 100), // Stok produk antara 0 dan 100
            'material' => $this->faker->word, // Bahan produk dengan kata acak
            'color' => $this->faker->colorName, // Warna produk dengan nama warna acak
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']), // Ukuran produk dengan pilihan acak
            'pattern' => $this->faker->word, // Pola produk dengan kata acak
            'ecommerce_link' => $this->faker->url, // Link e-commerce produk dengan URL acak
            'status' => false, // Default status nonaktif untuk produk baru
            'is_verified' => false, // Default belum diverifikasi untuk produk baru
            'views_count' => rand(1, 1000000), // View count secara acak
        ];
    }
}
