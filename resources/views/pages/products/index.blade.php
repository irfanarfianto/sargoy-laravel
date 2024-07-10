<x-app-layout>
    <div class="mt-8 flex flex-wrap justify-between ">
        <h3 class="text-2xl">
            {{ __('Produk') }}
        </h3>
        @if ($search && !$products->isEmpty())
            <h5 class="text-gray-700">
                {{ $products->total() }} {{ __('produk ditemukan, berdasarkan pencarian') }}
                <strong>{{ "'$search'" }}</strong>
            </h5>
        @endif
    </div>
    <div class="mt-6 flex flex-col space-y-3 lg:space-y-0 lg:flex-row">
        <!-- Filter Section -->
        <div class="w-full lg:w-1/4 lg:pr-4">
            <form action="{{ route('product.page') }}" method="GET" class="space-y-4">
                <div class="flex justify-between">
                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <h3 class="">Pencarian</h3>
                    </div>
                    @if ($search || $category)
                        <a href="{{ route('product.page') }}" class="link link-secondary">reset</a>
                    @endif
                </div>

                <input type="text" name="search" placeholder="Cari produk..." value="{{ $search }}"
                    class="input input-bordered w-full" />

                <div class="hidden lg:block lg:space-y-5">
                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                        </svg>
                        <h3 class="">Urutkan</h3>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="submit" name="filter" value="terbaru"
                            class="btn btn-sm {{ $filter == 'terbaru' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'terbaru')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Terbaru
                        </button>
                        <button type="submit" name="filter" value="rating_tertinggi"
                            class="btn btn-sm {{ $filter == 'rating_tertinggi' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'rating_tertinggi')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Rating Tertinggi
                        </button>
                        <button type="submit" name="filter" value="populer"
                            class="btn btn-sm {{ $filter == 'populer' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'populer')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Populer
                        </button>
                    </div>


                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                        <h3 class="">Kategori</h3>
                    </div>
                    <div>
                        @foreach ($categories as $cat)
                            <a href="{{ route('product.page', ['category' => $cat->slug, 'search' => $search, 'filter' => $filter]) }}"
                                class="btn btn-ghost btn-sm {{ $category === $cat->slug ? 'btn-primary' : '' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                        <a href="{{ route('product.page', ['search' => $search, 'filter' => $filter]) }}"
                            class="btn btn-ghost btn-sm  {{ $category === null ? 'btn-primary' : '' }}">
                            Semua Kategori
                        </a>
                    </div>
                </div>
            </form>
        </div>
        @include('pages.products.partials.sorting')
        <!-- Products Section -->
        <div class="w-full lg:w-3/4">
            @if ($products->isEmpty())
                <div role="alert" class="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>

                    <span>{{ __('Tidak ada produk yang ditemukan.') }}</span>
                    <div>
                        <a href="{{ route('product.page') }}">
                            <button class="btn btn-sm btn-ghost">Lihat Semua Produk</button>
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white overflow-hidden">
                            <div class="relative overflow-hidden h-60 rounded-lg">
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <img class="object-cover w-full h-full"
                                        src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                                        loading="lazy" alt="{{ $product->name }}" />
                                </a>
                            </div>
                            <div class="px-4 py-4">
                                <div class="rating">
                                    @php
                                        $rating = $product->average_rating;
                                        $maxRating = 5;
                                        $filledStars = intval($rating);
                                        $emptyStars = $maxRating - $filledStars;
                                    @endphp

                                    @for ($i = 0; $i < $filledStars; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6 text-orange-400">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endfor

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-6 text-gray-300">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endfor
                                </div>
                                <a href="{{ route('product.detail', $product->slug) }}" class="hover:underline">
                                    <h2 class="text-xl font-bold line-clamp-2">{{ $product->name }}</h2>
                                </a>
                                <p class="text-gray-600">{{ $product->category->name }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 flex justify-end">
                {{ $products->links('vendor.pagination.public') }}
            </div>
        </div>
    </div>
    <x-banner />
    <div class="btm-nav shadow-lg z-50 flex lg:hidden">
        <div class="flex flex-row px-4">
            <button class="btn w-full" onclick="filterproduk.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
                Filter
            </button>
        </div>
    </div>
</x-app-layout>
