<div class="bg-white overflow-hidden shadow-md rounded-lg">
    <div class="relative overflow-hidden h-60">
        <img class="object-cover w-full h-full"
            src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}" loading="lazy"
            alt="{{ $product->name }}" />
    </div>
    <div class="px-4 py-4">
        <h2 class="text-xl font-bold">{{ $product->name }}</h2>
        <p class="text-gray-600">{{ $product->category->name }}</p>
        <p class="text-gray-700 mt-2">{{ Str::limit($product->description, 100) }}</p>
        <div class="mt-4 flex justify-between items-center">
            <span class="text-blue-600 font-bold">{{ __('Rp') . number_format($product->price, 0, ',', '.') }}</span>
            <a href="{{ route('product.detail', $product->slug) }}"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                {{ __('Lihat Produk') }}
            </a>
        </div>
    </div>
</div>
