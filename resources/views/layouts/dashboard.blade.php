<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashboard') }}</title>
    <meta name="description" content="Document does not have a meta description">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        .ck-editor__editable_inline {
            min-height: 450px;
        }

        .drawer-side {
            /* Aktifkan scrolling */
            scrollbar-width: none;
            /* Sembunyikan scrollbar di Firefox */
            -ms-overflow-style: none;
            /* Sembunyikan scrollbar di IE/Edge */
        }

        .drawer-side::-webkit-scrollbar {
            display: none;
            /* Sembunyikan scrollbar di Chrome/Safari */
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.nav-dashboard')
        <div class="drawer lg:drawer-open">
            <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col items-center lg:ms-72 justify-start">
                <main class="overflow-y-auto flex-1 p-6 w-full">
                    {{ $slot }}
                </main>
            </div>
            @include('layouts.drawer-side')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                },
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
</body>

</html>
