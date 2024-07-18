<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Tambah Produk') }}
            </h4>
        </div>
        <div class="hidden lg:flex flex-wrap-reverse w-full md:w-auto space-x-2">
            <button class="btn btn-ghost w-full md:w-auto" onclick="window.history.back();">Kembali</button>
            <button type="submit" form="tambah-product-form" class="btn btn-primary w-full md:w-auto">Simpan</button>
        </div>
    </div>
    <div class="container mb-6 lg:mb-0">
        <form id="tambah-product-form" action="{{ route('dashboard.product.simpan') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
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
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    value="{{ old('name') }}" placeholder="Masukkan nama produk" required>
                                @error('name')
                                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium mb-2 text-gray-700">Status
                                Produk<span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="select select-bordered w-full" disabled>
                                <option value="false" {{ old('status') !== 'true' ? 'selected' : '' }}>Nonaktif
                                </option>
                                <option value="true" {{ old('status') == 'true' ? 'selected' : '' }}>Aktif</option>
                            </select>
                            <input type="hidden" name="status" value="false">
                            @error('status')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium mb-2 text-gray-700">Deskripsi<span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" id="description" class="textarea textarea-bordered w-full" rows="5"
                                placeholder="Masukkan deskripsi produk" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="shadow bg-white rounded-lg py-4 px-5 mt-6 w-full">
                        <h3 class="text-sm font-normal  mb-4">Tautkan Produk</h3>
                        <div class="mb-4">
                            <label for="ecommerce_link" class="block text-sm font-medium mb-2 text-gray-700">Link
                                Ecommerce
                                (Opsional)</label>
                            <input type="text" name="ecommerce_link" id="ecommerce_link"
                                class="input input-bordered w-full" value="{{ old('ecommerce_link') }}"
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
                            <label for="images" class="block text-sm font-medium mb-2 text-gray-700">Gambar
                                Produk (Max 3)
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div
                                    class="relative border border-dashed rounded-lg overflow-hidden aspect-square flex flex-col items-center justify-center text-center">
                                    <input type="file" name="images[]" id="images1"
                                        class="file-input file-input-bordered file-input-sm w-full h-full opacity-0 absolute inset-0 cursor-pointer"
                                        multiple accept="image/*"
                                        onchange="previewImage('images1', 'imagePreview1', 'uploadText1')">
                                    <img id="imagePreview1" src="" alt="Preview" style="display: none;"
                                        class="object-cover aspect-square">
                                    <svg id="uploadIcon1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <p id="uploadText1" class="text-sm text-gray-500 mt-2">Klik atau seret file ke
                                        sini untuk mengunggah</p>
                                </div>
                                <div
                                    class="relative border border-dashed rounded-lg overflow-hidden aspect-square flex flex-col items-center justify-center text-center">
                                    <input type="file" name="images[]" id="images2"
                                        class="file-input file-input-bordered file-input-sm w-full h-full opacity-0 absolute inset-0 cursor-pointer"
                                        multiple accept="image/*" onchange="previewImage('images2', 'imagePreview2')">
                                    <img id="imagePreview2" src="" alt="Preview" style="display: none;"
                                        class="object-cover aspect-square">
                                    <svg id="uploadIcon2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <p id="uploadText2" class="text-sm text-gray-500 mt-2">Klik atau seret file ke
                                        sini untuk mengunggah</p>
                                </div>
                                <div
                                    class="relative border border-dashed rounded-lg overflow-hidden aspect-square flex flex-col items-center justify-center text-center">
                                    <input type="file" name="images[]" id="images3"
                                        class="file-input file-input-bordered file-input-sm w-full h-full opacity-0 absolute inset-0 cursor-pointer"
                                        multiple accept="image/*" onchange="previewImage('images3', 'imagePreview3')">
                                    <img id="imagePreview3" src="" alt="Preview" style="display: none;"
                                        class="object-cover aspect-square">
                                    <svg id="uploadIcon3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <p id="uploadText3" class="text-sm text-gray-500 mt-2">Klik atau seret file ke
                                        sini untuk mengunggah</p>
                                </div>
                            </div>

                            <script>
                                function previewImage(inputId, previewId) {
                                    const img = document.getElementById(previewId);
                                    const input = document.getElementById(inputId);
                                    const file = input.files[0];
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                        document.getElementById('uploadIcon' + inputId.slice(-1)).style.display = 'none';
                                        document.getElementById('uploadText' + inputId.slice(-1)).style.display = 'none';
                                    };

                                    if (file) {
                                        reader.readAsDataURL(file);
                                    } else {
                                        img.src = "";
                                        img.style.display = 'none';
                                        document.getElementById('uploadIcon' + inputId.slice(-1)).style.display = 'block';
                                        document.getElementById('uploadText' + inputId.slice(-1)).style.display = 'block';
                                    }
                                }
                            </script>
                            @error('images')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Variant Product Details -->
                <div class="mb-20 w-full lg:w-1/3 mt-6 lg:mt-0">
                    <div class="shadow bg-white rounded-lg py-4 px-5 w-full">
                        <h3 class="text-sm font-normal mb-4">Detail Varian</h3>
                        <div class="mb-4">
                            <label for="material" class="block text-sm font-medium mb-2 text-gray-700">Material<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="material" id="material" class="input input-bordered w-full"
                                value="{{ old('material') }}" placeholder="Masukkan material produk">
                            @error('material')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="color" class="block text-sm font-medium mb-2 text-gray-700">Warna<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="color" id="color" class="input input-bordered w-full"
                                value="{{ old('color') }}" placeholder="Masukkan warna produk">
                            @error('color')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="size" class="block text-sm font-medium mb-2 text-gray-700">Ukuran<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="size" id="size" class="input input-bordered w-full"
                                value="{{ old('size') }}" placeholder="Masukkan ukuran produk">
                            @error('size')
                                <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pattern" class="block text-sm font-medium mb-2 text-gray-700">Pola<span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pattern" id="pattern" class="input input-bordered w-full"
                                value="{{ old('pattern') }}" placeholder="Masukkan pola produk">
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
    <div class="btm-nav shadow-lg z-50 flex lg:hidden">
        <div class="flex flex-row px-4">
            <button class="btn btn-ghost w-1/2" onclick="window.history.back();">Kembali</button>
            <button type="submit" form="tambah-product-form" class="btn btn-primary w-1/2">Simpan</button>
        </div>
    </div>
</x-dashboard-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('keyup', function() {
            const nameValue = nameInput.value.trim().toLowerCase();
            const slugValue = nameValue.replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .substring(0, 50);

            slugInput.value = slugValue;
        });

    });
</script>
