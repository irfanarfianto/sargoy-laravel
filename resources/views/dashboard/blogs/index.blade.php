<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('Blogs') }}
            </h4>
        </div>
        <div class="hidden lg:flex items-center justify-between w-full md:w-auto">
            <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create New Post</a>
        </div>
    </div>
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-zebra min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Recommended</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->author }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td>
                            @if ($post->recommended)
                                <form action="{{ route('blogs.unmarkAsRecommended', $post->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">Batal Rekomendasi</button>
                                </form>
                            @else
                                <form action="{{ route('blogs.markAsRecommended', $post->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Rekomendasikan</button>
                                </form>
                            @endif
                        </td>
                        <td>

                            <a href="{{ route('blogs.edit', $post->slug) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('blogs.destroy', $post->slug) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $posts->links('vendor.pagination.custom') }}
        </div>
        <div class="btm-nav shadow-lg z-50 flex lg:hidden ">
            <div class="px-4">
                <a href="{{ route('blogs.create') }}" class="btn btn-primary w-full">Create New Post</a>
            </div>
        </div>
    </div>
</x-dashboard-layout>
