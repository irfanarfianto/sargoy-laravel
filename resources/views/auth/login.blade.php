<x-guest-layout>
    <!-- Dynamic Title Injection -->
    <x-slot name="pageTitle">
        {{ __('Login') }} | {{ config('app.name', 'Sargoy') }}
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h1 class="text-3xl font-bold text-center mb-2">{{ __('Login') }}</h1>
    <p class="text-sm text-center text-gray-600 mb-4">
        Selamat datang di Official Store Sarung Goyor.
    </p>



    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                placeholder="Masukkan Email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm link link-primary link-hover" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1 w-full" type="password" placeholder="Masukkan Password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>


        <div class="mt-4">
            <button class="btn btn-primary w-full">
                {{ __('Log in') }}
            </button>
        </div>
    </form>


</x-guest-layout>
