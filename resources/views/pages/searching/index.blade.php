<x-app-layout>
    @if ($products->isNotEmpty() || $blogPosts->isNotEmpty())
        <h1 class="text-2xl font-bold">Search Results for "{{ $query }}"</h1>

        <div class="my-4">
            <h2 class="text-xl font-bold">{{ $products->count() }} Produk ditemukan</h2>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-4">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <div class="my-4">
            @if ($blogPosts->isNotEmpty())
                <h2 class="text-xl font-bold">{{ $blogPosts->count() }} Blog Posts ditemukan</h2>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-4">
                    @forelse ($blogPosts as $post)
                        <x-blog-post :post="$post" />
                    @empty
                        <p>No blog posts found.</p>
                    @endforelse
                </div>
            @endif
        </div>
    @else
        <p>No results found for "{{ $query }}".</p>
    @endif
</x-app-layout>
