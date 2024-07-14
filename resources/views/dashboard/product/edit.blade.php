<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Edit Produk') }}
            </h4>
        </div>
        <div class="hidden lg:flex flex-wrap-reverse w-full md:w-auto space-x-2">
            <a href="{{ route('dashboard.product.index') }}" class="btn btn-ghost w-full md:w-auto">Kembali</a>
            <button type="submit" form="edit-product-form" class="btn btn-primary w-full md:w-auto">Simpan</button>
        </div>
    </div>
    <div class="container">
        <form id="edit-product-form" action="{{ route('dashboard.product.update', $product->slug) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex flex-wrap">
                <!-- Main Product Details -->
                <div class="lg:w-2/3 lg:pr-5">
                    <div class="shadow bg-white rounded-lg py-4 px-5 w-full">
                        <h3 class="text-sm font-normal mb-4">Detail Produk</h3>
                        <div class="flex flex-wrap space-x-0 lg:space-x-2">
                            <div class="mb-4 w-full lg:w-1/4">
                                <label for="category_id"
                                    class="block text-sm font-medium mb-2 text-gray-700">Kategori<span
                                        class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" class="select select-bordered w-full">
                                    <option disabled selected>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4 w-full lg:flex-1">
                                <label for="name" class="block text-sm font-medium mb-2 text-gray-700">Nama
                                    Produk<span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" class="input input-bordered w-full"
                                    value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk"
                                    required>
                                @error('name')
                                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium mb-2 text-gray-700">Deskripsi<span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" id="description" class="textarea textarea-bordered w-full" rows="5"
                                placeholder="Masukkan deskripsi produk" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="shadow bg-white rounded-lg py-4 px-5 mt-6 w-full">
                        <h3 class="text-sm font-normal mb-4">Tautkan Produk</h3>
                        <div class="mb-4">
                            <label for="ecommerce_link" class="block text-sm font-medium mb-2 text-gray-700">Link
                                Ecommerce (Opsional)</label>
                            <input type="text" name="ecommerce_link" id="ecommerce_link"
                                class="input input-bordered w-full"
                                value="{{ old('ecommerce_link', $product->ecommerce_link) }}"
                                placeholder="Masukkan link ecommerce seperti Tokopedia, Shopee, dll.">
                            <p class="text-xs text-gray-500 mt-1">Contoh: https://www.tokopedia.com/toko-anda</p>
                            @error('ecommerce_link')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="shadow bg-white rounded-lg py-4 px-5 mt-6 w-full">
                        <h3 class="text-sm font-normal mb-4">Upload Gambar Produk</h3>
                        <div class="mb-4 relative">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Gambar Produk (Max 3)<span
                                    class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($product->images as $index => $image)
                                    <div
                                        class="relative border border-dashed rounded-lg overflow-hidden aspect-square flex flex-col items-center justify-center text-center">
                                        <input type="file" name="images[]" id="images{{ $index }}"
                                            class="file-input file-input-bordered file-input-sm w-full h-full opacity-0 absolute inset-0 cursor-pointer"
                                            multiple accept="image/*"
                                            onchange="previewImage('images{{ $index }}', 'imagePreview{{ $index }}')">
                                        <img id="imagePreview{{ $index }}" src="{{ asset($image->image_url) }}"
                                            alt="Preview" style="display: block;" class="object-cover aspect-square">
                                        <svg id="uploadIcon{{ $index }}" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="size-6 hidden">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p id="uploadText{{ $index }}"
                                            class="text-sm text-gray-500 mt-2 hidden">Klik atau seret file ke sini untuk
                                            mengunggah</p>
                                    </div>
                                @endforeach
                                @for ($index = $product->images->count(); $index < 3; $index++)
                                    <div
                                        class="relative border border-dashed rounded-lg overflow-hidden aspect-square flex flex-col items-center justify-center text-center">
                                        <input type="file" name="images[]" id="images{{ $index }}"
                                            class="file-input file-input-bordered file-input-sm w-full h-full opacity-0 absolute inset-0 cursor-pointer"
                                            multiple accept="image/*"
                                            onchange="previewImage('images{{ $index }}', 'imagePreview{{ $index }}')">
                                        <img id="imagePreview{{ $index }}" src="" alt="Preview"
                                            style="display: none;" class="object-cover aspect-square">
                                        <svg id="uploadIcon{{ $index }}" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p id="uploadText{{ $index }}" class="text-sm text-gray-500 mt-2">Klik
                                            atau seret file ke sini untuk mengunggah</p>
                                    </div>
                                @endfor
                            </div>
                            @error('images')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Variant Product Details -->
                <div class="mb-20 w-full lg:w-1/3">
                    <div class="shadow bg-white rounded-lg py-4 px-5 w-full">
                        <h3 class="text-sm font-normal mb-4">Detail Varian</h3>
                        <div class="mb-4">
                            <label for="material" class="block text-sm font-medium mb-2 text-gray-700">Material<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="material" id="material" class="input input-bordered w-full"
                                value="{{ old('material', $product->material) }}"
                                placeholder="Masukkan material produk">
                            @error('material')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="color" class="block text-sm font-medium mb-2 text-gray-700">Warna<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="color" id="color" class="input input-bordered w-full"
                                value="{{ old('color', $product->color) }}" placeholder="Masukkan warna produk">
                            @error('color')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="size" class="block text-sm font-medium mb-2 text-gray-700">Ukuran<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="size" id="size" class="input input-bordered w-full"
                                value="{{ old('size', $product->size) }}" placeholder="Masukkan ukuran produk">
                            @error('size')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pattern" class="block text-sm font-medium mb-2 text-gray-700">Pola<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pattern" id="pattern" class="input input-bordered w-full"
                                value="{{ old('pattern', $product->pattern) }}" placeholder="Masukkan pola produk">
                            @error('pattern')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class=" border border-neutral-100 rounded-lg py-4 px-5 mt-6 w-full text-gray-700">
                        <h3 class="text-lg font-semibold mb-4 flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            Butuh Bantuan?
                        </h3>
                        <div>
                            <p class="text-sm font-normal">
                                Hubungi kami jika Anda memerlukan bantuan lebih lanjut
                                <a href="" class="link link-primary">Disini</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div
        class="lg:hidden flex fixed bottom-0 left-0 justify-between items-center bg-white w-full py-2 px-4 z-10 shadow-2xl">
        <a href="{{ route('dashboard.product.index') }}" class="btn btn-ghost">Kembali</a>
        <button type="submit" form="edit-product-form" class="btn btn-primary">Simpan</button>
    </div>
</x-dashboard-layout>

<script>
    function previewImage(inputId, imagePreviewId) {
        const input = document.getElementById(inputId);
        const imagePreview = document.getElementById(imagePreviewId);
        const uploadIcon = document.getElementById('uploadIcon' + inputId.slice(-1));
        const uploadText = document.getElementById('uploadText' + inputId.slice(-1));

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadIcon.classList.add('hidden');
                uploadText.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
