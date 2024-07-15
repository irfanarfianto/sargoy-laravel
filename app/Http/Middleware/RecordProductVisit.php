<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordProductVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil produk berdasarkan slug
        $product = Product::where('slug', $request->route('slug'))->first();

        if ($product) {
            // Tambahkan logic untuk merekam akses ke $product->views_count
            $product->increment('views_count');
        }

        return $next($request);
    }
}
