<x-dashboard-layout>
    <div class="pt-14">
        <h4 class="text-xl font-bold text-gray-900">
            {{ __('Dashboard Admin') }}
        </h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <x-statistic-card title="Total Pengguna" value="{{ number_format($userCount, 0, ',', '.') }}"
            description="{{ $totalSellers }} Penjual">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
        </x-statistic-card>
        <x-statistic-card title="Total Kategori" value="{{ $categoryCount }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
            </svg>
        </x-statistic-card>
        <x-statistic-card title="Total Produk" value="{{ $productCount }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
        </x-statistic-card>

        <div class="stats shadow bg-white rounded-lg">
            <div class="stat">
                <div class="flex items-center">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="stat-title">Total Pengunjung</div>
                        <div class="stat-value text-secondary">{{ number_format($totalVisits, 0, ',', '.') }}</div>
                        <div class="stat-desc">
                            @if ($percentChangeVisits > 0)
                                <span class='text-green-500'>+{{ number_format($percentChangeVisits, 2) }}%</span> dari
                                bulan sebelumnya
                            @elseif ($percentChangeVisits < 0)
                                <span class='text-red-500'>{{ number_format($percentChangeVisits, 2) }}%</span> dari
                                bulan sebelumnya
                            @else
                                Tidak ada perubahan dari bulan sebelumnya
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap-reverse justify-between">
        <div class="shadow bg-white rounded-lg py-4 px-5 mt-6 w-full lg:w-2/5">
            <h3 class="text-xl font-bold mb-4">Paling Banyak Dilihat</h3>
            <x-table :headers="['Produk', 'Dilihat', 'Pemilik']" :rows="$mostViewedProducts
                ->map(function ($product) {
                    return [
                        'Produk' => $product->name,
                        'Dilihat' => number_format($product->views_count, 0, ',', '.'),
                        'Pemilik' => $product->user->name,
                    ];
                })
                ->toArray()" />
        </div>
        <div class="shadow bg-white rounded-lg py-4 px-5 mt-6 w-full lg:w-7/12">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">Statistik Pengunjung</h3>
                @include('dashboard.admin.partials.filter')
            </div>
            <x-visit-chart :visitLabels="$visitLabels" :visitData="$visitData" :filter="$filter" />
        </div>
    </div>

    <div class="shadow bg-white rounded-lg py-4 px-5 mt-6">
        <h3 class="text-xl font-bold mb-4">Pengguna Baru</h3>
        <x-table :headers="['Name', 'Email', 'Created At']" :rows="$latestUsers
            ->map(function ($latestUsers) {
                return [
                    'name' => $latestUsers->name,
                    'email' => $latestUsers->email,
                    'created_at' => $latestUsers->created_at,
                ];
            })
            ->toArray()" />
    </div>
</x-dashboard-layout>
