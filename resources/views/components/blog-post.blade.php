<!-- resources/views/components/blog-post.blade.php -->
<div class="flex flex-col overflow-hidden hover:bg-neutral-200 rounded-lg">
    <a href="{{ route('blogs.show', $post->slug) }}" class="p-4">
        @if ($post->cover)
            <img class="aspect-video rounded-lg object-cover" src="{{ str_replace('public', 'storage', $post->cover) }}"
                alt="{{ $post->title }}" loading="lazy" />
        @else
            <img class="aspect-video rounded-lg object-cover" src="https://placehold.co/400" alt="{{ $post->title }}"
                loading="lazy" />
        @endif
    </a>
    <div class="p-4 flex flex-col justify-between">
        <div>
            <p class="text-gray-600 text-xs">{{ $post->created_at->format('M d, Y') }}</p>
            <p class="text-lg font-bold">
                <a href="{{ route('blogs.show', $post->slug) }}" class="text-black hover:underline">
                    {{ Str::limit($post->title, 50) }}
                </a>
            </p>
            <p class="text-gray-600">{!! Str::limit(strip_tags($post->content), 100) !!}</p>
        </div>
        <div class="flex flex-row items-center mt-4">
            <img class="h-8 w-8 rounded-full object-cover"
                src="{{ $post->author->avatar ?? 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg' }}"
                alt="{{ $post->author }}" loading="lazy">
            <div class="ml-2 text-sm">
                <p class="text-gray-800">{{ $post->author }}</p>
            </div>
        </div>
    </div>
</div>
