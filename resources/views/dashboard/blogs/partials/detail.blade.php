<dialog id="detailModal{{ $post->id }}" class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
        <div class="flex flex-row justify-between items-center">
            <h3 class="text-lg font-bold">Details Blog</h3>
            <div class="modal-action">

                @if ($post->recommended)
                    <form action="{{ route('blogs.unmarkAsRecommended', $post->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning btn-outline">Batal Rekomendasi</button>
                    </form>
                @else
                    <form action="{{ route('blogs.markAsRecommended', $post->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Rekomendasikan</button>
                    </form>
                @endif
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
            </div>
        </div>

        <p><strong>Title:</strong> {{ $post->title }}</p>
        <p><strong>Author:</strong> {{ $post->author }}</p>
        <p><strong>Created At:</strong> {{ $post->created_at->format('d M Y') }}</p>
        <p><strong>Content:</strong></p>
        <div class="border border-gray-300 p-2 rounded-lg">
            {!! $post->content !!}
        </div>
        <p><strong>Tags:</strong></p>
        @if ($post->tags)
            @php
                $tags = json_decode($post->tags);
            @endphp
            @foreach ($tags as $tag)
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mt-2">#{{ $tag }}</span>
            @endforeach
        @endif
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
