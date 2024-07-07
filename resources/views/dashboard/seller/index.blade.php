<x-dashboard-layout>
    <div class="pt-14">
        <h4 class=" text-xl font-bold text-gray-900">
            {{ __('Dashboard Seller') }}
        </h4>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        <x-statistic-card title="Produk Terverifikasi" value="{{ number_format($verifiedProductCount, 0, ',', '.') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </x-statistic-card>
        <x-statistic-card title="Produk Belum Terverifikasi"
            value="{{ number_format($unverifiedProductCount, 0, ',', '.') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
        </x-statistic-card>
        <x-statistic-card title="Total Engagement" value="{{ number_format($totalEngagement, 0, ',', '.') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
            </svg>
        </x-statistic-card>
    </div>
    <div class="shadow bg-white rounded-lg py-4 px-5 mt-6">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold">Produk Populer</h3>
            <!-- Filter Dropdown -->
            <div class="flex items-center">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                        <span class="hidden md:inline">
                            @if ($filter == 'populer')
                                Produk Terpopuler
                            @elseif($filter == 'ulasan')
                                Ulasan Terbanyak
                            @endif
                        </span>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                        <li>
                            <a href="{{ route('seller', ['filter' => 'populer']) }}"
                                class="flex items-center {{ $filter === 'populer' ? 'font-bold' : '' }}">
                                <span>Produk Terpopuler</span>
                                @if ($filter === 'populer')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-4 h-4 ml-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('seller', ['filter' => 'ulasan']) }}"
                                class="flex items-center {{ $filter === 'ulasan' ? 'font-bold' : '' }}">
                                <span>Ulasan Terbanyak</span>
                                @if ($filter === 'ulasan')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="w-4 h-4 ml-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">#</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">
                            @if ($filter === 'populer')
                                Dilihat
                            @elseif ($filter === 'ulasan')
                                Ulasan
                            @endif
                        </th>

                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($products as $product)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="{{ $product->images->first()->image_url ?? 'https://placehold.co/400' }}"
                                                alt="{{ $product->name }}" class="h-12 w-12 object-cover">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold truncate w-40">{{ $product->name }}</div>
                                        <div class="text-sm opacity-50">{{ $product->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                @if ($filter === 'populer')
                                    <p class="text-xs items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3 inline-block">
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
                                @elseif ($filter === 'ulasan')
                                    <p class="text-xs items-center">
                                        {{ $product->reviews->count() }} ulasan
                                        @if ($product->reviews->count() > 0)
                                            dengan rating tertinggi {{ $product->reviews->max('rating') }}
                                        @endif
                                    </p>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-left">
                                @if (!$product->is_verified)
                                    @if (auth()->user()->hasRole('seller'))
                                        <span class="badge badge-red">Belum Diverifikasi</span>
                                    @endif
                                @else
                                    @if ($product->status)
                                        <span class="badge badge-success badge-outline badge-sm">Aktif</span>
                                    @else
                                        <span class="badge badge-danger badge-outline badge-sm">Nonaktif</span>
                                    @endif
                                @endif
                            </td>
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
                                        </svg> Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @include('dashboard.product.partials.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
