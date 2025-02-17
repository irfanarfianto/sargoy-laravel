@props(['productReview'])

@php
    // Check if there are any unread reviews
    $hasUnreadReviews = $productReview['reviews']->contains(fn($review) => !$review['is_read']);
@endphp

<button onclick="document.getElementById('{{ 'rating_modal_' . $productReview['product']->id }}').showModal()"
    class="btn btn-sm btn-primary relative">
    View Ratings
    @if ($hasUnreadReviews)
        <span class="absolute top-0 right-0 inline-block w-3 h-3 bg-red-500 rounded-full"></span>
    @endif
</button>

<x-modal :id="'rating_modal_' . $productReview['product']->id" title="{{ $productReview['review_count'] }} Ulasan">
    <!-- Isi konten modal -->
    <div>
        <div class="flex flex-row justify-between">
            <div class="flex items-center space-x-2">

                <div class="avatar">
                    <div class="mask mask-squircle h-12 w-12">
                        <img src="{{ $productReview['product']->images->first()->image_url ?? 'https://placehold.co/400' }}"
                            alt="{{ $productReview['product']->name }}" class="h-12 w-12 object-cover">
                    </div>
                </div>
                <div>
                    <h3 class="font-bold">{{ $productReview['product']->name }}</h3>
                    <p>{{ $productReview['product']->category->name }}</p>
                </div>
            </div>
            @include('components.rating-stars')
        </div>

        @if ($productReview['reviews']->isEmpty())
            <p class="text-gray-600 mt-4">Belum ada ulasan untuk produk ini.</p>
        @else
            <div class="overflow-y-auto max-h-60 mt-4">
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
        @endif
    </div>
</x-modal>
<script>
    // Function to mark reviews as read when modal is closed
    function closeModalAndMarkRead(modalId, reviewIds) {
        // Ajax request to mark reviews as read
        reviewIds.forEach(reviewId => {
            fetch(`/mark-review-as-read/${reviewId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    is_read: true
                })
            });
        });
    }

    // Add event listener for modal close event
    const modal = document.getElementById('{{ 'rating_modal_' . $productReview['product']->id }}');
    modal.addEventListener('close', function() {
        // Get review IDs to mark as read
        const reviewIds = {{ $productReview['reviews']->pluck('id')->toJson() }};
        // Call function to mark reviews as read
        closeModalAndMarkRead('{{ 'rating_modal_' . $productReview['product']->id }}', reviewIds);
    });
</script>
