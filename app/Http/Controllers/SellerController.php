<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Display the seller dashboard with filtered products and statistics.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Ambil parameter filter dari request
        $filter = $request->get('filter');

        // Default query untuk produk milik pengguna yang sudah diverifikasi
        $productsQuery = Product::where('user_id', $userId)
            ->where('is_verified', true);

        // Inisialisasi variabel untuk hasil produk dan judul halaman
        $products = collect();
        $title = '';

        // Proses filter berdasarkan parameter 'filter'
        switch ($filter) {
            case 'populer':
                $products = $productsQuery->orderByDesc('views_count')->take(5)->get();
                $title = 'Produk Terpopuler Berdasarkan Views Count';
                break;
            case 'ulasan':
                $products = $this->getProductsByMostReviews($userId, 5);
                $title = 'Produk dengan Ulasan Terbanyak yang Rating Tertinggi';
                break;
            default:
                // Default, ambil 5 produk terpopuler berdasarkan views_count
                $products = $productsQuery->orderByDesc('views_count')->take(5)->get();
                $title = 'Produk Terpopuler Berdasarkan Views Count';
                break;
        }

        // Hitung total engagement produk (misalnya jumlah semua views_count)
        $totalEngagement = $productsQuery->sum('views_count');

        // Hitung statistik produk lainnya
        $productCount = $productsQuery->count();

        // Query untuk produk yang belum diverifikasi
        $unverifiedProductsQuery = Product::where('user_id', $userId)
            ->where('is_verified', false);

        $verifiedProductCount = $productsQuery->count();
        $unverifiedProductCount = $unverifiedProductsQuery->count();

        return view('dashboard.seller.index', compact(
            'productCount',
            'verifiedProductCount',
            'unverifiedProductCount',
            'totalEngagement',
            'products',
            'title',
            'filter'
        ));
    }

    /**
     * Get products with most reviews and highest average rating.
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getProductsByMostReviews($userId, $limit)
    {
        return Product::where('user_id', $userId)
            ->where('is_verified', true)
            ->withCount('reviews')
            ->has('reviews')
            ->with(['reviews' => function ($query) {
                $query->orderByDesc('rating');
            }])
            ->get()
            ->sortByDesc(function ($product) {
                return $product->reviews->avg('rating');
            })
            ->take($limit);
    }
}
