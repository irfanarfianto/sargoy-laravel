<x-app-layout>
    <div class="mt-6 flex flex-col space-y-3 lg:space-y-0 lg:flex-row">
        <!-- Filter Section -->
        <div class="w-full lg:w-1/4 lg:pr-4">
            <form action="{{ route('product.page') }}" method="GET" class="lg:space-y-4 sticky top-24">
                <div class="flex justify-between">
                    <div class="hidden lg:flex space-x-2">
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
                @if ($search && !$products->isEmpty())
                    <h5 class="text-gray-700">
                        {{ $products->total() }} {{ __('produk ditemukan, berdasarkan pencarian') }}
                        <strong>{{ "'$search'" }}</strong>
                    </h5>
                @endif
                <div class="hidden lg:block lg:space-y-5">
                    <div class="flex space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                        </svg>
                        <h3 class="">Filter Berdasarkan</h3>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="submit" name="filter" value="terbaru"
                            class="btn btn-sm {{ $filter == 'terbaru' ? 'btn-primary btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'terbaru')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Terbaru
                        </button>
                        <button type="submit" name="filter" value="rating_tertinggi"
                            class="btn btn-sm {{ $filter == 'rating_tertinggi' ? 'btn-primary btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'rating_tertinggi')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Rating Tertinggi
                        </button>
                        <button type="submit" name="filter" value="populer"
                            class="btn btn-sm {{ $filter == 'populer' ? 'btn-primary btn-outline' : 'btn-ghost' }}">
                            @if ($filter == 'populer')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                            Populer
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @include('pages.products.partials.sorting')
        <!-- Products Section -->
        <div class="w-full lg:w-3/4">
            <div class="flex space-x-3 mb-2 lg:mb-0 sticky top-20 z-20 bg-base-100 py-3 lg:px-0 overflow-x-auto">
                <a href="{{ route('product.page', ['search' => $search, 'filter' => $filter]) }}"
                    class="btn btn-sm  {{ $category === null ? 'btn-primary' : '' }}">
                    Semua Kategori
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('product.page', ['category' => $cat->slug, 'search' => $search, 'filter' => $filter]) }}"
                        class="btn btn-sm {{ $category === $cat->slug ? 'btn-primary' : '' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach

            </div>

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
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 lg:gap-6">
                    @foreach ($products as $product)
                        <div class="overflow-hidden">
                            <div class="relative overflow-hidden rounded-lg">
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <img class="object-cover aspect-square"
                                        src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                                        loading="lazy" alt="{{ $product->name }}" />
                                </a>
                            </div>
                            <div class="px-4 py-4">
                                <a href="{{ route('product.detail', $product->slug) }}" class="hover:underline">
                                    <h2 class="text-md line-clamp-2">{{ $product->name }}</h2>
                                </a>
                                <div class="rating items-center">
                                    @php
                                        $rating = $product->average_rating;
                                        $maxRating = 5;
                                        $filledStars = intval($rating);
                                        $emptyStars = $maxRating - $filledStars;
                                    @endphp

                                    @for ($i = 0; $i < $filledStars; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-4 text-orange-400">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endfor

                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="size-4 text-gray-300">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-500">({{ $product->reviews->count() }})</span>

                                </div>
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
