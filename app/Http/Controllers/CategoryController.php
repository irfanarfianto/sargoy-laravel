<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            // Get the image file from request
            $imageFile = $request->file('image');

            // Convert image to base64
            $imageData = base64_encode(file_get_contents($imageFile));

            // Set the image path in data to save in database
            $data = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
                'image' => $imageData, // Save image as base64 encoded string
            ];

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
            // Decode base64 image data for display if needed
            // $category->image = base64_decode($category->image);
            $products = $category->products; // Assuming Category has products relationship
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
            // Find the category by slug
            $category = Category::where('slug', $slug)->firstOrFail();

            // Get updated data from request
            $data = [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'description' => $request->input('description'),
            ];

            // Handle image update
            if ($request->hasFile('image')) {
                // Convert image to base64
                $imageFile = $request->file('image');
                $imageData = base64_encode(file_get_contents($imageFile));

                // Update image path in data
                $data['image'] = $imageData;

                // You may want to delete old image data if necessary
                $oldImageData = $category->image;
                unset($category->image);
                Storage::delete($oldImageData); // Delete old image if stored separately
            }

            // Update category with new data
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
            // Find the category by slug
            $category = Category::where('slug', $slug)->firstOrFail();

            // Delete the category
            $category->delete();

            flash()->success('Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            flash()->error('Failed to delete category.');
        }

        return redirect()->route('categories.index');
    }
}
