<x-guest-layout>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h1>403 Forbidden</h1>
            <p>{{ $exception }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali ke halaman sebelumnya</a>
    </div>
</x-guest-layout>
