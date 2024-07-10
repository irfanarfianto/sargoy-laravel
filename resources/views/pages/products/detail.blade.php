<x-app-layout>
    <x-breadcrumb :items="$breadcrumbItems" />
    <div class="mt-8 text-2xl">
        {{ __('Detail Produk') }}
    </div>

    <div class="mt-6 flex flex-wrap">
        {{-- Gambar Produk --}}
        <div class="w-full lg:w-1/3">
            <div class="bg-white overflow-hidden">
                <div class="flex flex-wrap gap-2">
                    {{-- Tampilkan gambar pertama --}}
                    <button onclick="my_modal_2.showModal()">
                        <img id="mainImage" src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                            loading="lazy" alt="{{ $product->name }}" class="object-cover h-96 w-96 rounded-md">
                    </button>
                    {{-- Tampilkan gambar-gambar lainnya --}}
                    @foreach ($product->images->slice(1) as $image)
                        <img src="{{ $image->image_url ?? 'https://placehold.co/400' }}" loading="lazy"
                            alt="{{ $product->name }}" class="object-cover h-20 w-20 rounded-md"
                            onclick="changeMainImage(this)">
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Detail Produk --}}
        <div class="w-full lg:w-4/6">
            <div class="bg-white overflow-hidden">
                <div class="flex flex-row justify-between mt-2 lg:mt-0">
                    <div>
                        <span class="text-gray-600">Kategori: {{ $product->category->name }}</span>
                        <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
                    </div>

                    <a href="{{ $product->ecommerce_link }}">
                        <button class="btn btn-primary">Beli Sekarang</button>
                    </a>
                </div>
                {{-- Rating --}}
                <div class="flex items-center mt-2">
                    @php
                        $rating = $product->average_rating;
                        $maxRating = 5;
                        $filledStars = intval($rating);
                        $emptyStars = $maxRating - $filledStars;
                    @endphp

                    @for ($i = 0; $i < $filledStars; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-orange-400">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                    @endfor

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-6 text-gray-300">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                    @endfor
                </div>
                <p class="mt-2 text-sm text-gray-500">Deskripsi: {{ $product->description }}</p>

                <!-- Open the modal using ID.showModal() method -->
                <dialog id="my_modal_2" class="modal">
                    <div class="modal-box p-0 w-full max-w-7xl lg:h-full">
                        <img src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                            alt="{{ $product->name }}" class="object-cover h-auto max-h-full w-full">
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
                {{-- Variants --}}
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Variants:</h3>
                    <ul class="mt-2">
                        @foreach ($product->variants as $variant)
                            <li class="text-sm text-gray-500">{{ $variant->variant_name }}:
                                {{ $variant->variant_value }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">{{ $product->reviews->count() }} Ulasan Produk</h3>
                    <ul class="mt-2 overflow-y-auto max-h-96">
                        @forelse ($product->reviews as $review)
                            <li class="mb-4 border-b border-gray-200 pb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $review->user->name }}</p>
                                        <span
                                            class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-3 text-orange-400">
                                            <path fill-rule="evenodd"
                                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                clip-rule="evenodd" />
                                        </svg>{{ $review->rating }}
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">{{ $review->comment }}</p>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada ulasan untuk produk ini.</p>
                        @endforelse
                    </ul>
                    {{-- Form Ulasan --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Buat Ulasan Baru:</h3>
                        <form action="{{ route('product.review.store', ['product' => $product->id]) }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                                <select id="rating" name="rating" class="mt-1 input input-bordered w-full">
                                    <option value="1">1
                                        Bintang</option>
                                    <option value="2">2 Bintang</option>
                                    <option value="3">3 Bintang</option>
                                    <option value="4">4 Bintang</option>
                                    <option value="5">5 Bintang</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700">Komentar:</label>
                                <textarea id="comment" name="comment" rows="3"
                                placeholder="Isi komentar" class="mt-1 textarea w-full textarea-bordered"></textarea>
                                @error('comment')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-8">
        <h3 class="text-xl font-semibold">Produk Rekomendasi</h3>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($recommendedProducts as $recommendedProduct)
                <div class="bg-white overflow-hidden">
                    <div class=" relative overflow-hidden h-60 rounded-lg">
                        <a href="{{ route('product.detail', $recommendedProduct->slug) }}">
                            <img src="{{ $recommendedProduct->images->first()->image_url ?? 'https://placehold.co/400' }}"
                                loading="lazy" alt="{{ $recommendedProduct->name }}"
                                class="object-cover h-full w-full">
                        </a>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-600">{{ $recommendedProduct->category->name }}</p>
                        <a href="{{ route('product.detail', $recommendedProduct->slug) }}">
                            <h4 class="text-lg font-semibold text-gray-800">{{ $recommendedProduct->name }}</h4>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function openModal(imageUrl) {
            var modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            var modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        function changeMainImage(clickedImage) {
            // Dapatkan URL gambar yang dipilih
            var clickedImageUrl = clickedImage.src;

            // Ganti sumber gambar yang dipilih dengan gambar utama
            clickedImage.src = document.getElementById('mainImage').src;

            // Ganti sumber gambar utama dengan gambar yang dipilih
            document.getElementById('mainImage').src = clickedImageUrl;
        }
    </script>
</x-app-layout>
