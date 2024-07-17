<x-app-layout>

    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('Blogs') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>

    <div class="mt-8 text-2xl">
        {{ __('Blogs') }}
    </div>

    <div class="mt-6 text-gray-500">
        <div class="flex flex-col lg:flex-row">
            <!-- All Blogs Section -->
            <div class="flex-1">
                <h2 class="text-xl font-semibold">
                    @if ($selectedTag)
                        {{ $posts->total() }} blog ditemukan dengan tag "{{ $selectedTag }}"
                    @else
                        Semua Blog
                    @endif
                </h2>
                {{-- Tags yang dipilih --}}
                @if ($selectedTag)
                    <a href="{{ route('blogs.page') }}" class="btn btn-sm btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                        #{{ $selectedTag }}
                    </a>
                @endif
                {{-- tags yang dipilih --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @forelse ($posts as $post)
                        <x-blog-post :post="$post" />
                    @empty
                        <p class="text-gray-600">Tidak ada blog yang tersedia.</p>
                    @endforelse
                </div>
                <div class="mt-6">
                    {{ $posts->links('vendor.pagination.public') }}
                </div>
            </div>

            <!-- Recommended Blogs Section -->
            <div class="lg:w-1/4 lg:ml-8 mt-8 lg:mt-0">
                <h2 class="text-xl font-semibold">Rekomendasi</h2>
                <div class="grid grid-cols-1 gap-6 mt-4">
                    @forelse ($recommendedPosts as $post)
                        <div class="flex flex-row h-24 overflow-hidden hover:bg-neutral-200 rounded-lg">
                            <a href="{{ route('blogs.show', $post->slug) }}" class="p-2">
                                <img class="h-full  min-w-24 max-w-24 rounded-lg object-cover"
                                    src="{{ str_replace('public', 'storage', $post->cover) ?? 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                            </a>
                            <div class="p-4 flex flex-col">
                                <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                <p class="text-md line-clamp-2">
                                    <a href="{{ route('blogs.show', $post->slug) }}"
                                        class="text-black hover:underline">
                                        {{ $post->title }}
                                    </a>
                                </p>
                            </div>

                        </div>
                    @empty
                        <p class="text-gray-600">Tidak ada rekomendasi blog saat ini.</p>
                    @endforelse
                    <form action="{{ route('blogs.page') }}" method="GET">
                        <label for="tags" class="text-xl font-semibold mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($frequentlyUsedTags as $tag)
                                <button type="submit" name="tags" value="{{ $tag }}"
                                    class="btn btn-sm btn-ghost">#{{ $tag }}</button>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-banner />
    </div>
</x-app-layout>
