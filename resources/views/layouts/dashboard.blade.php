<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Dashboard') }}</title>
    <meta name="description" content="Document does not have a meta description">
    @laravelPWA
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        .ck-editor__editable_inline {
            min-height: 450px;
        }

        .drawer-side {

            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .drawer-side::-webkit-scrollbar {
            display: none;
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
                <main class="overflow-y-auto overflow-x-hidden flex-1 p-6 w-full">
                    {{ $slot }}
                </main>
            </div>
            @include('layouts.drawer-side')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('.ckeditor'), {
                    ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    },
                    toolbar: {
                        items: [
                            'heading', 'undo', 'redo', '|', 'bold', 'italic', 'link', 'bulletedList',
                            'numberedList',
                            'blockQuote', 'uploadImage', '|', 'imageStyle:full', 'imageStyle:alignLeft',
                            'imageStyle:alignCenter', 'imageStyle:alignRight'
                        ]
                    },
                    image: {
                        resizeUnit: 'px',
                        toolbar: ['imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                            '|',
                            'resizeImage'
                        ],
                        styles: [
                            'alignLeft', 'alignCenter', 'alignRight'
                        ],
                        resizeOptions: [{
                                name: 'resizeImage:original',
                                label: 'Original size',
                                value: null
                            },
                            {
                                name: 'resizeImage:50',
                                label: '50%',
                                value: '50'
                            },
                            {
                                name: 'resizeImage:75',
                                label: '75%',
                                value: '75'
                            }
                        ]
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
</body>

</html>
