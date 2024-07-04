<!-- Modal Hapus -->
<dialog id="deleteModal{{ $product->id }}" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Hapus Produk?</h3>
        <p class="py-4">Anda yakin ingin menghapus produk {{ $product->name }} ?</p>
        <div class="modal-action">
            <form action="{{ route('dashboard.product.hapus', $product->slug) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-md">Hapus</button>
            </form>
        </div>
    </div>
</dialog>

<!-- Modal Lihat -->
<dialog id="viewModal{{ $product->id }}" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">{{ $product->name }}</h3>
        <p class="py-4">{{ $product->description }}</p>
        <div class="flex flex-col gap-2">
            <div>
                <span class="font-semibold">Harga:</span> {{ $product->price }}
            </div>
            <div>
                <span class="font-semibold">Kategori:</span>
                {{ $product->category->name }}
            </div>
            <div>
                <span class="font-semibold">Status:</span>
                @if (!$product->is_verified)
                    <span class="badge badge-red">Belum Diverifikasi</span>
                @else
                    @if ($product->status)
                        <span class="badge badge-success badge-outline badge-sm">Aktif</span>
                    @else
                        <span class="badge badge-danger badge-outline badge-sm">Nonaktif</span>
                    @endif
                @endif
            </div>
            @if ($product->material)
                <div>
                    <span class="font-semibold">Material:</span> {{ $product->material }}
                </div>
            @endif
            @if ($product->color)
                <div>
                    <span class="font-semibold">Warna:</span> {{ $product->color }}
                </div>
            @endif
            @if ($product->size)
                <div>
                    <span class="font-semibold">Ukuran:</span> {{ $product->size }}
                </div>
            @endif
            @if ($product->pattern)
                <div>
                    <span class="font-semibold">Pola:</span> {{ $product->pattern }}
                </div>
            @endif
            @if ($product->ecommerce_link)
                <div>
                    <span class="font-semibold">Link E-commerce:</span> <a href="{{ $product->ecommerce_link }}"
                        target="_blank" class="text-blue-500 underline">{{ $product->ecommerce_link }}</a>
                </div>
            @endif
        </div>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-primary">Tutup</button>
            </form>
        </div>
    </div>
</dialog>
