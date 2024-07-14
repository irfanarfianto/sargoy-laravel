<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        // Cari produk yang cocok dengan nama, deskripsi, atau kategori
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhereHas('category', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->get();


        // Cari blog post yang cocok dengan judul, konten, atau tags
        $blogPosts = BlogPost::where('title', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->orWhere('tags', 'like', '%' . $query . '%')
            ->get();

        return view('pages.searching.index', [
            'products' => $products,
            'blogPosts' => $blogPosts,
            'query' => $query,
        ]);
    }
}
