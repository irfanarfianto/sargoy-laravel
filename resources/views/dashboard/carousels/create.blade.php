<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Create New Carousel Item') }}
            </h4>
        </div>
        <div class="flex items-center justify-between w-full md:w-auto">
             <button type="submit" form="create" class="btn btn-primary">Create Carousel</button>
        </div>
    </div>
    <div class="container mx-auto">
        <form id="create" action="{{ route('carousels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="input input-bordered w-full" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="textarea textarea-bordered w-full" rows="5"
                    placeholder="Enter carousel description"></textarea>
            </div>
            <div class="mb-4">
                <label for="target_url" class="block text-sm font-medium text-gray-700">Target URL</label>
                <input type="url" name="target_url" id="target_url" class="input input-bordered w-full"
                    value="{{ old('target_url', $carousel->target_url ?? '') }}" placeholder="Enter target URL">
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="file-input file-input-bordered w-full"
                    required>
                @error('image')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
</x-dashboard-layout>
