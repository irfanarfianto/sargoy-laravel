<x-app-layout>
    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('Detail Produk') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>
    <x-breadcrumb :items="$breadcrumbItems" />
    <div class="mt-8 text-2xl">
        {{ __('Detail Produk') }}
    </div>

    <div class="mt-6 flex flex-wrap">
        {{-- Gambar Produk --}}
        <div class="w-full lg:w-1/3 lg:pr-3">
            <div class="overflow-hidden">
                <div class="flex flex-wrap gap-2">
                    {{-- Tampilkan gambar pertama --}}
                    <button onclick="my_modal_2.showModal()">
                        <img id="mainImage" src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                            loading="lazy" alt="{{ $product->name }}" class="object-cover aspect-square rounded-md">
                    </button>
                    {{-- Tampilkan gambar-gambar lainnya --}}
                    @foreach ($product->images->slice(1) as $image)
                        <img src="{{ $image->image_url ?? 'https://placehold.co/400' }}" loading="lazy"
                            alt="{{ $product->name }}" class="object-cover h-20 w-20 rounded-md"
                            onclick="changeMainImage(this)">
                    @endforeach
                </div>
            </div>
            <div class="review-summary mt-10 hidden lg:block sticky top-24">
                <h3 class="text-lg font-semibold">Ulasan Pembeli</h3>
                @include('pages.products.partials.ringkasan_ulasan')
            </div>
        </div>
        {{-- Detail Produk --}}
        <div class="w-full lg:w-4/6">
            <div class="overflow-hidden">
                <div class="flex flex-row justify-between mt-2 lg:mt-0">
                    <div class="lg:w-1/2">
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-gray-600">
                            Kategori: {{ $product->category->name }}
                        </a>
                        <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
                    </div>

                    <div class="hidden lg:block">
                        @if ($whatsappNumber)
                            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer">
                                <button class="btn bg-[#25D366] text-base-100">
                                    <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp</button>
                            </a>
                        @endif
                        @if ($product->ecommerce_link)
                            <a href="{{ $product->ecommerce_link }}" target="_blank" rel="noopener noreferrer">
                                <button class="btn btn-primary">Beli Sekarang</button>
                            </a>
                        @endif
                    </div>
                </div>
                {{-- Rating --}}
                <div class="flex items-center mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-6 text-orange-400">
                        <path fill-rule="evenodd"
                            d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="ml-1 text-xl">{{ number_format($averageRating, 1) }}</p>
                    <span class="ml-2 text-sm text-gray-500">({{ $product->reviews->count() }} ulasan)</span>
                </div>
                <h3 class="text-lg font-semibold mt-2">Deskripsi</h3>
                <p class="mt-2 text-sm text-gray-500"> {{ $product->description }}</p>

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
                    <h3 class="text-lg font-semibold">Variants</h3>
                    <ul class="mt-2">
                        @foreach ($product->variants as $variant)
                            <li class="text-sm text-gray-500">{{ $variant->variant_name }}:
                                {{ $variant->variant_value }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-6">
                    <div class="review-summary mt-10 block lg:hidden">
                        <h3 class="text-lg font-semibold">Ulasan Pembeli</h3>
                        @include('pages.products.partials.ringkasan_ulasan')
                    </div>
                    <div class="flex justify-between mt-6">
                        <h3 class="text-lg font-semibold">Ulasan Pilihan</h3>
                        <div class="dropdown dropdown-left">
                            <div tabindex="0" role="button" class="btn btn-sm btn-ghost">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                </svg>
                                Urutkan:
                                <span class="text-neutral">
                                    @if (request()->get('order') === 'latest')
                                        Terbaru
                                    @elseif (request()->get('order') === 'highest')
                                        Rating Tertinggi
                                    @elseif (request()->get('order') === 'lowest')
                                        Rating Terendah
                                    @endif
                                </span>
                            </div>
                            <ul tabindex="0"
                                class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                <li><a href="{{ route('product.detail', ['slug' => $product->slug, 'order' => 'latest']) }}"
                                        class="text-neutral block py-1">Terbaru</a></li>
                                <li><a href="{{ route('product.detail', ['slug' => $product->slug, 'order' => 'highest']) }}"
                                        class="text-neutral block py-1">Rating Tertinggi</a></li>
                                <li><a href="{{ route('product.detail', ['slug' => $product->slug, 'order' => 'lowest']) }}"
                                        class="text-neutral block py-1">Rating Terendah</a></li>
                            </ul>
                        </div>
                    </div>


                    <ul class="mt-2">
                        @forelse ($product->reviews->take(10) as $review)
                            <li class="mb-4 border-b border-gray-200 pb-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold">{{ $review->user->name }}</p>
                                        <div class="rating flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    class="size-3 {{ $i <= $review->rating ? 'text-orange-400' : 'text-gray-400' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        @if ($review->created_at->diffInMonths() > 1)
                                            {{ $review->created_at->format('l, d F Y, H:i') }}
                                        @else
                                            {{ $review->created_at->diffForHumans() }}
                                        @endif
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-4">{{ $review->comment }}</p>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada ulasan untuk produk ini.</p>
                        @endforelse

                    </ul>
                    {{-- Form Ulasan --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Buat Ulasan Baru</h3>
                        <form action="{{ route('product.review.store', ['product' => $product->id]) }}"
                            method="POST">
                            @csrf
                            <div class="mt-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700">Pilih
                                    Rating:</label>
                                <div class="rating">
                                    <input type="radio" name="rating" value="1"
                                        class="mask mask-star-2 bg-orange-400" />
                                    <input type="radio" name="rating" value="2"
                                        class="mask mask-star-2 bg-orange-400" />
                                    <input type="radio" name="rating" value="3"
                                        class="mask mask-star-2 bg-orange-400" checked="checked" />
                                    <input type="radio" name="rating" value="4"
                                        class="mask mask-star-2 bg-orange-400" />
                                    <input type="radio" name="rating" value="5"
                                        class="mask mask-star-2 bg-orange-400" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="comment"
                                    class="block text-sm font-medium text-gray-700">Komentar:</label>
                                <textarea id="comment" name="comment" rows="3" placeholder="Isi komentar"
                                    class="mt-1 textarea w-full textarea-bordered"></textarea>
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
        <h3 class="text-xl font-semibold">Rekomendasi Untukmu</h3>
        <div class="mt-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 lg:gap-4">
            @foreach ($recommendedProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
    <div class="btm-nav shadow-lg z-50 flex lg:hidden">
        <div class="flex flex-row px-4">
            @if ($whatsappNumber)
                <a href="https://wa.me/{{ $whatsappNumber }}" class="btn bg-[#25D366] text-base-100 w-1/6"
                    target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-whatsapp"></i> <span class="hidden lg:block">Hubungi via WhatsApp
                    </span>
                </a>
            @endif
            <a href="{{ $product->ecommerce_link }}" class="btn btn-primary w-5/6" target="_blank"
                rel="noopener noreferrer">
                Beli Sekarang
            </a>
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
