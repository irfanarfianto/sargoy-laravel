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
        <div class="navbar-center w-3/5 hidden lg:flex">
            <form action="{{ route('search') }}" method="GET" class="flex items-center w-full mx-9">
                <div class="relative w-full">
                    <input type="text" class="input input-bordered w-full pl-10" placeholder="Cari Produk"
                        name="query" minlength="3" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 opacity-70">
                        <path fill-rule="evenodd"
                            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </form>
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
                        <button tabindex="0" role="button" class="flex items-center">
                            {{-- <div class="flex flex-col items-end">
                                <span class="hidden md:block">{{ $userName }}</span>
                            </div> --}}
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
                    <a href="{{ route('login') }}" class="btn btn-ghost">Masuk
                    </a>
                    {{-- <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a> --}}
                    {{-- </div> --}}
                @endauth
            @endif
        </div>
    </div>
</nav>

@include('components.modal-logout')
