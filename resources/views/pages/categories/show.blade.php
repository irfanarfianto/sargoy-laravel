<x-app-layout>
    <x-breadcrumb :items="$breadcrumbItems" />
    <h2 class="text-2xl mt-8 text-center">{{ $category->name }}</h2>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-4 justify-center mt-4">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</x-app-layout>
