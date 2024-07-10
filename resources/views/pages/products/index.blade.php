<x-app-layout>
    <div class="container mx-auto p-4">
        <!-- Filter Section -->
        <div class="flex justify-between mb-4">
            <!-- Filter by Category -->
            <div class="relative">
                <select class="appearance-none border border-gray-300 rounded px-3 py-2 pr-8 leading-tight focus:outline-none focus:border-blue-500">
                    <option value="" selected>{{ __('Semua Kategori') }}</option>
                    <option value="elektronik">{{ __('Elektronik') }}</option>
                    <option value="pakaian">{{ __('Pakaian') }}</option>
                    <option value="alat_rumah_tangga">{{ __('Alat Rumah Tangga') }}</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 11c.554 0 1 .446 1 1s-.446 1-1 1-1-.446-1-1 .446-1 1-1zm4-3c-.554 0-1 .446-1 1s.446 1 1 1 1-.446 1-1-.446-1-1-1zm-8 0c-.554 0-1 .446-1 1s.446 1 1 1 1-.446 1-1-.446-1-1-1z"/></svg>
                </div>
            </div>

            <!-- Filter by Price Range -->
            <div class="relative">
                <select class="appearance-none border border-gray-300 rounded px-3 py-2 pr-8 leading-tight focus:outline-none focus:border-blue-500">
                    <option value="" selected>{{ __('Semua Harga') }}</option>
                    <option value="under_100000">{{ __('Kurang dari Rp 100.000') }}</option>
                    <option value="100000_to_500000">{{ __('Rp 100.000 - Rp 500.000') }}</option>
                    <option value="over_500000">{{ __('Lebih dari Rp 500.000') }}</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 11c.554 0 1 .446 1 1s-.446 1-1 1-1-.446-1-1 .446-1 1-1zm4-3c-.554 0-1 .446-1 1s.446 1 1 1 1-.446 1-1-.446-1-1-1zm-8 0c-.554 0-1 .446-1 1s.446 1 1 1 1-.446 1-1-.446-1-1-1z"/></svg>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Replace this section with your actual product data loop -->
            @for ($i = 1; $i <= 12; $i++)
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
                <div class="text-lg font-semibold mb-2">Product {{ $i }}</div>
                <div class="text-sm text-gray-600 mb-2">Category: Elektronik</div>
                <div class="text-lg font-bold text-gray-800">Rp 100.000</div>
                <div class="flex justify-center mt-8">
                    <button href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Detail Produk
                    </button>
                </div>
            </div>
            @endfor
        </div>
    </div>
</x-app-layout>
