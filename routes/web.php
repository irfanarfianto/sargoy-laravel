<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
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
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

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
Route::get('{slug}', [CategoryController::class, 'show'])->name('categories.show');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('profile-saya', [ProfileController::class, 'publicIndex'])->name('profile.page');


Route::get('/send-announcement', [NotificationController::class, 'sendAnnouncement']);
Route::get('/send-alert', [NotificationController::class, 'sendAlert']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/products/{product}/review', [ProductController::class, 'storeReview'])->name('product.review.store');

    // Routes for non-admin and non-seller users (default prefix 'dashboard')
    Route::prefix('dashboard')->group(function () {

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::middleware('role:admin')->group(function () {
            Route::get('admin', [AdminController::class, 'index'])->name('admin');
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

        Route::middleware('role:seller')->group(function () {
            Route::get('seller', [SellerController::class, 'index'])->name('seller');
        });

        Route::middleware('role:seller|admin')->group(function () {
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

    Route::get('notifications', [NotificationController::class, 'index'])->name('pesan');
});



require __DIR__ . '/auth.php';
Route::fallback(function () {
    return redirect('/');
});
