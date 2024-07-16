<div class="overflow-hidden">
    <div class="relative overflow-hidden rounded-lg">
        <a href="{{ route('product.detail', $product->slug) }}">
            <img class="object-cover aspect-square"
                src="{{ Storage::url($product->images->first()->image_url) ?? 'https://placehold.co/400' }}" loading="lazy"
                alt="{{ $product->name }}" />
        </a>
    </div>
    <div class="px-4 py-4">
        <a href="{{ route('product.detail', $product->slug) }}" class="hover:underline">
            <h2 class="text-md line-clamp-2">{{ $product->name }}</h2>
        </a>
        <div class="rating items-center">
            @php
                $rating = $product->average_rating; 
                $maxRating = 5;
                $filledStars = intval($rating);
                $emptyStars = $maxRating - $filledStars;
            @endphp

            @for ($i = 0; $i < $filledStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-4 text-orange-400">
                    <path fill-rule="evenodd"
                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                        clip-rule="evenodd" />
                </svg>
            @endfor

            @for ($i = 0; $i < $emptyStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-4 text-gray-300">
                    <path fill-rule="evenodd"
                        d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                        clip-rule="evenodd" />
                </svg>
            @endfor
            <span class="ml-2 text-sm text-gray-500">({{ $product->reviews->count() }})</span>

        </div>
    </div>
</div>
