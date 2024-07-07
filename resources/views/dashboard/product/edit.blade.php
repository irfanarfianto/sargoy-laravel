<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Edit Produk') }}
            </h4>
        </div>
        <div class="flex flex-wrap-reverse w-full md:w-auto space-x-2">
            <a href="{{ route('dashboard.product.index') }}" class="btn btn-ghost w-full md:w-auto">Kembali</a>
            <button type="submit" form="edit-product-form" class="btn btn-primary w-full md:w-auto">Simpan
                Perubahan</button>
        </div>
    </div>
    <div class="container mx-auto">
        <form id="edit-product-form" action="{{ route('dashboard.product.update', $product->slug) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="form-select mt-1 block w-full">
                    <option disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-input mt-1 block w-full"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" id="slug" class="form-input mt-1 block w-full" readonly
                    value="{{ old('slug', $product->slug) }}" required>
                @error('slug')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status Produk</label>
                <div class="mt-1 flex items-center">
                    @if ($product->is_verified)
                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <span class="label-text">Aktif</span>
                                <input type="checkbox" class="toggle" name="status"
                                    {{ $product->status ? 'checked' : '' }}>
                            </label>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Produk belum diverifikasi</p>
                    @endif
                </div>
                @error('status')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" class="form-textarea mt-1 block w-full" rows="3" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" class="form-input mt-1 block w-full"
                    value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock" class="form-input mt-1 block w-full"
                    value="{{ old('stock', $product->stock) }}" required>
                @error('stock')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="material" class="block text-sm font-medium text-gray-700">Material</label>
                <input type="text" name="material" id="material" class="form-input mt-1 block w-full"
                    value="{{ old('material', $product->material) }}">
                @error('material')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700">Warna</label>
                <input type="text" name="color" id="color" class="form-input mt-1 block w-full"
                    value="{{ old('color', $product->color) }}">
                @error('color')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="size" class="block text-sm font-medium text-gray-700">Ukuran</label>
                <input type="text" name="size" id="size" class="form-input mt-1 block w-full"
                    value="{{ old('size', $product->size) }}">
                @error('size')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pattern" class="block text-sm font-medium text-gray-700">Pola</label>
                <input type="text" name="pattern" id="pattern" class="form-input mt-1 block w-full"
                    value="{{ old('pattern', $product->pattern) }}">
                @error('pattern')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="ecommerce_link" class="block text-sm font-medium text-gray-700">Link Ecommerce</label>
                <input type="text" name="ecommerce_link" id="ecommerce_link" class="form-input mt-1 block w-full"
                    value="{{ old('ecommerce_link', $product->ecommerce_link) }}">
                @error('ecommerce_link')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            @if ($product->images->isNotEmpty())
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Gambar Produk Saat Ini</label>
                    <div class="mt-2 flex">
                        @foreach ($product->images as $image)
                            <div class="w-20 h-20 mr-4 relative">
                                <img src="{{ asset($image->image_url) }}" alt="Product Image"
                                    class="w-20 h-20 object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Input field for uploading new images --}}
            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">Gambar Produk Baru</label>
                <input type="file" name="images[]" id="images" class="form-input mt-1 block w-full" multiple
                    accept="image/*">
                @error('images')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>
</x-dashboard-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('keyup', function() {
            const nameValue = nameInput.value.trim().toLowerCase();
            const slugValue = nameValue.replace(/\s+/g, '-') // Replace spaces with dash
                .replace(/[^\w\-]+/g, '') // Remove non-word characters except dash
                .replace(/\-\-+/g, '-') // Replace multiple dashes with single dash
                .substring(0, 50); // Limit to maximum 50 characters

            slugInput.value = slugValue;
        });

        const checkbox = document.getElementById('status');
        const statusLabel = document.getElementById('statusLabel');

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                statusLabel.textContent = 'Aktif';
            } else {
                statusLabel.textContent = 'Tidak Aktif';
            }
        });

        // Initialize label based on initial checkbox state
        if (checkbox.checked) {
            statusLabel.textContent = 'Aktif';
        } else {
            statusLabel.textContent = 'Tidak Aktif';
        }
    });
</script>
