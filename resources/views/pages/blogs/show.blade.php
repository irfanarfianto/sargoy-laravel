<x-app-layout>
    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('Detail Blog') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>

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
                @if ($post)
                    <img class="aspect-video rounded-lg object-cover mb-4"
                        src="{{ asset(str_replace('public', 'storage', $post->cover)) ?? 'https://placehold.co/400' }}"
                        alt="{{ $post->title }}" loading="lazy" />
                    <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-600 text-xs mb-2">By: {{ $post->author }}</p>
                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('blogs.edit', $post->slug) }}" class="link link-primary link-hover">Edit
                            Blog</a>
                    @endif
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
                @endif


            </div>
            <!-- Recommended Blogs Section -->
            <div class="lg:w-1/4 lg:ml-8 mt-8 lg:mt-0">
                <h2 class="text-xl font-semibold">Recommended Blogs</h2>
                <div class="grid grid-cols-1 gap-6 mt-4">
                    @forelse ($recommendedPosts as $post)
                        <div class="flex flex-row h-24 overflow-hidden hover:bg-neutral-200 rounded-lg">
                            <a href="{{ route('blogs.show', $post->slug) }}" class="p-2">
                                <img class="h-full min-w-24 max-w-24 rounded-lg object-cover"
                                    src="{{ asset(str_replace('public', 'storage', $post->cover)) ?? 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                            </a>
                            <div class="p-4 flex flex-col">
                                <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                <h5 class="text-md line-clamp-2">
                                    <a href="{{ route('blogs.show', $post->slug) }}"
                                        class="text-black hover:underline">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Tidak ada rekomendasi blog saat ini.</p>
                    @endforelse
                </div>
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
        <x-banner />
    </div>
</x-app-layout>
