@foreach ($faqs as $faq)
    <!-- Modal Hapus FAQ -->
    <dialog id="deleteModal{{ $faq->id }}" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hapus FAQ</h3>
            <p class="py-4">Anda yakin ingin menghapus FAQ ?</p>
            <div class="modal-action">
                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error btn-md">Hapus</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Modal Edit FAQ -->
    <dialog id="editModal{{ $faq->id }}" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Edit FAQ</h3>
            <div class="py-4">
                <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <input type="text" name="question" id="question" value="{{ $faq->question }}"
                            class="input input-bordered w-full">
                    </div>
                    <div class="mb-4">
                        <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                        <textarea name="answer" id="answer" rows="4" class="input ckeditor input-bordered w-full max-w-xs">{{ $faq->answer }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
@endforeach

<!-- Modal Create FAQ -->
<dialog id="createModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Tambah FAQ Baru</h3>
        <div class="py-4">
            <form action="{{ route('faqs.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <input type="text" name="question" id="question" class="input input-bordered w-full">
                </div>
                <div class="mb-4">
                    <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                    <textarea name="answer" id="answer" rows="4" class="input ckeditor input-bordered w-full max-w-xs"></textarea>
                </div>
                <div id="ckeditor"></div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</dialog>
