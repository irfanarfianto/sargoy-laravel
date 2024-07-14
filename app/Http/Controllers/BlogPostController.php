<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function publicIndex(Request $request)
    {
        try {
            $query = BlogPost::orderBy('created_at', 'desc');

            // Get frequently used tags from database
            $frequentlyUsedTags = BlogPost::select('tags')
                ->whereNotNull('tags')
                ->pluck('tags')
                ->map(function ($item, $key) {
                    return json_decode($item, true);
                })
                ->flatten(1)
                ->groupBy(function ($tag) {
                    return $tag;
                })
                ->map(function ($tags, $key) {
                    return count($tags);
                })
                ->sortDesc()
                ->keys()
                ->take(10) // Ambil 10 tags yang paling sering digunakan
                ->toArray();

            // Handle tag filter
            $selectedTag = null;
            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->tags));
                foreach ($tags as $tag) {
                    $query->whereJsonContains('tags', $tag);
                }
                $selectedTag = implode(', ', $tags);
            }

            $posts = $query->paginate(9);
            $recommendedPosts = BlogPost::where('recommended', true)
                ->inRandomOrder()
                ->limit(5)
                ->get();

            return view('pages.blogs.index', compact('posts', 'recommendedPosts', 'frequentlyUsedTags', 'selectedTag'));
        } catch (\Exception $e) {
            Log::error('Error fetching blog posts: ' . $e->getMessage());
            flash()->error('An error occurred while fetching blog posts.');
            return redirect()->route('home.page');
        }
    }




    public function show($slug, Request $request)
    {
        try {
            $post = BlogPost::where('slug', $slug)->firstOrFail();

            // Get frequently used tags from database
            $frequentlyUsedTags = BlogPost::select('tags')
                ->whereNotNull('tags')
                ->pluck('tags')
                ->map(function ($item, $key) {
                    return json_decode($item, true);
                })
                ->flatten(1)
                ->groupBy(function ($tag) {
                    return $tag;
                })
                ->map(function ($tags, $key) {
                    return count($tags);
                })
                ->sortDesc()
                ->keys()
                ->take(10) // Ambil 10 tags yang paling sering digunakan
                ->toArray();

            // Handle tag filter
            $selectedTags = [];
            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->tags));
                foreach ($tags as $tag) {
                    if ($post->tags && in_array($tag, $post->tags)) {
                        $selectedTags[] = $tag;
                    }
                }
            }

            $recommendedPosts = BlogPost::where('recommended', true)
                ->where('id', '!=', $post->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $breadcrumbItems = [
                ['name' => 'Beranda', 'url' => route('home.page')],
                ['name' => 'Blogs', 'url' => route('blogs.page')],
                ['name' => Str::limit($post->title, 30)]
            ];

            return view('pages.blogs.show', compact('post', 'recommendedPosts', 'breadcrumbItems', 'selectedTags', 'frequentlyUsedTags'));
        } catch (ModelNotFoundException $e) {
            Log::error('Blog post not found for slug: ' . $slug);
            flash()->error('Blog post not found.');
            return redirect()->route('home.page');
        } catch (\Exception $e) {
            Log::error('Error fetching blog post: ' . $e->getMessage());
            flash()->error('An error occurred while fetching blog post.');
            return redirect()->route('home.page');
        }
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
            'tags' => 'nullable|string',
        ]);

        // Check if the title already exists
        $existingPost = BlogPost::where('title', $validatedData['title'])->first();
        if ($existingPost) {
            flash()->error('Blog post with this title already exists.');
            return redirect()->back()->withInput();
        }

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

        // Mengelola tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $validatedData['tags'])); // Pisahkan string tags menjadi array
            $post->tags = json_encode($tags); // Simpan tags sebagai JSON string
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
            'tags' => 'nullable|string',
        ]);

        try {
            $post = BlogPost::where('slug', $slug)->firstOrFail();

            // Check if the title already exists for a different post
            $existingPost = BlogPost::where('title', $request->title)
                ->where('id', '!=', $post->id)
                ->first();
            if ($existingPost) {
                flash()->error('Blog post with this title already exists.');
                return redirect()->back()->withInput();
            }

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

            // Mengelola tags
            if ($request->filled('tags')) {
                $tags = array_map('trim', explode(',', $request->tags)); // Pisahkan string tags menjadi array
                $post->tags = json_encode($tags); // Simpan tags sebagai JSON string
            }

            $post->save();

            flash()->success('Blog post updated successfully.');
            return redirect()->route('blogs.index');
        } catch (ModelNotFoundException $e) {
            Log::error('Blog post not found for slug: ' . $slug);
            flash()->error('Blog post not found.');
            return redirect()->route('blogs.index');
        } catch (\Exception $e) {
            Log::error('Error updating blog post: ' . $e->getMessage());
            flash()->error('An error occurred while updating blog post.');
            return redirect()->route('blogs.index');
        }
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

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->storeAs('public/blog_images', $fileName);

            $url = asset('storage/blog_images/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
}
