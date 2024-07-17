<x-app-layout>
    <div class="text-2xl mt-8 text-center">
        <h2>
            {{ __('Kategori Produk') }}
            <span class="block text-sm font-normal text-gray-500">Temukan keindahan dan keberagaman Sarung Goyor kami
                yang mengagumkan.</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4  mt-8">
        @foreach ($categories as $category)
            <div class="flex flex-col items-center">
                <a href="{{ route('categories.show', $category->slug) }}"
                    class="relative h-20 lg:h-24 rounded-lg overflow-hidden">
                    <img src="{{ str_replace('public', 'storage', $category->image) }}"
                        class="object-cover aspect-auto object-center" alt="{{ $category->slug }}">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                    <div class="flex flex-col items-center justify-center absolute inset-0 text-white">
                        <h3 class="text-2xl lg:text-3xl">{{ $category->name }}</h3>
                        <p class="text-sm lg:text-base">{{ $category->description }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Produk Baru -->
    <div class="mt-12 text-2xl">
        {{ __('Produk Baru') }}
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($newProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>


    <!-- Produk Unggulan -->
    <div class="mt-8 flex justify-between items-center">
        <h2 class="text-2xl">
            {{ __('Produk Unggulan') }}
        </h2>
        <a href="/products" class="link link-primary flex link-hover">
            Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($featuredProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <!-- Bagian Full Story -->
    <div class="mt-12 flex flex-col lg:flex-row">
        <div class="w-full lg:w-1/2 mb-4 md:mb-0 lg:mr-4">
            <img src="{{ asset('images/image3.png') }}" alt="Full Story Sarung Goyor" class="rounded-lg w-full h-auto">
        </div>
        <div class="w-full lg:w-1/2 flex flex-col">
            <h3 class="text-2xl font-bold mb-4">Keunikan Sarung Goyor</h3>
            <ul class="list-disc pl-6">
                <li class="mb-2"><strong>Kualitas Bahan Unggulan</strong><br>Sarung Goyor menggunakan bahan baku kain
                    terbaik, tidak
                    hanya untuk keindahan visualnya tetapi juga untuk kenyamanan saat digunakan.</li>
                <li class="mb-2"><strong>Konsep Keberlanjutan</strong><br>Proses produksi Sarung Goyor didesain untuk
                    ramah lingkungan,
                    mencerminkan komitmen terhadap pelestarian alam dan budaya lokal.</li>
                <li class="mb-2"><strong>Penggabungan Tradisi dan Modernitas</strong><br>Dengan menyatukan elemen
                    tradisional dan modern,
                    Sarung Goyor berhasil menciptakan produk yang unik dan bernilai tambah, tidak hanya diakui secara
                    lokal tetapi juga di tingkat internasional.</li>
            </ul>
        </div>
    </div>

    <!-- Bagian ATBM -->
    <div class="mt-12">
        <div class="flex flex-wrap items-start justify-between rounded-lg">
            <div class="w-full lg:flex-1 mb-4 lg:mb-0">
                <h3 class="text-2xl font-bold">Keistimewaan Sarung Goyor</h3>
                <p class="mt-2 text-md text-gray-800">Sarung Goyor masih diproduksi menggunakan Alat Tenun Bukan Mesin
                    (ATBM), mewarisi keahlian dan ketelatenan tangan-tangan terampil dari Desa Wanarejan Utara. Setiap
                    produk menjadi bukti kebanggaan dan dedikasi untuk mempertahankan kualitas tertinggi.</p>
                <a href="{{ route('product.page') }}" class="btn btn-primary mt-4">
                    Lihat Produk Kami <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" class="w-6 h-6 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.25 8.25L21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
            <div class="lg:w-1/2">
                <div class=" aspect-video">
                    <iframe height="100%" width="100%"
                        src="https://www.youtube.com/embed/aEBfLGoGxXE?si=sXYQIkBBYjYgmdW9" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Semua Produk -->
    <div class="mt-12 text-2xl">
        {{ __('Semua Produk') }}
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-8">
        @foreach ($allProducts as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
    <div class="flex justify-center mt-6 mb-12">
        <a href="/products" class="btn btn-primary">
            Lihat Semua Produk <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>

    <x-banner />
</x-app-layout>
