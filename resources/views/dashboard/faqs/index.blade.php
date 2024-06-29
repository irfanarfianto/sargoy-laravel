<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Produk') }}
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
        {{-- Hanya tampilkan untuk admin --}}
        @if (auth()->user()->hasRole('admin'))
            <div class="flex items-center justify-between w-full md:w-auto">
                <a onclick="document.getElementById('createModal').showModal()" class="btn btn-primary">
                    <span class="hidden sm:inline">Tambah Faqs</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </a>
            </div>
            <div class="container mx-auto">
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
                        <x-table :headers="['Question', 'Answer', 'Actions']" :rows="$faqs
                            ->map(function ($faq) {
                                return [
                                    'question' => Str::limit($faq->question, 20),
                                    'answer' => Str::limit($faq->answer, 50),
                                    'actions' => view('components.faq-actions', compact('faq')),
                                ];
                            })
                            ->toArray()" />
                        @include('dashboard.faqs.partials.modal')
                        <div class="mt-4">
                            {{ $faqs->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @endisset
            </div>
        @endif
        {{-- Tampilkan accordion untuk seller --}}
        @if (auth()->user()->hasRole('seller'))
            <div class="container mx-auto flex flex-col lg:flex-row lg:space-x-4">
                <div class="lg:w-3/4 order-2 lg:order-1">
                    @isset($error)
                        <p class="text-red-500">{{ $error }}</p>
                    @else
                        @if ($faqs->isEmpty())
                            <div class="flex bg-gray-400 w-full px-2 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
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
                            <div class="mt-4">
                                {{ $faqs->links('vendor.pagination.custom') }}
                            </div>
                        @endif
                    @endisset
                </div>
                <div class="lg:w-1/4 bg-base-100 order-1 lg:order-2 mb-4 lg:mb-0 ">
                    <div class="bg-base-200 text-neutral p-4 rounded-lg">
                        <h3 class="text-lg font-bold">Butuh Bantuan?</h3>
                        <p class="text-sm">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi admin.</p>
                        <a href="" class="btn btn-secondary mt-2">Hubungi
                            Admin</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-dashboard-layout>
