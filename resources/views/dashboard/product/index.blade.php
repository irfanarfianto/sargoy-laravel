<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
        <div class="flex items-center justify-between w-full md:w-auto">
            <div class="dropdown dropdown-left">
                <div tabindex="0" role="button" class="btn btn-ghost m-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li>
                        <a
                            href="{{ route('dashboard.product.index', ['sort' => 'created_at', 'direction' => 'desc', 'search' => $search]) }}">
                            <input type="radio" name="sort-direction" class="radio radio-secondary"
                                {{ request('sort') == 'created_at' && request('direction') == 'desc' ? 'checked' : '' }}>
                            Terbaru
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('dashboard.product.index', ['sort' => 'created_at', 'direction' => 'asc', 'search' => $search]) }}">
                            <input type="radio" name="sort-direction" class="radio radio-secondary"
                                {{ request('sort') == 'created_at' && request('direction') == 'asc' ? 'checked' : '' }}>
                            Terlama
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('dashboard.product.index', ['sort' => 'name', 'direction' => 'asc', 'search' => $search]) }}">
                            <input type="radio" name="sort-direction" class="radio radio-secondary"
                                {{ request('sort') == 'name' && request('direction') == 'asc' ? 'checked' : '' }}>
                            Nama A-Z
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('dashboard.product.index', ['sort' => 'name', 'direction' => 'desc', 'search' => $search]) }}">
                            <input type="radio" name="sort-direction" class="radio radio-secondary"
                                {{ request('sort') == 'name' && request('direction') == 'desc' ? 'checked' : '' }}>
                            Nama Z-A
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Form Pencarian -->
            <form action="{{ route('dashboard.product.index') }}" method="GET" class="flex items-center mr-2">
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
            <a href="{{ route('dashboard.product.tambah') }}" class="btn btn-primary">
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
    <div class="container mx-auto">
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
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" id="select-all-checkbox" class="checkbox checkbox-primary" />
                                </label>
                            </th>
                            <th>Nama</th>
                            <th>Dilihat</th>
                            <th>Status</th>
                            @if (auth()->user()->hasRole('seller'))
                                <th>Status Verifikasi</th>
                            @endif
                            @if (auth()->user()->hasRole('admin'))
                                <th>Dibuat</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-primary" />
                                    </label>
                                </th>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if ($product->images->isNotEmpty())
                                            <div class="avatar">
                                                <div class="mask mask-squircle h-12 w-12">
                                                    <img src="{{ $product->images->first()->image_url }}"
                                                        alt="{{ $product->name }}" class="h-12 w-12 object-cover">
                                                </div>
                                            </div>
                                        @else
                                            <div class="avatar">
                                                <div class="mask mask-squircle h-12 w-12">
                                                    <img src="https://placehold.co/400" alt="Placeholder"
                                                        class="h-12 w-12 object-cover">
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold">{{ $product->name }}</div>
                                            <div class="text-sm opacity-50">{{ $product->category->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class=" size-3 inline-block ml-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                        @if ($product->view_count > 0)
                                            {{ $product->view_count }}x
                                        @else
                                            0x
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($product->active)
                                        <span class="badge badge-success badge-outline badge-sm">Aktif</span>
                                    @else
                                        <span class="badge badge-danger badge-outline badge-sm">Nonaktif</span>
                                    @endif
                                </td>
                                @if (auth()->user()->hasRole('seller'))
                                    <td>
                                        <span class="badge badge-{{ $product->is_verified ? 'success' : 'warning' }}">
                                            {{ $product->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                                        </span>
                                    </td>
                                @endif
                                <td>
                                    {{ $product->user->name }}
                                    <div class="text-xs opacity-50">
                                        {{ $product->created_at }}</div>
                                </td>
                                <td>
                                    <div class=" flex flex-wrap items-center space-x-2">
                                        @if (auth()->user()->hasRole('admin'))
                                            @if (!$product->is_verified)
                                                <form action="{{ route('product.verify', $product) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-success btn-xs">Verif</button>
                                                </form>
                                            @endif
                                        @endif
                                        <a class="btn btn-ghost btn-xs text-neutral"
                                            onclick="document.getElementById('viewModal{{ $product->id }}').showModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-4">
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
            <div class="mt-4">
                {{ $products->links('vendor.pagination.custom') }}
            </div>

        @endif
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
