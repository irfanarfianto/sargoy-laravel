@php
    $userName = Auth::user()->name;
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

<div class="navbar bg-neutral px-5 fixed top-0 z-50">
    <div class="navbar-start flex items-center">
        <label for="my-drawer-2" class="btn btn-ghost drawer-button lg:hidden mr-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="inline-block text-base-100 w-6 h-6 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </label>
        <a class="text-base-100 text-xl">daisyUI</a>
    </div>
    <div class="navbar-end">
        <div class="dropdown dropdown-end">
            <button tabindex="0" role="button" class="flex items-center gap-3">
                <span class="hidden md:block text-base-100">{{ $userName }}</span>
                <div class="avatar online placeholder">
                    <div class="bg-primary text-neutral-content rounded-full w-8">
                        <span class="text-xl"> {{ $initials }}</span>
                    </div>
                </div>
            </button>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <li><a href="{{ route('profile.edit') }}">Profile</a></li>
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
