<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/png">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white lg:bg-gray-100">
        <x-application-logo class="w-20 h-20  fill-current text-gray-500" />
        <div class="w-full sm:max-w-md mt-6 p-8 bg-white shadow-none lg:shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
        <div class="mt-4 text-center">
            @if (request()->routeIs('login'))
                <p class="text-sm text-gray-600">
                    Belum punya akun? <a class="text-sm link link-primary link-hover"
                        href="{{ route('register') }}">Daftar
                        sekarang</a>
                </p>
            @elseif (request()->routeIs('register'))
                <p class="text-sm text-gray-600">
                    Sudah punya akun? <a class="text-sm link link-primary link-hover" href="{{ route('login') }}">Masuk
                        sekarang</a>
                </p>
            @endif
        </div>
        <footer class="fixed bottom-0 left-0 p-4">
            <div class="flex flex-col justify-center items-start space-y-2">
                <p class="text-xs text-gray-600">Didukung oleh</p>
                <div class="flex flex-row justify-center items-center space-x-3">
                    <img src="{{ asset('images/kemenparekraf.png') }}" alt="Logo Kemenparekraf"
                        class=" w-12 h-12 object-cover">
                    <img src="{{ asset('images/dicoding.png') }}" alt="Logo dicoding" class=" w-28 h-12 object-cover">
                    {{-- <p class="text-xs text-neutral leading-relaxed">
                        Kemenparekraf / Baparekraf <br>
                        Republik
                        Indonesia
                    </p> --}}
                </div>
            </div>
            <div class="flex space-x-3 mt-3">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} {{ config('app.name', 'Sargoy') }}. All
                    rights
                    reserved.</p>
                <a href="" class="text-sm link link-primary link-hover">Kebijakan Privasi</a>
            </div>
        </footer>
    </div>
</body>

</html>
