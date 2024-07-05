<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = auth()->user();

            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $unverifiedProductCount = Product::where('is_verified', false)->count();
                $view->with('unverifiedProductCount', $unverifiedProductCount);
            }

            if ($user && $user->hasRole(['admin', 'seller'])) {
                // Get products created by the authenticated user
                $userProductIds = Product::where('user_id', $user->id)->pluck('id')->toArray();

                // Count new reviews for the user's products created in the last 7 days
                $newReviewCount = ProductReview::whereIn('product_id', $userProductIds)
                    ->where('created_at', '>', Carbon::now()->subDays(7))
                    ->where('is_read', false) // Only count new reviews
                    ->count();

                $view->with('newReviewCount', $newReviewCount);
            }
        });
    }
}
