<x-app-layout>
    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('FAQs') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>
    <div class="container max-w-4xl mx-auto flex flex-col">
        <div class="py-10 text-2xl text-start font-bold">
            {{ __('FAQs') }}
        </div>
        @isset($error)
            <p class="text-red-500">{{ $error }}</p>
        @else
            @if ($faqs->isEmpty())
                <div class="flex bg-gray-400 w-full px-2 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p>{{ __('No FAQs available at the moment.') }}</p>
                </div>
            @else
                @foreach ($faqs as $index => $faq)
                    <div class="collapse collapse-arrow bg-base-200 mb-2">
                        <input type="radio" id="accordion-{{ $index }}" name="my-accordion-2"
                            {{ $index === 0 ? 'checked' : '' }} />
                        <div class="collapse-title text-xl font-medium cursor-pointer"
                            onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked">
                            {{ $faq->question }}
                        </div>
                        <div class="collapse-content">
                            <p>{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        @endisset

    </div>
</x-app-layout>
