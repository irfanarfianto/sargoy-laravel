<x-dashboard-layout>
    <div class="pt-14 flex flex-wrap w-full justify-between items-start">
        <div class="flex flex-col mb-5">
            <x-breadcrumb :items="$breadcrumbItems" />
            <h4 class="text-xl font-bold text-gray-900">
                {{ __('User Management') }}
            </h4>
        </div>
        <form action="{{ route('users.index') }}" method="GET" class="flex items-center mr-2 w-full lg:w-1/4">
            <div class="relative flex-grow">
                <input type="text" class="rounded-l-md input input-bordered w-full py-2 px-4" name="search"
                    value="{{ $search }}" placeholder="Search" />
                <button type="submit" class=" absolute right-0 top-0 bottom-0 px-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </form>
        <div class="overflow-x-auto w-full">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                                alt="Avatar of {{ $user->name }}" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $user->name }}</div>
                                        <div class="text-sm opacity-50">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-ghost badge-sm">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="flex space-x-2">
                                    @if (Auth::user()->hasRole('demo_admin'))
                                        <button class="btn btn-ghost btn-xs"
                                            onclick="document.getElementById('Forbidden').showModal()">
                                            Edit
                                        </button>
                                        <button class="btn btn-ghost btn-xs text-error"
                                            onclick="document.getElementById('Forbidden').showModal()">
                                            Hapus
                                        </button>
                                    @endif

                                    @if (Auth::user()->hasRole('admin'))
                                        <button class="btn btn-ghost btn-xs"
                                            {{ $user->hasRole('admin') ? 'disabled' : '' }}
                                            onclick="document.getElementById('editModal{{ $user->id }}').showModal()">
                                            Edit
                                        </button>
                                        <a class="btn btn-ghost btn-xs text-error"
                                            {{ $user->hasRole('admin') ? 'disabled' : '' }}
                                            onclick="document.getElementById('deleteModal{{ $user->id }}').showModal()">
                                            Hapus
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- Modal untuk Edit -->
                        <dialog id="editModal{{ $user->id }}" class="modal modal-bottom sm:modal-middle">
                            <div class="modal-box">
                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                    onclick="document.getElementById('editModal{{ $user->id }}').close()">✕</button>
                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <h3 class="text-lg font-bold">Edit Pengguna</h3>
                                    <div class="modal-body">
                                        <label for="name" class="block">Nama:</label>
                                        <input type="text" id="name" name="name" value="{{ $user->name }}"
                                            class="input input-bordered w-full" disabled>

                                        <label for="email" class="block mt-2">Email:</label>
                                        <input type="email" id="email" name="email" value="{{ $user->email }}"
                                            class="input input-bordered w-full" disabled>

                                        <label for="roles" class="block mt-2">Role:</label>
                                        <select name="roles[]" class="select select-bordered w-full"
                                            {{ $user->hasRole('admin') ? 'disabled' : '' }}>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </dialog>

                        <!-- Modal untuk Hapus -->
                        <dialog id="deleteModal{{ $user->id }}" class="modal modal-bottom sm:modal-middle">
                            <div class="modal-box">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                                        onclick="document.getElementById('deleteModal{{ $user->id }}').close()">✕</button>
                                </form>
                                <h3 class="text-lg font-bold">Hapus Pengguna?</h3>
                                <p class="py-4">Anda yakin ingin menghapus pengguna {{ $user->name }}?</p>
                                <div class="modal-action">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error btn-md">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    @empty
                        <tr>
                            <td colspan="3">
                                <p class="text-center text-neutral mt-8">Pengguna yang Anda cari tidak ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->total() > 10)
            <div class="mt-4 w-full">
                {{ $users->onEachSide(1)->links('vendor.pagination.custom') }}
            </div>
        @endif

    </div>
</x-dashboard-layout>
