<x-app-layout>
        <!-- Carousel -->
    <div id="default-carousel" class="relative" data-carousel="static">
        <div class="overflow-hidden relative h-96 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.com/docs/images/carousel/carousel-1.svg" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.com/docs/images/carousel/carousel-3.svg" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.com/docs/images/carousel/carousel-3.svg" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
            </div>
        </div>
        
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
       
        <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30  group-focus:ring-4 group-focus:ring-white  group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
        </button>

        <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 0 group-focus:ring-4 group-focus:ring-white  group-focus:outline-none">
                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
        </button>
    </div>

    <!-- Produk Baru -->
    <div class="mt-8 text-2xl">
        {{ __('Produk Baru') }}
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        @for ($i = 1; $i <= 4; $i++)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" alt="Card Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800">Card {{ $i }}</h3>
                <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        @endfor
    </div>
    <div class="flex justify-center mt-8">
        <a href="/products" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Lihat Semua Produk
        </a>
    </div>

    <!-- Produk Unggulan -->
    <div class="mt-8 text-2xl">
        {{ __('Produk Unggulan') }}
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        @for ($i = 1; $i <= 4; $i++)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" alt="Card Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800">Card {{ $i }}</h3>
                <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        @endfor
    </div>
    <div class="flex justify-center mt-8">
        <a href="/products" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Lihat Semua Produk
        </a>
    </div>

    <!-- Semua Produk -->
    <div class="mt-8 text-2xl">
        {{ __('Semua Produk') }}
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8">
        @for ($i = 1; $i <= 8; $i++)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" alt="Card Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800">Card {{ $i }}</h3>
                <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
        </div>
        @endfor
    </div>
    <div class="flex justify-center mt-8">
        <a href="/products" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Lihat Semua Produk
        </a>
    </div>

    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</x-app-layout>
