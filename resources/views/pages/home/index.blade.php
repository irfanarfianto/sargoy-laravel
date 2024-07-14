<x-app-layout>
    <div class="text-2xl mt-8 text-center">
        {{ __('Kategori') }}
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4  mt-8">
        @foreach ($categories as $category)
            <div class="flex flex-col items-center">
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="relative aspect-video rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $category->image) }}" class="object-cover aspect-video">
                    <div class="absolute inset-0 flex items-center justify-center bg-black opacity-50 rounded-lg">
                        <div class="text-center text-white">
                            <p class=" text-4xl font-medium">{{ $category->name }}</p>
                            <p class="text-sm">{{ $category->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Produk Baru -->
    <div class="mt-8 text-2xl">
        {{ __('Produk Baru') }}
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($newProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="flex justify-center mt-6">
        <a href="/products" class="btn btn-primary">
            Lihat Semua Produk <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>

    <!-- Produk Unggulan -->
    <div class="mt-8 text-2xl">
        {{ __('Produk Unggulan') }}
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($featuredProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="flex justify-center mt-6">
        <a href="/products" class="btn btn-primary">
            Lihat Semua Produk <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>

    <!-- Semua Produk -->
    <div class="mt-8 text-2xl">
        {{ __('Semua Produk') }}
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($allProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="flex justify-center mt-6">
        <a href="/products" class="btn btn-primary">
            Lihat Semua Produk <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>

    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</x-app-layout>
