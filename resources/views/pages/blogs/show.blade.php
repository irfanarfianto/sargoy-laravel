<x-app-layout>
    <x-breadcrumb :items="$breadcrumbItems" />
    <div class="mt-8 text-2xl">
        @isset($post)
            {{ $post->title }}
        @else
            Blog tidak ditemukan
        @endisset
    </div>

    <div class="mt-6 text-gray-500">
        <div class="flex flex-col lg:flex-row">
            <div class="flex-1">
                @isset($post)
                    <img class="h-56 w-full rounded-lg object-cover mb-4"
                        src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
                        alt="{{ $post->title }}" loading="lazy" />
                    <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-600 text-xs mb-2">By: {{ $post->author }}</p>
                    <p class="text-gray-600">{!! $post->content !!}</p>
                    @if ($post->tags)
                        @php
                            $tags = json_decode($post->tags);
                        @endphp

                        @foreach ($tags as $tag)
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mt-2">#{{ $tag }}</span>
                        @endforeach
                    @endif
                @else
                    <p>Blog tidak ditemukan.</p>
                @endisset
            </div>
            <!-- Recommended Blogs Section -->
            <div class="lg:w-1/4 lg:ml-8 mt-8 lg:mt-0">
                <h2 class="text-xl font-semibold">Recommended Blogs</h2>
                <div class="grid grid-cols-1 gap-6 mt-4">
                    @forelse ($recommendedPosts as $post)
                        <a href="{{ route('blogs.show', $post->slug) }}">
                            <div class="flex flex-row h-24 overflow-hidden">
                                <img class="w-24 rounded-lg object-cover"
                                    src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                                <div class="p-4 flex flex-col justify-between">
                                    <div>
                                        <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                        <h5 class="font-bold">{!! Str::limit($post->title, 20) !!}</h5>
                                        {{-- <p class="text-gray-600">{!! Str::limit($post->content, 20) !!}</p> --}}
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
