<x-app-layout>
    <div class="mt-8 text-2xl">
        {{ __('Blogs') }}
    </div>

    <div class="mt-6 text-gray-500">
        <div class="flex flex-col lg:flex-row">
            <!-- All Blogs Section -->
            <div class="flex-1">
                <h2 class="text-xl font-semibold">Semua Blog</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @forelse ($posts as $post)
                        <a href="{{ route('blogs.show', $post->slug) }}">
                            <div class="flex flex-col overflow-hidden">
                                <img class="h-48 w-full rounded-lg object-cover"
                                    src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                                <div class="p-4 flex flex-col justify-between">
                                    <div>
                                        <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                        <h2 class="text-lg font-bold">{{ Str::limit($post->title, 50) }}</h2>
                                        <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            src="{{ $post->author->avatar ?? 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg' }}"
                                            alt="{{ $post->author }}" loading="lazy">
                                        <div class="ml-2 text-sm">
                                            <p class="text-gray-800">{{ $post->author }}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="p-4">
                                    <ul class="flex flex-wrap">
                                        @foreach ($post->tags as $tag)
                                            <li
                                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                {{ $tag }}</li>
                                        @endforeach
                                    </ul>
                                </div> --}}
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">Tidak ada blog yang tersedia.</p>
                    @endforelse
                </div>
                <div class="mt-6">
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
            </div>

            <!-- Recommended Blogs Section -->
            <div class="lg:w-1/4 lg:ml-8 mt-8 lg:mt-0">
                <h2 class="text-xl font-semibold">Rekomendasi</h2>
                <div class="grid grid-cols-1 gap-6 mt-4">
                    @forelse ($recommendedPosts as $post)
                        <a href="{{ route('blogs.show', $post->slug) }}">
                            <div class="flex flex-row h-28 overflow-hidden">
                                <img class="w-28 rounded-lg object-cover"
                                    src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                                <div class="p-4 flex flex-col justify-between">
                                    <div>
                                        <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                        <h2 class="text-lg font-bold">{{ $post->title }}</h2>
                                        <p class="text-gray-600">{{ Str::limit($post->content, 20) }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-600">Tidak ada rekomendasi blog saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
