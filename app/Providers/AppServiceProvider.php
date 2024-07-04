<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

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
            if (auth()->check() && auth()->user()->hasRole('admin')) {
                $unverifiedProductCount = Product::where('is_verified', false)->count();
                $view->with('unverifiedProductCount', $unverifiedProductCount);
            }
        });
    }
}
