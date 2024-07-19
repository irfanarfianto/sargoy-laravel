<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $search = $request->get('search');

        // Mengambil semua produk dengan relasi kategori dan gambar
        $query = Product::with('category', 'images');

        // Filter data berdasarkan peran pengguna
        if (auth()->user()->hasRole('seller')) {
            $query->where('user_id', auth()->id());
        }

        // Filter data berdasarkan pencarian
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $query->orderBy($sort, $direction);

        // Ambil data produk dengan pagination
        $products = $query->paginate(10);

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'List Produk'],
        ];

        return view('dashboard.product.index', compact('products', 'breadcrumbItems', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'List Produk', 'url' => route('dashboard.product.index')],
            ['name' => 'Tambah Produk'],
        ];
        return view('dashboard.product.create', compact('categories', 'breadcrumbItems'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'ecommerce_link' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi images perlu diperbaiki
            'variants.*.variant_name' => 'required|string|max:255',
            'variants.*.variant_value' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::create([
                'user_id' => auth()->id(),
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'description' => $validatedData['description'],
                'material' => $validatedData['material'],
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'pattern' => $validatedData['pattern'],
                'ecommerce_link' => $validatedData['ecommerce_link'],
                'status' => false, // Product is not status by default
                'is_verified' => false, // Product is not verified by default
            ]);

            $count = 0;

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($count < 3) {
                        $imagePath = $image->store('public/product_images');

                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => Storage::url($imagePath),
                        ]);

                        $count++;
                    } else {
                        break; // Stop the loop after 3 images
                    }
                }
            }

            if (isset($validatedData['variants'])) {
                foreach ($validatedData['variants'] as $variantData) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_name' => $variantData['variant_name'],
                        'variant_value' => $variantData['variant_value'],
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                    ]);
                }
            }

            DB::commit();
            flash()->success('Product created successfully.');
            return redirect()->route('dashboard.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            flash()->error('Failed to create product: ' . $e->getMessage());
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withInput();
        }
    }


    public function show(Product $product)
    {
        $product->load('category', 'images', 'variants');
        return view('dashboard.product.show', compact('product'));
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $product->load('images', 'variants');

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'List Produk', 'url' => route('dashboard.product.index')],
            ['name' => 'Edit Produk', 'url' => route('dashboard.product.edit', $product->slug)],
            ['name' => implode(' ', array_slice(explode(' ', $product->name), 0, 2)), '...'],
        ];

        return view('dashboard.product.edit', compact('product', 'categories', 'breadcrumbItems'));
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'ecommerce_link' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.id' => 'sometimes|exists:product_variants,id',
            'variants.*.variant_name' => 'required|string|max:255',
            'variants.*.variant_value' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::where('slug', $slug)->firstOrFail();

            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'description' => $validatedData['description'],
                'material' => $validatedData['material'],
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'pattern' => $validatedData['pattern'],
                'ecommerce_link' => $validatedData['ecommerce_link'],
                'status' => $validatedData['status'],
            ]);

            if ($request->hasFile('images')) {
                // Delete old images
                $oldImages = ProductImage::where('product_id', $product->id)->get();
                foreach ($oldImages as $oldImage) {
                    Storage::delete($oldImage->image_url);
                    $oldImage->delete();
                }

                // Save new images
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('public/product_images');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => Storage::url($imagePath),
                    ]);
                }
            }

            // Update variants
            if (isset($validatedData['variants'])) {
                foreach ($validatedData['variants'] as $variantData) {
                    if (isset($variantData['id'])) {
                        // Update existing variant
                        $variant = ProductVariant::findOrFail($variantData['id']);
                        $variant->update([
                            'variant_name' => $variantData['variant_name'],
                            'variant_value' => $variantData['variant_value'],

                        ]);
                    } else {
                        // Create new variant
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_name' => $variantData['variant_name'],
                            'variant_value' => $variantData['variant_value'],

                        ]);
                    }
                }
            }

            DB::commit();
            flash()->success('Product updated successfully.');
            return redirect()->route('dashboard.product.index');
        } catch (Exception $e) {
            DB::rollBack();
            flash()->error('Failed to update product: ' . $e->getMessage());
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput();
        }
    }



    public function destroy($slug)
    {
        DB::beginTransaction();

        try {
            // Ambil produk berdasarkan slug
            $product = Product::where('slug', $slug)->firstOrFail();

            // Hapus semua gambar produk
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                Storage::delete($image->image_url);
                $image->delete();
            }

            // Hapus semua variant produk
            ProductVariant::where('product_id', $product->id)->delete();

            // Hapus produk itu sendiri
            $product->delete();

            DB::commit();

            flash()->success('Product deleted successfully.');
            return redirect()->route('dashboard.product.index');
        } catch (Exception $e) {
            DB::rollBack();

            flash()->error('Failed to delete product: ' . $e->getMessage());
            Log::error('Error deleting product: ' . $e->getMessage());

            return back();
        }
    }


    public function verify(Product $product)
    {
        if (auth()->user()->hasRole('admin')) {
            $product->is_verified = true;
            $product->status = true;
            $product->save();
            flash()->success('Product verified successfully.');
            return redirect()->route('dashboard.product.index');
        } else {
            flash()->error('Unauthorized access.');
            return redirect()->route('dashboard.product.index');
        }
    }


    // user public
    public function publicIndex(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $search = $request->get('search');
        $filter = $request->get('filter', 'populer'); // Default filter is 'terbaru'
        $category = $request->get('category'); // Selected category ID

        // Mengambil semua produk yang sudah diverifikasi dengan relasi kategori dan gambar
        $query = Product::where('is_verified', true)->with('category', 'images', 'reviews');

        // Filter data berdasarkan pencarian
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter berdasarkan kategori yang dipilih
        if ($category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        // Filter berdasarkan yang populer, terbaru, atau rating
        if ($filter === 'populer') {
            $query->orderBy('views_count', 'desc');
        } elseif ($filter === 'rating_tertinggi') {
            $query->withAvg('reviews', 'rating')
                ->orderByDesc('reviews_avg_rating');
        } elseif ($filter === 'rating_terendah') {
            $query->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating');
        } else {
            $query->orderBy($sort, $direction);
        }

        $products = $query->paginate(27);
        foreach ($products as $product) {
            $product->status = 'Sudah Diverifikasi';
        }

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('pages.products.index', compact('products', 'search', 'filter', 'categories', 'category'));
    }

    public function detailProduct($slug, Request $request)
    {
        // Mengambil data produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->load([
            'category',
            'images',
            'variants',
            'reviews' => function ($query) use ($product, $request) {
                // Menentukan urutan berdasarkan permintaan
                if ($request->order === 'highest') {
                    $query->where('product_id', $product->id)
                        ->orderByDesc('rating')
                        ->orderBy('created_at', 'desc');
                } elseif ($request->order === 'lowest') {
                    $query->where('product_id', $product->id)
                        ->orderBy('rating')
                        ->orderBy('created_at', 'desc');
                } else {
                    // Urutan default, berdasarkan yang terbaru
                    $query->where('product_id', $product->id)
                        ->orderBy('created_at', 'desc');
                }
            }
        ]);

        // Ambil penjual dari produk
        $seller = $product->user;

        // Pastikan ada data penjual
        if (!$seller) {
            abort(404, 'Penjual produk tidak ditemukan.');
        }

        // Ambil profil penjual
        $sellerProfile = $seller->sellerProfile;

        // Pastikan ada profil penjual
        if (!$sellerProfile) {
            abort(404, 'Profil penjual tidak ditemukan.');
        }

        // Ambil nomor WhatsApp dari seller_profile
        $whatsappNumber = $sellerProfile->no_wa;

        // Hitung rata-rata rating dan jumlah ulasan
        $ratings = $product->reviews->groupBy('rating')->map->count();
        $totalReviews = $product->reviews->count();
        $averageRating = $totalReviews > 0 ? $product->reviews->avg('rating') : 0;
        $ratingPercentage = $totalReviews > 0 ? ($ratings->sum() / ($totalReviews * 5)) * 100 : 0;

        // Breadcrumb
        $breadcrumbItems = [
            ['name' => 'Beranda', 'url' => route('home.page')],
            ['name' => 'Produk', 'url' => route('product.page')],
            ['name' => 'Detail Produk'],
            ['name' => Str::limit($product->name, 30)],
        ];

        // Produk dengan views_count terendah, kecuali produk yang sedang dibuka
        $leastViewedProducts = Product::where('id', '<>', $product->id)
            ->where('is_verified', true) // Hanya produk yang sudah diverifikasi
            ->where('status', true) // Hanya produk dengan status aktif
            ->orderBy('views_count')
            ->limit(3)
            ->get();

        // Produk dengan views_count tertinggi, kecuali produk yang sedang dibuka
        $mostViewedProducts = Product::where('id', '<>', $product->id)
            ->where('is_verified', true) // Hanya produk yang sudah diverifikasi
            ->where('status', true) // Hanya produk dengan status aktif
            ->orderByDesc('views_count')
            ->limit(1)
            ->get();

        // Produk terbaru (kecuali produk yang sedang dibuka)
        $latestProducts = Product::where('id', '<>', $product->id)
            ->where('is_verified', true) // Hanya produk yang sudah diverifikasi
            ->where('status', true) // Hanya produk dengan status aktif
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();

        // Menggabungkan produk terbaru dengan produk lainnya untuk direkomendasikan
        $recommendedProducts = $leastViewedProducts->merge($mostViewedProducts)->merge($latestProducts);

        // Jika produk yang sedang dibuka ada dalam produk yang direkomendasikan, ganti dengan produk lainnya
        if ($recommendedProducts->contains('id', $product->id)) {
            $replacementProduct = Product::where('id', '<>', $product->id)
                ->orderBy('views_count')
                ->first();

            if ($replacementProduct) {
                $recommendedProducts = $recommendedProducts->reject(function ($item) use ($product) {
                    return $item->id == $product->id;
                });

                $recommendedProducts->push($replacementProduct);
            }
        }

        return view('pages.products.detail', compact('product', 'breadcrumbItems', 'recommendedProducts', 'ratings', 'totalReviews', 'averageRating', 'ratingPercentage', 'whatsappNumber'));
    }




    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new ProductReview();
        $review->product_id = $product->id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
