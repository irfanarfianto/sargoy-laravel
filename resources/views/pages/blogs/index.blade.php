<x-app-layout>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">
                {{ __('Blogs') }}
            </div>

            <div class="mt-6 text-gray-500">
                <!-- Recommended Blogs Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold">Recommended Blogs</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($recommendedPosts as $post)
                            <div class="card bg-base-100 w-96 shadow-xl">
                                <figure>
                                    <img src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg' }}"
                                        alt="{{ $post->title }}" />
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title">{{ $post->title }}</h2>
                                    <p>{{ Str::limit($post->content, 100) }}</p>
                                    <div class="card-actions justify-end">
                                        <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-primary">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- All Blogs Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold">All Blogs</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($posts as $post)
                            <div class="card bg-base-100 w-96 shadow-xl">
                                <figure>
                                    <img src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg' }}"
                                        alt="{{ $post->title }}" />
                                </figure>
                                <div class="card-body">
                                    <h2 class="card-title">{{ $post->title }}</h2>
                                    <p>{{ Str::limit($post->content, 100) }}</p>
                                    <div class="card-actions justify-end">
                                        <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-primary">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
