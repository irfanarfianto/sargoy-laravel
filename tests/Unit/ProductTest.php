<?php
// tests/Unit/ProductTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\ProductReview;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
   use RefreshDatabase;

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_can_create_a_product()
   {
      $product = Product::factory()->create();

      $this->assertDatabaseHas('products', ['id' => $product->id]);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_can_update_a_product()
   {
      $product = Product::factory()->create();
      $product->name = 'Updated Product Name';
      $product->save();

      $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product Name']);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_can_delete_a_product()
   {
      $product = Product::factory()->create();
      $product->delete();

      $this->assertDatabaseMissing('products', ['id' => $product->id]);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_belongs_to_a_category()
   {
      $category = Category::factory()->create();
      $product = Product::factory()->create(['category_id' => $category->id]);

      $this->assertInstanceOf(Category::class, $product->category);
      $this->assertEquals($category->id, $product->category->id);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_has_many_variants()
   {
      $product = Product::factory()->create();
      $variant = ProductVariant::factory()->create(['product_id' => $product->id]);

      $this->assertTrue($product->variants->contains($variant));
      $this->assertEquals(1, $product->variants->count());
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_has_many_images()
   {
      $product = Product::factory()->create();
      $image = ProductImage::factory()->create(['product_id' => $product->id]);

      $this->assertTrue($product->images->contains($image));
      $this->assertEquals(1, $product->images->count());
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_belongs_to_a_user()
   {
      $user = User::factory()->create();
      $product = Product::factory()->create(['user_id' => $user->id]);

      $this->assertInstanceOf(User::class, $product->user);
      $this->assertEquals($user->id, $product->user->id);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_has_many_reviews()
   {
      $product = Product::factory()->create();
      $review = ProductReview::factory()->create(['product_id' => $product->id]);

      $this->assertTrue($product->reviews->contains($review));
      $this->assertEquals(1, $product->reviews->count());
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_can_calculate_average_rating()
   {
      $product = Product::factory()->create();
      ProductReview::factory()->create(['product_id' => $product->id, 'rating' => 4]);
      ProductReview::factory()->create(['product_id' => $product->id, 'rating' => 6]);

      $this->assertEquals(5, $product->average_rating);
   }

   #[\PHPUnit\Framework\Attributes\Test]
   public function it_returns_translated_created_at()
   {
      $product = Product::factory()->create(['created_at' => '2023-01-01 12:00:00']);

      $this->assertEquals('Sunday, 01 January 2023 12:00', $product->created_at);
   }
}
