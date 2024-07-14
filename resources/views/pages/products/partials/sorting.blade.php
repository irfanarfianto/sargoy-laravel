<x-modal id="filterproduk" title="Fitler Berdasarkan">
    <form action="{{ route('product.page') }}" method="GET" class="space-y-4">
        <div class="flex flex-col items-start space-y-2">
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
            <button type="submit" name="filter" value="rating_tertinggi"
                class="btn btn-sm {{ $filter == 'rating_tertinggi' ? 'btn-ghost btn-outline' : 'btn-ghost' }}">
                @if ($filter == 'rating_tertinggi')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                @endif
                Rating Tertinggi
            </button>
        </div>
    </form>
</x-modal>
