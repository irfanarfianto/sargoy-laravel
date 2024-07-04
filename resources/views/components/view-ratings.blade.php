@props(['productReview'])

<button onclick="document.getElementById('{{ 'rating_modal_' . $productReview['product']->id }}').showModal()"
    class="btn btn-sm btn-primary">
    View Ratings
</button>

<x-modal :id="'rating_modal_' . $productReview['product']->id" title="{{ $productReview['review_count'] }} Ulasan">
    <!-- Isi konten modal -->
    <div>
        <div class="flex flex-row justify-between">
            <div class="flex items-center space-x-2">
                @if ($productReview['product']->images->isNotEmpty())
                    <div class="avatar">
                        <div class="mask mask-squircle h-12 w-12">
                            <img src="{{ $productReview['product']->images->first()->image_url ?? 'placeholder-image-url.jpg' }}"
                                alt="{{ $productReview['product']->name }}" class="h-12 w-12 object-cover">
                        </div>
                    </div>
                @else
                    <div class="avatar">
                        <div class="mask mask-squircle h-12 w-12">
                            <img src="https://placehold.co/400" alt="Placeholder" class="h-12 w-12 object-cover">
                        </div>
                    </div>
                @endif
                <div>
                    <h3 class="font-bold">{{ $productReview['product']->name }}</h3>
                    <p>{{ $productReview['product']->category->name }}</p>
                </div>
            </div>
            @include('components.rating-stars')
        </div>
        <div class="overflow-y-auto max-h-60">
            @foreach ($productReview['reviews'] as $review)
                <div class="border p-2 my-2">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="font-semibold">{{ $review['user']->name }}</h3>
                            <p class="text-xs text-base-500">{{ $review['created_at']->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 text-yellow-500 mr-1">
                                    <path fill-rule="evenodd"
                                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $review['rating'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-600">{{ $review['comment'] }}</div>
                </div>
            @endforeach
        </div>

    </div>
</x-modal>
