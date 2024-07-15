<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, Anda perlu memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke Anda? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan lagi.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat registrasi.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button class="btn btn-primary">
                    {{ __('Kirimkan Ulang Tautan Verifikasi') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="link link-primary">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>
