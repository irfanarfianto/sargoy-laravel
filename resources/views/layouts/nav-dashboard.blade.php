@php
    $userName = Auth::user()->name;
    $initials = strtoupper(substr($userName, 0, 1));
    $userRole = Auth::user()->roles()->first()->name;
@endphp

<div class="navbar bg-neutral px-5 fixed top-0 z-50">
    <div class="navbar-start flex items-center">
        <label for="my-drawer-2" class="btn btn-ghost drawer-button lg:hidden mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block text-base-100 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
        <a href="{{ route('home') }}" class="text-base-100 text-xl">Sargoy</a>
    </div>
    <div class="navbar-end space-x-6">
        <div>
            <a href="{{ route('pesan') }}" class="text-base-100 btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </a>
        </div>
        <div class="dropdown dropdown-end">
            <button tabindex="0" role="button" class="flex items-center gap-3">
                <div class="hidden lg:flex flex-col items-end">
                    <span class="hidden md:block text-base-100">{{ $userName }}</span>
                    @if ($userRole)
                        <span class="text-xs text-neutral-content">{{ ucfirst($userRole) }}</span>
                    @endif
                </div>
                <div class="avatar">
                    <div class="mask mask-squircle h-10 w-10">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($initials) }}"
                            alt="Avatar of {{ $initials }}" />
                    </div>
                </div>
            </button>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('profile.index') }}">Profile</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <a href="{{ route('logout') }}" class="text-error"
                            onclick="event.preventDefault(); this.closest('form').submit();">Keluar</a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
