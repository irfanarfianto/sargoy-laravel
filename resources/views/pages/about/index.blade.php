<x-app-layout>
    <h4 class="text-xl">
        {{ __('Halaman Tentang Kami') }}
    </h4>
    <div class="container mx-auto px-4 py-16">
        <h1 class="text-3xl font-bold text-center mb-8">
            {{ __('Tentang Kami') }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="prose text-gray-600">
                <p>{{ __('Paragraf pertama yang menjelaskan tentang perusahaan Anda, misi, visi, dan nilai-nilainya.') }}</p>
                <p>{{ __('Paragraf kedua yang menjelaskan tentang produk atau layanan yang Anda tawarkan.') }}</p>
                <p>{{ __('Paragraf ketiga yang menjelaskan tentang tim Anda dan keahlian mereka.') }}</p>
            </div>

            <div class="flex flex-col items-center">
                <img src="{{ asset('images/about-us.jpg') }}" alt="Gambar tentang perusahaan" class="w-full rounded-lg">
                <p class="text-center mt-4 text-gray-500">{{ __('Keterangan gambar') }}</p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                {{ __('Hubungi Kami') }}
            </a>
        </div>
    </div>
</x-app-layout>
