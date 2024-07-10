@php
    $userName = Auth::check() ? Auth::user()->name : 'Guest';
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

<nav class="bg-base-100 shadow h-20 items-center flex">
    <div class="navbar max-w-7xl mx-auto">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('home') }}"
                            class="{{ Request::is('/') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Beranda</a>
                    </li>
                    <li><a href="{{ route('product.page') }}"
                            class="{{ Request::is('products') || Request::is('products/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Produk</a>
                    </li>
                    <li><a href="{{ route('blogs.page') }}"
                            class="{{ Request::is('blogs') || Request::is('blogs/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Blog</a>
                    </li>

                    <li><a href="{{ route('about.page') }}"
                            class="{{ Request::is('tentang-kami') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Tentang
                            Kami</a>
                    </li>

                </ul>
            </div>


            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />


        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="flex flex-row space-x-6">
                <li><a href="{{ route('home') }}"
                        class="{{ Request::is('/') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Beranda</a>
                </li>
                <li><a href="{{ route('product.page') }}"
                        class="{{ Request::is('products') || Request::is('products/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Produk</a>
                </li>
                <li><a href="{{ route('blogs.page') }}"
                        class="{{ Request::is('blogs') || Request::is('blogs/*') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Blog</a>
                </li>

                <li><a href="{{ route('about.page') }}"
                        class="{{ Request::is('tentang-kami') ? 'font-bold text-primary' : 'text-neutral hover:text-primary' }}">Tentang
                        Kami</a>
                </li>

            </ul>
        </div>
        <div class="navbar-end space-x-6">

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
                            @unless (Auth::user()->hasRole('admin') || Auth::user()->hasRole('seller'))
                                <li><a href="{{ route('profile.index') }}">Profile</a></li>
                            @endunless
                            <li>
                                @if (Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin') }}">Dashboard Admin</a>
                                @else
                                    <a href="{{ route('seller') }}">Dahsboard Seller</a>
                                @endif
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="text-error"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Keluar</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="flex space-x-1">
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    </div>
                @endauth
            @endif
        </div>
    </div>
</nav>
