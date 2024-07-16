<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
        </div>
        <div class="flex items-center justify-between mb-2 w-full md:w-auto space-x-2">
            <div class="hidden lg:block">
                @include('dashboard.product.partials.sorting')
            </div>
            <!-- Form Pencarian -->
            <form action="{{ route('dashboard.product.index') }}" method="GET" class="flex items-center w-full">
                <div class="relative flex-grow">
                    <input type="text" class="rounded-l-md input input-bordered w-full py-2 px-4" name="search"
                        value="{{ $search }}" placeholder="Search" />
                    <button type="submit" class=" absolute right-0 top-0 bottom-0 px-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </form>
            <a href="{{ route('dashboard.product.tambah') }}" class="btn btn-primary hidden lg:flex">
                <span class="hidden sm:inline">Tambah Produk</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>

    </div>


    <!-- Daftar Produk -->
    <div class="container mx-auto shadow bg-white rounded-lg">
        @if ($products->isEmpty())
            @if ($search)
                <p class="text-center text-gray-600 mt-8">Produk {{ $search }} yang Anda cari tidak ditemukan.
                </p>
            @else
                <p class="text-center text-gray-600 mt-8">Belum ada produk yang dibuat. <a
                        href="{{ route('dashboard.product.tambah') }}" class="text-blue-500">Buat produk baru</a>.</p>
            @endif
        @else
            <div class="overflow-x-auto">
                <table class="table table-zebra min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- head -->
                    <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">
                                <label>
                                    <input type="checkbox" id="select-all-checkbox" class="checkbox checkbox-sm checkbox-primary" />
                                </label>
                            </th>
                            <th class="py-3 px-6 text-left">Nama</th>
                            <th class="py-3 px-6 text-left">Dilihat</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            @if (auth()->user()->hasRole('admin'))
                                <th class="py-3 px-6 text-left">Dibuat</th>
                            @endif
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left align-center">
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-primary" />
                                    </label>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center gap-3">

                                        @foreach ($product->images as $image)
                                            @if ($loop->first)
                                                <div class="avatar">
                                                    <div class="mask mask-squircle h-12 w-12">
                                                        <img src="{{ asset($image->image_url) ?? 'https://placehold.co/400' }}"
                                                            loading="lazy" alt="{{ $product->name }}"
                                                            class="h-12 w-12 object-cover">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        <div>
                                            <div class="font-bold truncate w-40">{{ $product->name }}</div>
                                            <div class="text-sm opacity-50">{{ $product->category->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <p class="text-xs items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class=" size-3 inline-block">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                        @if ($product->views_count >= 1000000)
                                            {{ number_format($product->views_count / 1000000, 1, '.', '') }}JT
                                        @elseif ($product->views_count >= 1000)
                                            {{ number_format($product->views_count / 1000, 1, '.', '') }}K
                                        @else
                                            {{ number_format($product->views_count, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if (!$product->is_verified)
                                        @if (auth()->user()->hasRole('seller'))
                                            <span class="badge badge-red">Belum Diverifikasi</span>
                                        @endif
                                        @if (auth()->user()->hasRole('admin'))
                                            @if (!$product->is_verified)
                                                <form action="{{ route('product.verify', $product) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm text-base-100">Verifikasi
                                                        Sekarang</button>
                                                </form>
                                            @endif
                                        @endif
                                    @else
                                        @if ($product->status == 1)
                                            <p class="text-xs items-center">
                                                <span class="badge badge-success badge-sm"></span>
                                                Aktif
                                            </p>
                                        @else
                                            <p class="text-xs items-center">
                                                <span class="badge badge-error badge-sm"></span>
                                                Nonaktif
                                            </p>
                                        @endif
                                    @endif
                                </td>
                                @if (auth()->user()->hasRole('admin'))
                                    <td class="py-3 px-6 text-left">
                                        {{ $product->user->name }}
                                        <div class="text-xs opacity-50">
                                            {{ $product->created_at }}</div>
                                    </td>
                                @endif
                                <td class="py-3 px-6 text-left">
                                    <div class=" flex flex-wrap items-center space-x-2">
                                        <a class="btn btn-ghost btn-xs text-neutral"
                                            onclick="document.getElementById('viewModal{{ $product->id }}').showModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('dashboard.product.edit', $product->slug) }}"
                                            class="text-indigo-600 hover:text-indigo-900 btn btn-ghost btn-xs">Edit</a>
                                        <a class="btn btn-ghost btn-xs text-error"
                                            onclick="document.getElementById('deleteModal{{ $product->id }}').showModal()">
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            @include('dashboard.product.partials.modal')
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 mb-8 lg:mb-2">
                {{ $products->links('vendor.pagination.custom') }}
            </div>

        @endif
    </div>
    <div class="btm-nav shadow-lg z-50 flex lg:hidden">
        <div class="flex flex-row px-4">
            @include('dashboard.product.partials.sorting')
            <a href="{{ route('dashboard.product.tambah') }}" class="btn btn-primary w-4/5">
                <span class="inline">Tambah Produk</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
    </div>
</x-dashboard-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil elemen checkbox untuk memilih semua dan semua checkbox lainnya
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const checkboxes = document.querySelectorAll('.checkbox');

        // Tambahkan event listener untuk checkbox "Pilih Semua"
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Tambahkan event listener untuk checkbox individual
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Jika salah satu checkbox individual tidak terpilih, checkbox "Pilih Semua" harus tidak terpilih
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    // Periksa apakah semua checkbox lainnya terpilih, jika ya, centang checkbox "Pilih Semua"
                    let allChecked = true;
                    checkboxes.forEach(cb => {
                        if (!cb.checked) {
                            allChecked = false;
                        }
                    });
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
    });
</script>
