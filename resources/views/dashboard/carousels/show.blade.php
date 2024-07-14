<x-dashboard-layout>
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-bold mb-6">Carousel Item - {{ $carousel->title }}</h2>

        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-2">{{ $carousel->title }}</h3>
            <img src="{{ asset('storage/' . $carousel->image) }}" alt="{{ $carousel->title }}"
                class="w-full h-64 object-cover mb-4 rounded-lg">

            <p class="mb-4">{{ $carousel->description }}</p>

            <div class="flex justify-end">
                <a href="{{ route('carousels.edit', $carousel->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('carousels.destroy', $carousel->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error"
                        onclick="return confirm('Are you sure you want to delete this carousel item?')">Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-layout>
