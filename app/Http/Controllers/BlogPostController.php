<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(10);
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Blogs'],
        ];
        return view('dashboard.blogs.index', compact('posts', 'breadcrumbItems'));
    }

    public function publicIndex()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(6);
        $recommendedPosts = BlogPost::where('recommended', true)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        return view('pages.blogs.index', compact('posts', 'recommendedPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $recommendedPosts = BlogPost::where('recommended', true)
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $breadcrumbItems = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Blogs', 'url' => route('blogs.page')],
            ['name' => Str::limit($post->title, 30)]
        ];
        return view('pages.blogs.show', compact('post', 'recommendedPosts', 'breadcrumbItems'));
    }


    public function create()
    {
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Blogs', 'url' => route('blogs.index')],
            ['name' => 'Create'],
        ];
        return view('dashboard.blogs.create', compact('breadcrumbItems'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan post ke dalam database
        $post = new BlogPost();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->author = $validatedData['author'];

        // Mengelola gambar yang diunggah
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/blog_images', $imageName); // Menyimpan gambar di storage

            // Simpan nama file gambar ke dalam database
            $post->cover = $imageName;
        }

        $post->save();

        flash()->success('Blog post created successfully.');
        return redirect()->route('blogs.index');
    }

    public function edit($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => route('admin')],
            ['name' => 'Blogs', 'url' => route('blogs.index')],
            ['name' => 'Edit'],
        ];
        return view('dashboard.blogs.edit', compact('post', 'breadcrumbItems'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = BlogPost::where('slug', $slug)->firstOrFail();

        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $request->author;

        // Mengelola gambar yang diunggah
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/blog_images', $imageName); // Menyimpan gambar di storage

            // Hapus gambar lama jika ada
            if ($post->cover) {
                Storage::delete('public/blog_images/' . $post->cover);
            }

            // Simpan nama file gambar baru ke dalam database
            $post->cover = $imageName;
        }

        $post->save();

        flash()->success('Blog post updated successfully.');
        return redirect()->route('blogs.index');
    }

    public function destroy($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();

        // Hapus gambar terkait jika ada
        if ($post->cover) {
            Storage::delete('public/blog_images/' . $post->cover);
        }

        $post->delete();

        flash()->success('Blog post deleted successfully.');
        return redirect()->route('blogs.index');
    }


    public function markAsRecommended($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->recommended = true;
        $post->save();

        flash()->success('Blog post marked as recommended.');
        return redirect()->route('blogs.index');
    }

    public function unmarkAsRecommended($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->recommended = false;
        $post->save();

        flash()->success('Blog post unmarked as recommended.');
        return redirect()->route('blogs.index');
    }
}
