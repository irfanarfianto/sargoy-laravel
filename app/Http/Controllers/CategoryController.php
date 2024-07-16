<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        try {
            $categories = Category::all();
            $breadcrumbItems = [
                ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
                ['name' => 'Category'],
            ];
            return view('dashboard.categories.index', compact('categories', 'breadcrumbItems'));
        } catch (\Exception $e) {
            Log::error('Error displaying categories: ' . $e->getMessage());
            flash()->error('Failed to display categories.');
            return redirect()->back();
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        try {
            return view('dashboard.categories.create');
        } catch (\Exception $e) {
            Log::error('Error showing create form: ' . $e->getMessage());
            flash()->error('Failed to show create form.');
            return redirect()->back();
        }
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $data = $request->only(['name', 'slug', 'description']);

            // Store image to storage
            $fileName = Str::uuid() . '.jpg'; // generate a unique filename
            $imagePath = $request->file('image')->storeAs('public/categories', $fileName);

            // Set image path in data
            $data['image'] = 'public/categories/' . $fileName;

            // Create category
            Category::create($data);
            flash()->success('Category created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            flash()->error('Failed to create category.');
        }

        return redirect()->route('categories.index');
    }

    // Display the specified resource.
    public function show($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            $products = Product::where('category_id', $category->id)->get();
            $breadcrumbItems = [
                ['name' => 'Beranda', 'url' => route('home.page')],
                ['name' => 'Kategori'],
                ['name' => $category->name],
            ];
            return view('pages.categories.show', compact('category', 'products', 'breadcrumbItems'));
        } catch (\Exception $e) {
            Log::error('Error displaying category: ' . $e->getMessage());
            flash()->error('Failed to display category.');
            return redirect()->back();
        }
    }

    // Show the form for editing the specified resource.
    public function edit(Category $category)
    {
        try {
            return view('dashboard.categories.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error('Error showing edit form: ' . $e->getMessage());
            flash()->error('Failed to show edit form.');
            return redirect()->back();
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $slug . ',slug',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $category = Category::where('slug', $slug)->firstOrFail();
            $data = $request->only(['name', 'slug', 'description']);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image && Storage::exists('public/' . $category->image)) {
                    Storage::delete('public/' . $category->image);
                }

                // Store new image
                $fileName = Str::uuid() . '.jpg'; // generate a unique filename
                $imagePath = $request->file('image')->storeAs('public/categories', $fileName);
                $data['image'] = 'categories/' . $fileName;
            }

            $category->update($data);
            flash()->success('Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            flash()->error('Failed to update category.');
        }

        return redirect()->route('categories.index');
    }

    // Remove the specified resource from storage.
    public function destroy($slug)
    {
        try {
            $category = Category::where('slug', $slug)->firstOrFail();

            // Delete category image if exists
            if ($category->image && Storage::exists('public/categories/' . $category->image)) {
                Storage::delete('public/categories/' . $category->image);
            }

            $category->delete();
            flash()->success('Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            flash()->error('Failed to delete category.');
        }

        return redirect()->route('categories.index');
    }
}
