<x-app-layout>
    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('Produk') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>

    <div class="mt-3 flex flex-col space-y-3 lg:space-y-0 lg:flex-row">
        <!-- Filter Section -->
        <div class="w-full lg:w-1/4 lg:pr-4">
            <form action="{{ route('product.page') }}" method="GET" class="lg:space-y-4 sticky top-20">
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
            <div class="flex space-x-3 mb-2 lg:mb-0 sticky top-16 z-20 bg-base-100 py-3 lg:px-0 overflow-x-auto">
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
                        <x-product-card :product="$product" />
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
