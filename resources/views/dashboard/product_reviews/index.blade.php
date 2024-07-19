<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Product Reviews') }}
            </h4>
        </div>
        <div class="flex items-center justify-end w-full md:w-auto">
            <!-- Dropdown untuk memilih kriteria sorting -->
            <details class="dropdown dropdown-end">
                <summary class="btn m-1"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>
                    {{ __('Urutkan') }}</summary>
                <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li>
                        <a href="{{ route('reviews.index', ['sort_by' => 'latest']) }}"
                            class="flex items-center justify-between">
                            {{ __('Terbaru') }}
                            @if (request()->get('sort_by') == 'latest')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviews.index', ['sort_by' => 'oldest']) }}"
                            class="flex items-center justify-between">
                            {{ __('Terlama') }}
                            @if (request()->get('sort_by') == 'oldest')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviews.index', ['sort_by' => 'highest_rating']) }}"
                            class="flex items-center justify-between">
                            {{ __('Rating Tertinggi') }}
                            @if (request()->get('sort_by') == 'highest_rating')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviews.index', ['sort_by' => 'lowest_rating']) }}"
                            class="flex items-center justify-between">
                            {{ __('Rating Terendah') }}
                            @if (request()->get('sort_by') == 'lowest_rating')
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </a>
                    </li>
                </ul>
            </details>

        </div>
    </div>
    <div class="container mx-auto shadow bg-white rounded-lg py-4 px-5">
        @if ($productReviews->isEmpty())
            <div class="flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p>{{ __('No reviews available at the moment.') }}</p>
            </div>
        @else
            <x-table :headers="['Produk', 'Jumlah Ulasan', 'Rata - Rata Rating', 'Actions']" :rows="$productReviews
                ->map(function ($productReview) {
                    return [
                        'name' => $productReview['product']->name,
                        'review_count' => $productReview['review_count'] . ' ulasan',
                        'average_rating' => view('components.rating-stars', [
                            'productReview' => $productReview,
                        ]),
                        'actions' => view('components.view-ratings', ['productReview' => $productReview]),
                    ];
                })
                ->toArray()" />
            <div class="mt-4">
                {{ $productReviews->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
