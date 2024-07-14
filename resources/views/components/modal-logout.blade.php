<dialog id="keluar" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="document.getElementById('keluar').close()">✕</button>
        </form>
        <h3 class="text-lg font-bold">Keluar dari Aplikasi</h3>
        <p class="py-4">Apakah Anda yakin ingin keluar dari aplikasi?</p>
        <div class="modal-action">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="flex gap-2">
                    <button type="button" class="btn btn-ghost btn-md"
                        onclick="document.getElementById('keluar').close()">Batal</button>
                    <button type="submit" class="btn btn-error btn-md">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</dialog>
