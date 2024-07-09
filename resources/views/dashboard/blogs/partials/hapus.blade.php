<x-modal id="delete{{ $post->id }}" title="Hapus Blog">
    <p class="py-4">Anda yakin ingin menghapus blog <br> <strong>{{ $post->title }}</strong> ?</p>
    <div class="modal-action">
        <form action="{{ route('blogs.destroy', $post->slug) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error btn-md">Hapus</button>
        </form>
    </div>
</x-modal>
