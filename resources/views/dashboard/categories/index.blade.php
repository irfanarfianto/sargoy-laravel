<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Daftar Kategori') }}
            </h4>
        </div>
        <div class="flex items-center justify-between w-full md:w-auto">
            <a onclick="document.getElementById('createModal').showModal()" class="btn btn-primary">
                <span class="hidden sm:inline">Tambah Kategori</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </a>
        </div>
    </div>

    <div class="container mx-auto">
        @if ($categories->isEmpty())
            <div class="flex bg-gray-400 w-full px-2 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <p>{{ __('No categories available at the moment.') }}</p>
            </div>
        @else
                <x-table :headers="['Name', 'Slug', 'Actions']" :rows="$categories
                    ->map(function ($category) {
                        return [
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'actions' => view('components.category-actions', compact('category')),
                        ];
                    })
                    ->toArray()" />
                @include('dashboard.categories.partials.modal')
            <div class="mt-4">
                {{ $categories->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</x-dashboard-layout>
