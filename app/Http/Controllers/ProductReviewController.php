<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;
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
        // Ambil id user yang sedang login
        $userId = Auth::id();

        // Mendefinisikan kriteria default
        $sortBy = $request->get('sort_by', 'latest');

        // Query untuk mengambil ulasan produk berdasarkan pemilik produk (user yang login) dengan paginasi
        $reviewsQuery = ProductReview::whereHas('product', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('product', 'user');

        // Menentukan kriteria sorting
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

        // Mendapatkan data ulasan dengan paginasi
        $reviews = $reviewsQuery->paginate(10);

        // Data breadcrumb
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'Produk Review'],
        ];

        // Menambahkan parameter sort_by ke dalam link paginasi
        $reviews->appends(['sort_by' => $sortBy]);

        return view('dashboard.product_reviews.index', compact('reviews', 'breadcrumbItems'));
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
