<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 5 produk terbaru
        $newProducts = Product::latest()->take(5)->get();
        // Ambil semua produk secara acak, lalu ambil 10 produk pertama
        $allProducts = Product::inRandomOrder()->take(10)->get();
        // Ambil 5 produk unggulan berdasarkan views_count terbanyak
        $featuredProducts = Product::orderBy('views_count', 'desc')->take(5)->get();

        // Ambil semua kategori
        $categories = Category::all();

        return view('pages.home.index', compact('newProducts', 'featuredProducts', 'allProducts', 'categories'));
    }
}
