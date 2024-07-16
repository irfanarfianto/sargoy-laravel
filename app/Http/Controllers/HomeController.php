<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\FAQ;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 5 produk terbaru yang sudah terverifikasi
        $newProducts = Product::latest()->where('is_verified', true)->take(5)->get();

        $allProducts = Product::inRandomOrder()->where('is_verified', true)->take(10)->get();

        // Ambil 5 produk unggulan berdasarkan views_count terbanyak yang sudah terverifikasi
        $featuredProducts = Product::where('is_verified', true)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Ambil semua kategori
        $categories = Category::all();

        // Ambil 5 pertanyaan yang sering ditanyakan
        $faqs = FAQ::take(5)->get();

        return view('pages.home.index', compact('newProducts', 'featuredProducts', 'categories', 'faqs', 'allProducts'));
    }
}
