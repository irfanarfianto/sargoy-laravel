<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::all();
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Carousels'],
        ];
        return view('dashboard.carousels.index', compact('carousels', 'breadcrumbItems'));
    }

    public function create()
    {
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Carousels'],
            ['name' => 'Create'],
        ];
        return view('dashboard.carousels.create', compact('breadcrumbItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_url' => 'required|url',
        ]);

        $imagePath = $request->file('image')->store('public/carousels');

        $carousel = Carousel::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'target_url' => $request->target_url,
        ]);

        flash()->success('Carousel created successfully.');

        return redirect()->route('carousels.index');
    }

    public function edit($id)
    {
        $carousel = Carousel::findOrFail($id);
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Edit'],
        ];
        return view('dashboard.carousels.edit', compact('carousel', 'breadcrumbItems'));
    }

    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_url' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/carousels');
            $carousel->image_path = $imagePath;
        }

        $carousel->title = $request->title;
        $carousel->description = $request->description;
        $carousel->target_url = $request->target_url;
        $carousel->save();

        flash()->success('Carousel updated successfully.');

        return redirect()->route('carousels.index');
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->delete();

        flash()->success('Carousel deleted successfully.');

        return redirect()->route('carousels.index');
    }
}
