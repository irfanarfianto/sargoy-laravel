@php
    $userName = Auth::user()->name;
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

<x-dashboard-layout>
    <div class="pt-14 w-full items-start">
        <div class="flex flex-col">
            <h4 class="text-xl font-bold text-gray-900">
                @if (auth()->user()->hasRole('admin'))
                    {{ __('Profile Admin') }}
                @elseif(auth()->user()->hasRole('seller'))
                    {{ __('Profile Seller') }}
                @else
                    {{ __('Profile') }}
                @endif
            </h4>
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
    </div>
    <div class="container mx-auto">
        @if (auth()->user()->hasRole('admin'))
            <div class="bg-white overflow-hidden rounded-lg p-6 border border-base-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="avatar">
                            <div class="mask mask-squircle h-20 w-20">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                    alt="Avatar of {{ $user->name }}" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="font-semibold">{{ $user->name }}</h4>
                            <p class="text-sm text-neutral-400">{{ $user->email }}</p>
                            <p class="text-sm text-neutral-400">{{ $profile ? $profile->position : 'Belum diisi' }}</p>
                        </div>
                    </div>
                    <div class="dropdown dropdown-left dropdown-hover">
                        <div tabindex="0" role="button" class="link link-secondary text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Edit
                        </div>
                        <ul tabindex="0"
                            class="dropdown-content menu bg-base-100 rounded-box z-50 w-52 p-2 shadow-lg">
                            <li>
                                <a onclick="document.getElementById('edit-admin').showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                    </svg>

                                    Edit Profile</a>
                            </li>
                            <li><a onclick="document.getElementById('edit-password').showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                    Ubah Password</a></li>
                            <li><a onclick="document.getElementById('delete-user').showModal()"
                                    class="hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    Hapus Akun</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        @elseif (auth()->user()->hasRole('seller'))
            <div class="bg-white overflow-hidden rounded-lg  p-6 border border-base-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="avatar">
                            <div class="mask mask-squircle h-20 w-20">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                    alt="Avatar of {{ $user->name }}" />
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="font-semibold">{{ $user->name }}</h4>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="dropdown dropdown-left dropdown-hover">
                        <div tabindex="0" role="button" class="link link-secondary text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Edit
                        </div>
                        <ul tabindex="0"
                            class="dropdown-content menu bg-base-100 rounded-box z-50 w-52 p-2 shadow-lg">
                            <li>
                                <a onclick="document.getElementById('edit-admin').showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                    </svg>

                                    Edit Profile</a>
                            </li>
                            <li><a onclick="document.getElementById('edit-password').showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                    Ubah Password</a></li>
                            <li><a onclick="document.getElementById('delete-user').showModal()"
                                    class="hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4 me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                    Hapus Akun</a></li>
                        </ul>
                    </div>
                </div>
                <p><strong>Nomor WhatsApp:</strong> {{ $profile ? $profile->no_wa : 'Belum diisi' }}</p>
                <p><strong>Alamat:</strong> {{ $profile ? $profile->alamat : 'Belum diisi' }}</p>
                <p><strong>Begabung pada:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        @endif
    </div>
    <x-modal id="edit-admin" title="Edit Profile">
        @include('dashboard.profile.partials.update-profile-information-form')
    </x-modal>
    <x-modal id="edit-seller" title="Edit Profile">
        @include('dashboard.profile.partials.update-profile-information-form')
    </x-modal>
    <x-modal id="edit-password" title="Ubah Password">
        @include('dashboard.profile.partials.update-password-form')
    </x-modal>
    <x-modal id="delete-user" title="Hapus Akun">
        @include('dashboard.profile.partials.delete-user-form')
    </x-modal>

    <script>
        function closeModal(modalId, categoryId = null) {
            const modal = document.getElementById(modalId);
            modal.close();

            if (categoryId) {
                const form = document.getElementById(`editForm${categoryId}`);
                form.reset();
                document.getElementById(`imagePreview${categoryId}`).style.display = 'none';
            } else {
                const createForm = document.getElementById('createForm');
                createForm.reset();
                document.getElementById('imagePreviewCreate').style.display = 'none';
            }
        }
    </script>
</x-dashboard-layout>
