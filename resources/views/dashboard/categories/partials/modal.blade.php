@foreach ($categories as $category)
    <!-- Modal Hapus category -->
    <dialog id="deleteModal{{ $category->id }}" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    onclick="closeModal('deleteModal{{ $category->id }}')">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hapus category</h3>
            <p class="py-4">Anda yakin ingin menghapus category {{ $category->name }} ?</p>
            <div class="modal-action">
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-md">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Modal Edit category -->
    <dialog id="editModal{{ $category->id }}" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    onclick="closeModal('editModal{{ $category->id }}', {{ $category->id }})">✕</button>
            </form>
            <h3 class="text-lg font-bold">Edit category</h3>
            <div class="py-4">
                <form action="{{ route('categories.update', $category->id) }}" method="POST"
                    id="editForm{{ $category->id }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name{{ $category->id }}" class="block text-sm font-medium text-gray-700">Nama
                            Kategori</label>
                        <input type="text" name="name" id="name{{ $category->id }}"
                            value="{{ old('name', $category->name) }}" class="input input-bordered w-full"
                            oninput="updateSlug('editModal{{ $category->id }}')">
                    </div>
                    <div class="mb-4">
                        <label for="slug{{ $category->id }}"
                            class="block text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" name="slug" id="slug{{ $category->id }}"
                            value="{{ old('slug', $category->slug) }}" class="input input-bordered w-full" disabled>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
@endforeach


<!-- Modal Create category -->
<dialog id="createModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="closeModal('createModal')">✕</button>
        </form>
        <h3 class="text-lg font-bold">Tambah category Baru</h3>
        <div class="py-4">
            <form action="{{ route('categories.store') }}" method="POST" id="createForm">
                @csrf
                <div class="mb-4">
                    <label for="nameCreate" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                    <input type="text" name="name" id="nameCreate" class="input input-bordered w-full"
                        oninput="updateSlug('createModal')">
                </div>
                <div class="mb-4">
                    <label for="slugCreate" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slugCreate" class="input input-bordered w-full" disabled>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</dialog>

<script>
    function updateSlug(modalId) {
        const nameInput = document.querySelector(`#${modalId} [name="name"]`);
        const slugInput = document.querySelector(`#${modalId} [name="slug"]`);
        const slug = nameInput.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        slugInput.value = slug;
    }

    function closeModal(modalId, categoryId = null) {
        const modal = document.getElementById(modalId);
        modal.close();

        if (categoryId) {
            const form = document.getElementById(`editForm${categoryId}`);
            form.reset();
        } else {
            const createForm = document.getElementById('createForm');
            createForm.reset();
        }
    }
</script>
