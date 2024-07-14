<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/logo.png') }}" type="image/png">
    <title>{{ $pageTitle ?? config('app.name', 'Laravel') }}</title>
    @laravelPWA
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-base-100">
        <!-- Tombol "Lewati Konten" -->
        <a href="#main-content" class="skip-link">
            Lewati Konten
        </a>

        <header class="sticky top-0 z-50 bg-white shadow">
            @include('layouts.navigation')
        </header>

        @if (request()->is('/'))
            @include('components.carousel')
        @endif



        <!-- Page Content -->
        <main id="main-content" class="max-w-7xl mx-auto mt-3 px-3 lg:px-[8px]">
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</body>

</html>
