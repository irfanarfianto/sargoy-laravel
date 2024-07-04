<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $sortBy = $request->get('sort_by', 'latest');

        // Query to fetch product reviews based on the logged-in user's products, with eager loading
        $reviewsQuery = ProductReview::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('product', 'user');

        // Sorting criteria
        switch ($sortBy) {
            case 'oldest':
                $reviewsQuery->oldest();
                break;
            case 'highest_rating':
                $reviewsQuery->orderBy('rating', 'desc');
                break;
            case 'lowest_rating':
                $reviewsQuery->orderBy('rating', 'asc');
                break;
            case 'latest':
            default:
                $reviewsQuery->latest();
                break;
        }

        // Get the reviews and group them by product_id
        $reviews = $reviewsQuery->get();
        $productReviews = $reviews->groupBy('product_id')->map(function ($productReviews) {
            $totalReviews = $productReviews->count();
            $totalRatings = $productReviews->sum('rating');
            $averageRating = $totalReviews > 0 ? round($totalRatings / $totalReviews, 1) : 0;

            $reviewsForProduct = $productReviews->map(function ($review) {
                return [
                    'user' => $review->user,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            });

            return [
                'product' => $productReviews->first()->product,
                'review_count' => $totalReviews,
                'average_rating' => $averageRating, 'reviews' => $reviewsForProduct,
                'created_at' => $productReviews->first()->created_at, 'ratings' => $productReviews->pluck('rating')->toArray(),
            ];
        });

        // Pagination (assuming 10 items per page)
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $offset = ($currentPage - 1) * $perPage;
        $pagedProductReviews = $productReviews->slice($offset, $perPage)->all();
        $productReviews = new LengthAwarePaginator($pagedProductReviews, $productReviews->count(), $perPage, $currentPage, [
            'path' => route('reviews.index', ['sort_by' => $sortBy]),
            'query' => $request->query(),
        ]);

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'Product Reviews'],
        ];

        return view('dashboard.product_reviews.index', compact('productReviews', 'breadcrumbItems', 'sortBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Logic to show create form
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        ProductReview::create($request->all());

        return redirect()->route('reviews.index')
            ->with('success', 'Review added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReview $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReview $review)
    {
        // Logic to show edit form
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductReview $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->all());

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductReview  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReview $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
