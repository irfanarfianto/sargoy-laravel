<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\FAQw;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $error = null;

        try {
            $faqs = FAQ::paginate(10);
        } catch (\Exception $e) {
            $faqs = collect();
            $error = "An error occurred while fetching the FAQs.";
        }

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'FAQ'],
        ];

        return view('dashboard.faqs.index', compact('faqs', 'breadcrumbItems', 'error'));
    }


    public function create()
    {
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'FAQ'],
        ];
        return view('dashboard.faqs.create', compact('breadcrumbItems'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        FAQ::create($validatedData);

        return redirect()->route('dashboard.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(FAQ $faq)
    {
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'FAQ'],
        ];

        return view('dashboard.faqs.edit', compact('faq', 'breadcrumbItems'));
    }

    public function update(Request $request, FAQ $faq)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update($validatedData);

        return redirect()->route('dashboard.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()->route('dashboard.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
