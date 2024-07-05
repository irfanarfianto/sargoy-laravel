<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();
        $productCount = $products->count();

        // Ambil 5 produk paling populer berdasarkan views_count
        $productPopuler = Product::where('user_id', Auth::id())
            ->where('is_verified', true)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Hitung total engagement produk
        $totalEngagement = $products->sum('views_count');

        return view('dashboard.seller.index', compact('productCount', 'totalEngagement', 'productPopuler'));
    }
}
