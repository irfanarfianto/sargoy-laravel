<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductReviewController;

Route::middleware(['auth', 'verified'])->group(function () {
   Route::prefix('dashboard')->group(function () {
      Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
      Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
      Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

      Route::middleware('role:admin|demo_admin')->group(function () {
         Route::resource('users', UserController::class);
         Route::resource('carousels', CarouselController::class);
         Route::resource('categories', CategoryController::class)->except(['show']);
         Route::resource('blogs', BlogPostController::class)->except(['show']);
         Route::get('/blogs/autocomplete/tags', [BlogPostController::class, 'autocompleteTags'])->name('blogs.autocomplete.tags');
         Route::post('ckeditor/upload', [BlogPostController::class, 'upload'])->name('ckeditor.upload');
         Route::post('blogs/{id}/mark-as-recommended', [BlogPostController::class, 'markAsRecommended'])->name('blogs.markAsRecommended');
         Route::post('blogs/{id}/unmark-as-recommended', [BlogPostController::class, 'unmarkAsRecommended'])->name('blogs.unmarkAsRecommended');
         Route::post('product/{product}/verify', [ProductController::class, 'verify'])->name('product.verify');
         Route::get('/faqs/create', [FAQController::class, 'create'])->name('faqs.create');
         Route::post('/faqs', [FAQController::class, 'store'])->name('faqs.store');
         Route::get('/faqs/{faq}/edit', [FAQController::class, 'edit'])->name('faqs.edit');
         Route::put('/faqs/{faq}', [FAQController::class, 'update'])->name('faqs.update');
         Route::delete('/faqs/{faq}', [FAQController::class, 'destroy'])->name('faqs.destroy');
      });

      Route::middleware('role:admin|demo_admin')->group(function () {
         Route::get('admin', [AdminController::class, 'index'])->name('admin');
      });

      Route::middleware('role:seller|demo_seller')->group(function () {
         Route::get('seller', [SellerController::class, 'index'])->name('seller');
      });

      Route::middleware('role:seller|admin|demo_seller|demo_admin')->group(function () {
         Route::resource('reviews', ProductReviewController::class);
         Route::post('/mark-review-as-read/{review}', [ProductReviewController::class, 'markAsRead'])->name('review.mark-as-read');
         Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.index');
         Route::get('produk', [ProductController::class, 'index'])->name('dashboard.product.index');
         Route::get('produk/tambah', [ProductController::class, 'create'])->name('dashboard.product.tambah');
         Route::post('produk', [ProductController::class, 'store'])->name('dashboard.product.simpan');
         Route::get('produk/edit/{slug}', [ProductController::class, 'edit'])->name('dashboard.product.edit');
         Route::put('produk/{slug}', [ProductController::class, 'update'])->name('dashboard.product.update');
         Route::delete('produk/{slug}', [ProductController::class, 'destroy'])->name('dashboard.product.hapus');
      });
   });
});
