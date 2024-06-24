<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Tambah Produk') }}
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
        <div class="flex flex-wrap-reverse w-full md:w-auto">
            <button class="btn btn-ghost w-full md:w-auto" onclick="window.history.back();">Kembali</button>
            <button type="submit" form="tambah-product-form" class="btn btn-primary w-full md:w-auto">Simpan</button>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8">
        <form id="tambah-product-form" action="{{ route('dashboard.product.simpan') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="form-select mt-1 block w-full">
                    <option disabled selected>Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-input mt-1 block w-full"
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" id="slug" class="form-input mt-1 block w-full" disabled
                    readonly value="{{ old('slug') }}" required>
                @error('slug')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status Produk</label>
                <div class="mt-1 flex items-center">
                    <input id="active" name="active" type="checkbox" class="toggle toggle-success" checked="checked"
                        onchange="updateStatusLabel()" />
                    <label id="statusLabel" for="active" class="ml-2 block text-sm leading-5 text-gray-900">
                        Aktif
                    </label>
                </div>
                @error('active')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" class="form-textarea mt-1 block w-full" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price" class="form-input mt-1 block w-full"
                    value="{{ old('price') }}" required>
                @error('price')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock" class="form-input mt-1 block w-full"
                    value="{{ old('stock') }}" required>
                @error('stock')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="material" class="block text-sm font-medium text-gray-700">Material</label>
                <input type="text" name="material" id="material" class="form-input mt-1 block w-full"
                    value="{{ old('material') }}">
                @error('material')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700">Warna</label>
                <input type="text" name="color" id="color" class="form-input mt-1 block w-full"
                    value="{{ old('color') }}">
                @error('color')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="size" class="block text-sm font-medium text-gray-700">Ukuran</label>
                <input type="text" name="size" id="size" class="form-input mt-1 block w-full"
                    value="{{ old('size') }}">
                @error('size')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="pattern" class="block text-sm font-medium text-gray-700">Pola</label>
                <input type="text" name="pattern" id="pattern" class="form-input mt-1 block w-full"
                    value="{{ old('pattern') }}">
                @error('pattern')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="ecommerce_link" class="block text-sm font-medium text-gray-700">Link Ecommerce</label>
                <input type="text" name="ecommerce_link" id="ecommerce_link" class="form-input mt-1 block w-full"
                    value="{{ old('ecommerce_link') }}">
                @error('ecommerce_link')
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
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
    });

    function updateStatusLabel() {
        const checkbox = document.getElementById('active');
        const statusLabel = document.getElementById('statusLabel');

        if (checkbox.checked) {
            statusLabel.textContent = 'Aktif';
        } else {
            statusLabel.textContent = 'Tidak Aktif';
        }
    }
</script>
