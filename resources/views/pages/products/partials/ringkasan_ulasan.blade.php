<div class="flex flex-col items-center">
    <div class="flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-orange-400">
            <path fill-rule="evenodd"
                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                clip-rule="evenodd" />
        </svg>
        <h2 class=" text-5xl font-bold">
            {{ number_format($averageRating, 1) }}
            <span class="text-xl text-gray-500">/5.0</span>
        </h2>
    </div>
    <div class="flex items-center space-x-2">
        <div class="ml-2 text-sm text-gray-500">
            {{ $ratingPercentage }}% pembeli merasa puas
        </div>
        <div class="tooltip tooltip-left"
            data-tip="Dihitung dari jumlah rating positif (bintang 4 dan 5) dibagi dengan total rating.">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </div>
    </div>
</div>
<div class="text-sm text-gray-500">{{ $totalReviews }} ulasan</div>
<div class="mt-2 pr-0 lg:pr-2">
    @for ($i = 5; $i >= 1; $i--)
        <div class="flex items-center">
            <div class="ml-1 text-sm">{{ $i }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-3 text-orange-400">
                <path fill-rule="evenodd"
                    d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-1 w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-green-500 h-2.5 rounded-full"
                    style="width: {{ $totalReviews > 0 ? (($ratings[$i] ?? 0) / $totalReviews) * 100 : 0 }}%">
                </div>
            </div>
            <div class="ml-2 text-sm">{{ $ratings[$i] ?? 0 }}</div>
        </div>
    @endfor
</div>
