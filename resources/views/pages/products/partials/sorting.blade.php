<x-modal id="filterproduk" title="Fitler Produk">
    <form action="{{ route('product.page') }}" method="GET" class="space-y-4">
        <div class="flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
            </svg>
            <h3 class="">Urutkan</h3>
        </div>
        <div class="flex items-center space-x-2">
            <button type="submit" name="filter" value="terbaru"
                class="btn btn-sm {{ $filter == 'terbaru' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                @if ($filter == 'terbaru')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                @endif
                Terbaru
            </button>
            <button type="submit" name="filter" value="populer"
                class="btn btn-sm {{ $filter == 'populer' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                @if ($filter == 'populer')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                @endif
                Populer
            </button>
        </div>


        <div class="flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
            </svg>
            <h3 class="">Kategori</h3>
        </div>
        <div>
            @foreach ($categories as $cat)
                <a href="{{ route('product.page', ['category' => $cat->slug, 'search' => $search, 'filter' => $filter]) }}"
                    class="btn btn-ghost btn-sm {{ $category === $cat->slug ? 'btn-primary' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
            <a href="{{ route('product.page', ['search' => $search, 'filter' => $filter]) }}"
                class="btn btn-ghost btn-sm  {{ $category === null ? 'btn-primary' : '' }}">
                Semua Kategori
            </a>
        </div>
    </form>
</x-modal>
