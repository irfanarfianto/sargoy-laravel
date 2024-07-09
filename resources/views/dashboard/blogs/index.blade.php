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

        <div class="overflow-x-auto">
            <table class="table table-zebra min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <div class="flex flex-col gap-1">
                                    {{ Str::limit($post->title, 50) }}
                                    <div class="flex flex-warp">
                                        @if ($post->tags)
                                            @php
                                                $tags = json_decode($post->tags);
                                            @endphp

                                            @foreach ($tags as $tag)
                                                <span class="badge text-xs mr-1">#{{ $tag }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $post->author }}</td>
                            <td>{{ $post->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($post->recommended)
                                    <span>
                                        <span class="badge badge-success badge-outline badge-sm">Rekomendasi</span>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-ghost btn-xs"
                                    onclick="document.getElementById('detailModal{{ $post->id }}').showModal()">Detail</a>
                                <a href="{{ route('blogs.edit', $post->slug) }}" class="btn btn-ghost btn-xs">Edit</a>
                                <a class="btn btn-error btn-xs"
                                    onclick="document.getElementById('delete{{ $post->id }}').showModal()">Hapus</a>
                            </td>
                        </tr>
                        @include('dashboard.blogs.partials.hapus')
                        @include('dashboard.blogs.partials.detail')
                    @endforeach
                </tbody>
            </table>
        </div>

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
