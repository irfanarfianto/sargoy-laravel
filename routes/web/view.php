<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductReviewController;


Route::get('profile-saya', function () {
    return 'Route works!';
})->name('profile.page');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.page')->middleware('record.visit');
Route::get('products', [ProductController::class, 'publicIndex'])->name('product.page');
Route::get('products/{slug}', [ProductController::class, 'detailProduct'])
    ->name('product.detail')
    ->middleware('record.product.view');
Route::get('products/load-more', [ProductController::class, 'loadMore'])->name('product.loadMore');
Route::get('search', [SearchController::class, 'index'])->name('search');

Route::get('faqs', [FAQController::class, 'publicIndex'])->name('faqs.page');
Route::get('blogs', [BlogPostController::class, 'publicIndex'])->name('blogs.page');
Route::get('blogs/{slug}', [BlogPostController::class, 'show'])->name('blogs.show');
Route::get('kategori/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('profile-saya', [ProfileController::class, 'publicIndex'])->name('profile.page');
    Route::post('products/{product}/review', [ProductController::class, 'storeReview'])->name('product.review.store');
    Route::get('notifications', [NotificationController::class, 'index'])->name('pesan');
});

Route::get('/foo', function () {
    Artisan::call('storage:link');
});

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect('/');
});
