<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Create New Blog Post') }}
            </h4>
        </div>
        <div class="mt-4">
            <a href="{{ route('blogs.index') }}" class="btn btn-ghost">Kembali</a>
            <button id="createButton" type="button" class="btn btn-primary">Create</button>
        </div>
    </div>

    <div class="container">
        <form id="blogForm" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Validation Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-wrap">
                <div class="w-full lg:w-2/3 shadow bg-white rounded-lg py-4 px-5">
                    <div class="form-group">
                        <label for="title" class="block text-gray-700 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" class="input input-bordered w-full" id="title" name="title"
                            value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="author" class="block text-gray-700 mb-2">Author <span
                                class="text-red-500">*</span></label>
                        <input type="text" class="input input-bordered w-full" id="author" name="author"
                            value="{{ old('author') }}" required>
                    </div>
                </div>

                <div class="w-full lg:w-1/3 shadow bg-white rounded-lg py-4 px-5 mt-6 lg:mt-0">
                    <div class="form-group">
                        <label for="cover" class="block text-gray-700 mb-2">Upload Cover <span
                                class="text-red-500">*</span></label>
                        <div id="upload-container"
                            class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 h-56 flex items-center justify-center">
                            <input type="file" id="cover" name="cover"
                                class="absolute z-50 inset-0 w-full h-full opacity-0 cursor-pointer" required
                                onchange="previewImage(event)">
                            <div id="upload-label"
                                class="flex flex-col items-center justify-center text-gray-500 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm6 1a1 1 0 00-1 1v4H7a1 1 0 100 2h2v4a1 1 0 102 0v-4h2a1 1 0 100-2h-2V5a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Upload Cover</span>
                            </div>
                            <img id="image-preview"
                                class="hidden absolute top-0 left-0 w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-6 shadow bg-white rounded-lg py-4 px-5">
                <label for="content" class="block text-gray-700 mb-2">Content <span
                        class="text-red-500">*</span></label>
                <textarea class="input ckeditor input-bordered w-full" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <!-- Tombol Submit (sembunyikan, digunakan untuk trigger) -->
            <button id="submitButton" type="submit" class="hidden"></button>

        </form>
    </div>

    <script>
        // Fungsi untuk preview gambar
        function previewImage(event) {
            const reader = new FileReader();
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const label = document.getElementById('upload-label');

            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                label.classList.add('hidden');
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
                label.classList.remove('hidden');
            }
        }

        // Event listener untuk tombol "Create"
        document.getElementById('createButton').addEventListener('click', function() {
            // Trigger submit form
            document.getElementById('submitButton').click();
        });
    </script>
</x-dashboard-layout>
