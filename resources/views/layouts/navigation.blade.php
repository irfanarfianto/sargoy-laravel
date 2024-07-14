@php
    $userName = Auth::check() ? Auth::user()->name : 'Guest';
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

<nav class="bg-base-100 shadow h-16 items-center flex">
    <div class="navbar max-w-7xl mx-auto">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" aria-label="Open Menu" class="btn btn-ghost mr-2 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>

                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a href="/"
                            class="{{ Request::is('/') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Beranda</a>
                    </li>
                    <li><a href="{{ route('product.page') }}"
                            class="{{ Request::is('products') || Request::is('products/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Produk</a>
                    </li>
                    <li><a href="{{ route('blogs.page') }}"
                            class="{{ Request::is('blogs') || Request::is('blogs/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Blogs</a>
                    </li>
                    {{-- 
                    <li><a href="{{ route('about.page') }}"
                            class="{{ Request::is('tentang-kami') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Tentang
                            Kami</a>
                    </li> --}}

                </ul>
            </div>
            <div class="hidden lg:block">
                <x-application-logo class="w-20 h-20  fill-current text-gray-500" />
            </div>
        </div>
        <div class="navbar-center block lg:hidden">
            <x-application-logo class="w-20 h-20  fill-current text-gray-500" />
        </div>
        <div class="navbar-center ">

        </div>
        <div class="navbar-end space-x-6">
            <div class="hidden lg:flex">
                <ul class="flex flex-row space-x-6">
                    <li><a href="/"
                            class="{{ Request::is('/') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Beranda</a>
                    </li>
                    <li><a href="{{ route('product.page') }}"
                            class="{{ Request::is('products') || Request::is('products/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Produk</a>
                    </li>
                    <li><a href="{{ route('blogs.page') }}"
                            class="{{ Request::is('blogs') || Request::is('blogs/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Blogs</a>
                    </li>

                    {{-- <li><a href="{{ route('about.page') }}"
                        class="{{ Request::is('tentang-kami') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Tentang
                        Kami</a>
                </li> --}}

                </ul>
            </div>
            @if (Route::has('login'))
                @auth
                    <div class="dropdown dropdown-end">
                        <button tabindex="0" role="button" class="flex items-center gap-3">
                            <div class="flex flex-col items-end">
                                <span class="hidden md:block">{{ $userName }}</span>
                            </div>
                            <div class="avatar">
                                <div class="mask mask-squircle h-10 w-10">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($initials) }}"
                                        alt="Avatar of {{ $initials }}" />
                                </div>
                            </div>
                        </button>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            @if (Auth::user()->hasRole('visitor'))
                                <li><a href="{{ route('profile.page') }}">Profile</a></li>
                            @endif
                            <li>
                                @if (Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin') }}">Dashboard Admin</a>
                                @endif
                                @if (Auth::user()->hasRole('seller'))
                                    <a href="{{ route('seller') }}">Dashboard Seller</a>
                                @endif
                            </li>
                            <li>
                                <button onclick="document.getElementById('keluar').showModal()"
                                    class="text-error">Keluar</button>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- <div class="flex space-x-1"> --}}
                    <a href="{{ route('login') }}" class="btn btn-ghost">Masuk <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                        </svg>
                    </a>
                    {{-- <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a> --}}
                    {{-- </div> --}}
                @endauth
            @endif
        </div>
    </div>
</nav>

@include('components.modal-logout')
