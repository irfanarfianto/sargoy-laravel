@foreach ($categories as $category)
    <!-- Modal Hapus category -->
    <dialog id="deleteModal{{ $category->slug }}" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    onclick="closeModal('deleteModal{{ $category->slug }}')">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hapus category</h3>
            <p class="py-4">Anda yakin ingin menghapus category {{ $category->name }} ?</p>
            <div class="modal-action">
                <form action="{{ route('categories.destroy', $category->slug) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-md">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Modal Edit category -->
    <dialog id="editModal{{ $category->slug }}" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="text-lg font-bold">Edit Kategori</h3>
            <div class="py-4">
                <form action="{{ route('categories.update', $category->slug) }}" method="POST"
                    id="editForm{{ $category->slug }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-3">
                        <div class="mb-4">
                            <label for="name{{ $category->slug }}" class="block text-sm font-medium text-gray-700">Nama
                                Kategori</label>
                            <input type="text" name="name" id="name{{ $category->slug }}"
                                value="{{ old('name', $category->name) }}" class="input input-bordered w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="slug{{ $category->slug }}"
                                class="block text-sm font-medium text-gray-700">Slug</label>
                            <input type="text" name="slug" id="slug{{ $category->slug }}"
                                value="{{ $category->slug }}" class="input input-bordered w-full" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="description{{ $category->slug }}"
                            class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description{{ $category->slug }}" class="textarea textarea-bordered w-full"
                            rows="5" placeholder="Masukkan deskripsi produk">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image{{ $category->slug }}"
                            class="block text-sm font-medium text-gray-700">Gambar</label>
                        <input type="file" name="image" id="image{{ $category->slug }}"
                            class="file-input file-input-bordered w-full"
                            onchange="previewImage('editModal{{ $category->slug }}')">
                        @if ($category->image)
                            <div class="avatar mt-5">
                                <div class="w-24 rounded">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" />
                                </div>
                            </div>
                        @endif
                        @error('image')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="btn btn-ghost"
                            onclick="closeModal('editModal{{ $category->slug }}')">Batal</button>
                        <x-loading-button data-loading-text="Memperbarui...">
                            Perbarui
                        </x-loading-button>
                    </div>
                </form>
            </div>
            <!-- Form end -->
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editForm{{ $category->slug }} = document.getElementById('editForm{{ $category->slug }}');
            if (editForm{{ $category->slug }}) {
                const slugInput{{ $category->slug }} = document.getElementById('slug{{ $category->slug }}');
                const nameInput{{ $category->slug }} = document.getElementById('name{{ $category->slug }}');

                nameInput{{ $category->slug }}.addEventListener('input', function() {
                    const nameValue{{ $category->slug }} = nameInput{{ $category->slug }}.value.trim()
                        .toLowerCase().replace(/\s+/g, '-');
                    slugInput{{ $category->slug }}.value = nameValue{{ $category->slug }};
                });
            }
        });
    </script>
@endforeach

<!-- Modal Create category -->
<dialog id="createModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
        <!-- Form start -->
        <form action="{{ route('categories.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap gap-2">
                <div class="mb-4 lg:w-1/2">
                    <label for="nameCreate" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" id="nameCreate" class="input input-bordered w-full" required>
                </div>
                <div class="mb-4 lg:w-1/3">
                    <label for="slugCreate" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slugCreate" class="input input-bordered w-full" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="descriptionCreate" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="descriptionCreate" class="textarea textarea-bordered w-full" rows="5"
                    placeholder="Masukkan deskripsi produk"></textarea>
            </div>
            <div class="mb-4">
                <label for="imageCreate" class="block text-sm font-medium text-gray-700">Gambar</label>
                <input type="file" name="image" id="imageCreate" class="file-input file-input-bordered w-full"
                    onchange="previewImage('createModal')">
                <img id="imagePreviewCreate" src="" alt="Preview" style="display: none;" class="mt-2"
                    width="100">
                @error('image')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="btn btn-ghost" onclick="closeModal('createModal')">Batal</button>
                <x-loading-button data-loading-text="Menyimpan...">
                    Simpan
                </x-loading-button>
            </div>
        </form>
        <!-- Form end -->
    </div>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const createForm = document.getElementById('createForm');
        if (createForm) {
            const slugInput = document.getElementById('slugCreate');
            const nameInput = document.getElementById('nameCreate');

            nameInput.addEventListener('input', function() {
                const nameValue = nameInput.value.trim().toLowerCase().replace(/\s+/g, '-');
                slugInput.value = nameValue;
            });
        }
    });
</script>


<script>
    function previewImage(modalId) {
        const input = document.querySelector(`#${modalId} [name="image"]`);
        const preview = document.getElementById(
            `imagePreview${modalId === 'createModal' ? 'Create' : modalId.replace('editModal', '')}`);

        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

    function closeModal(modalId, slug = null) {
        const modal = document.getElementById(modalId);
        modal.close();

        if (slug) {
            const form = document.getElementById(`editForm${slug}`);
            if (form) {
                form.reset();
                const imagePreview = document.getElementById(`imagePreview${slug}`);
                if (imagePreview) {
                    imagePreview.style.display = 'none';
                }
            }
        } else {
            const createForm = document.getElementById('createForm');
            if (createForm) {
                createForm.reset();
                const imagePreviewCreate = document.getElementById('imagePreviewCreate');
                if (imagePreviewCreate) {
                    imagePreviewCreate.style.display = 'none';
                }
            }
        }
    }
</script>
