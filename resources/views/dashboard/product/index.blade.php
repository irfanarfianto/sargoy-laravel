<x-dashboard-layout>
    <div class="pt-14 flex w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
        <div class="flex items-center">
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
                    <!-- Tambahkan opsi pengurutan lainnya sesuai kebutuhan -->
                </ul>
            </div>
            <a href="{{ route('dashboard.product.tambah') }}" class="btn btn-primary">Tambah Produk</a>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="container mx-auto">
        @if ($products->isEmpty())
            <p class="text-center text-gray-600 mt-8">Produk yang Anda cari tidak ditemukan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox" />
                                </label>
                            </th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox" />
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
                                    {{ $product->price }}
                                </td>
                                <td>
                                    @if ($product->active)
                                        <span class="badge badge-success badge-outline badge-sm">Aktif</span>
                                    @else
                                        <span class="badge badge-danger badge-outline badge-sm">Nonaktif</span>
                                    @endif
                                </td>

                                <th>
                                    <a href="{{ route('dashboard.product.edit', $product->slug) }}"
                                        class="text-indigo-600 hover:text-indigo-900 btn btn-ghost btn-xs">Edit</a>
                                    <a class="btn btn-ghost btn-xs text-error"
                                        onclick="my_modal_1.showModal()">Hapus</a>

                                </th>
                            </tr>
                        @endforeach
                </table>
            </div>
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Hapus -->
    <dialog id="my_modal_1" class="modal modal-bottom sm:modal-middle">
        @foreach ($products as $product)
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold">Hapus Produk?</h3>
                <p class="py-4">Anda yakin ingin menghapus produk ini ?</p>
                <div class="modal-action">
                    <form action="{{ route('dashboard.product.hapus', $product->slug) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-error btn-md">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </dialog>
</x-dashboard-layout>
