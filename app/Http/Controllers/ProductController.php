<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
}
