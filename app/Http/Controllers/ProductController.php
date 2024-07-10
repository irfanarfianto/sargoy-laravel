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
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        // Tambahkan badge "Belum Diverifikasi" untuk produk yang belum diverifikasi
        foreach ($products as $product) {
            if (!$product->is_verified) {
                $product->status = 'Belum Diverifikasi';
            } else {
                $product->status = 'Sudah Diverifikasi';
            }
        }

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'Daftar Produk'],
        ];

        return view('dashboard.product.index', compact('products', 'breadcrumbItems', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'Daftar Produk', 'url' => route('dashboard.product.index')],
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
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'ecommerce_link' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'material' => $validatedData['material'],
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'pattern' => $validatedData['pattern'],
                'ecommerce_link' => $validatedData['ecommerce_link'],
                'status' => false, // Product is not status by default
                'is_verified' => false, // Product is not verified by default
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('product_images');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imagePath,
                    ]);
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
            ['name' => 'Daftar Produk', 'url' => route('dashboard.product.index')],
            ['name' => implode(' ', array_slice(explode(' ', $product->name), 0, 2)), '...'],
        ];

        return view('dashboard.product.edit', compact('product', 'categories', 'breadcrumbItems'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'pattern' => 'nullable|string|max:255',
            'ecommerce_link' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants.*.id' => 'sometimes|exists:product_variants,id',
            'variants.*.variant_name' => 'required|string|max:255',
            'variants.*.variant_value' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $product->update([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'material' => $validatedData['material'],
                'color' => $validatedData['color'],
                'size' => $validatedData['size'],
                'pattern' => $validatedData['pattern'],
                'ecommerce_link' => $validatedData['ecommerce_link'],
                'status' => $validatedData['status'] ?? false,
            ]);

            if ($request->hasFile('images')) {
                ProductImage::where('product_id', $product->id)->delete();

                foreach ($request->file('images') as $image) {
                    $imageUrl = $image->store('product_images');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imageUrl,
                    ]);
                }
            }

            if (isset($validatedData['variants'])) {
                foreach ($validatedData['variants'] as $variantData) {
                    if (isset($variantData['id'])) {
                        $variant = ProductVariant::findOrFail($variantData['id']);
                        $variant->update([
                            'variant_name' => $variantData['variant_name'],
                            'variant_value' => $variantData['variant_value'],
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'],
                        ]);
                    } else {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'variant_name' => $variantData['variant_name'],
                            'variant_value' => $variantData['variant_value'],
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'],
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

    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
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
        $filter = $request->get('filter', 'terbaru'); // Default filter is 'terbaru'
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

        $products = $query->paginate(9);
        foreach ($products as $product) {
            $product->status = 'Sudah Diverifikasi';
        }

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('pages.products.index', compact('products', 'search', 'filter', 'categories', 'category'));
    }



    public function detailProduct($slug)
    {
        // Mengambil data produk berdasarkan slug
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->load([
            'category',
            'images',
            'variants',
            'reviews' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);

        // Breadcrumb
        $breadcrumbItems = [
            ['name' => 'Beranda', 'url' => route('home')],
            ['name' => 'Produk', 'url' => route('product.page')],
            ['name' => 'Detail Produk'],
            ['name' => Str::limit($product->name, 30)],
        ];

        // Produk dengan views_count terendah, kecuali produk yang sedang dibuka
        $leastViewedProducts = Product::where('id', '<>', $product->id)
            ->orderBy('views_count')
            ->limit(3)
            ->get();

        // Produk dengan views_count tertinggi, kecuali produk yang sedang dibuka
        $mostViewedProducts = Product::where('id', '<>', $product->id)
            ->orderByDesc('views_count')
            ->limit(1)
            ->get();

        // Menggabungkan kedua kategori produk untuk direkomendasikan
        $recommendedProducts = $leastViewedProducts->merge($mostViewedProducts);

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

        return view('pages.products.detail', compact('product', 'breadcrumbItems', 'recommendedProducts'));
    }



    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
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
