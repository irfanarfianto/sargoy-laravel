<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Carousel Management') }}
            </h4>
        </div>
        <div class="flex items-center justify-between w-full md:w-auto">
            <a href="{{ route('carousels.create') }}" class="btn btn-primary">Create New <svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg></a>
        </div>
    </div>
    <div class="container mx-auto">
        @if (count($carousels) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($carousels as $carousel)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold mb-2">{{ $carousel->title }}</h3>
                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="{{ $carousel->title }}"
                            class="w-full h-32 object-cover mb-2 rounded-lg">

                        <div class="flex justify-between">
                            <a href="{{ route('carousels.show', $carousel->id) }}"
                                class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('carousels.edit', $carousel->id) }}"
                                class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('carousels.destroy', $carousel->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error"
                                    onclick="return confirm('Are you sure you want to delete this carousel item?')">Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No carousels found.</p>
        @endif
    </div>
</x-dashboard-layout>
