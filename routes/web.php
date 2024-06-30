<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/send-announcement', [NotificationController::class, 'sendAnnouncement']);
Route::get('/send-alert', [NotificationController::class, 'sendAlert']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('/faqs/create', [FAQController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [FAQController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [FAQController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [FAQController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FAQController::class, 'destroy'])->name('faqs.destroy');
    });

    Route::middleware('role:seller')->group(function () {
        Route::get('seller', [SellerController::class, 'index'])->name('seller');
    });

    Route::middleware('role:seller|admin')->group(function () {
        Route::resource('reviews', ProductReviewController::class);
        Route::get('/faqs', [FAQController::class, 'index'])->name('faqs.index');

        Route::get('produk', [ProductController::class, 'index'])->name('dashboard.product.index');
        Route::get('produk/tambah', [ProductController::class, 'create'])->name('dashboard.product.tambah');
        Route::post('produk', [ProductController::class, 'store'])->name('dashboard.product.simpan');
        Route::get('produk/edit/{slug}', [ProductController::class, 'edit'])->name('dashboard.product.edit');
        Route::put('produk/{slug}', [ProductController::class, 'update'])->name('dashboard.product.update');
        Route::delete('produk/{slug}', [ProductController::class, 'destroy'])->name('dashboard.product.hapus');
    });

    Route::get('notifications', [NotificationController::class, 'index'])->name('pesan');


    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
Route::fallback(function () {
    return redirect('/');
});
