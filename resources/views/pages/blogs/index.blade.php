<x-app-layout>
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
                        <div class="flex flex-col overflow-hidden hover:bg-neutral-200 rounded-lg">
                            <a href="{{ route('blogs.show', $post->slug) }}" class="p-4 ">
                                <img class="h-48 w-full rounded-lg object-cover"
                                    src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
                                    alt="{{ $post->title }}" loading="lazy" />
                            </a>
                            <div class="p-4 flex flex-col justify-between">
                                <div>
                                    <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
                                    <h2 class="text-lg font-bold">
                                        <a href="{{ route('blogs.show', $post->slug) }}"
                                            class="text-black hover:underline">
                                            {{ Str::limit($post->title, 50) }}
                                        </a>
                                    </h2>
                                    <p class="text-gray-600">{!! Str::limit($post->content, 100) !!}</p>
                                </div>
                                <div class="flex flex-row items-center mt-4">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ $post->author->avatar ?? 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg' }}"
                                        alt="{{ $post->author }}" loading="lazy">
                                    <div class="ml-2 text-sm">
                                        <p class="text-gray-800">{{ $post->author }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    src="{{ $post->cover ? asset('storage/blog_images/' . $post->cover) : 'https://placehold.co/400' }}"
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
                    <form action="{{ route('blogs.page') }}" method="GET">
                        <label for="tags" class="text-xl font-semibold mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($uniqueTags as $tag)
                                <button type="submit" name="tags" value="{{ $tag }}"
                                    class="btn btn-sm btn-ghost">#{{ $tag }}</button>
                            @endforeach

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="relative py-10 overflow-hidden bg-black sm:py-16 rounded-xl">
            <div class="absolute inset-0">
                <img class="object-cover w-full h-full lg:object-bottom md:object-left md:scale-150 md:origin-top-left"
                    src="images/banner.png" alt="" />
            </div>

            <div class="absolute inset-0 hidden bg-gradient-to-r md:block from-black to-transparent"></div>

            <div class="absolute inset-0 block bg-black/60 md:hidden"></div>

            <div class="relative px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl flex items-center">
                <div class="text-center md:w-2/3 lg:w-1/2 xl:w-1/2 md:text-left">
                    <h2 class="text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">Gabung Sebagai
                        Seller
                        Sarung Goyor</h2>
                    <p class="mt-4 text-base text-gray-200">Dapatkan akses eksklusif untuk menjual dan mempromosikan
                        sarung
                        goyor khas Desa Wanarejan Utara. Bergabunglah dengan komunitas kami dan dapatkan manfaatnya!</p>

                    <form action="{{ route('register') }}" method="GET" class="mt-8 lg:mt-12">
                        <button class="btn btn-primary">
                            Daftar Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>



    </div>
</x-app-layout>
