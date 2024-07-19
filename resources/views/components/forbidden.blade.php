<dialog id="Forbidden" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <form method="dialog">
            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="document.getElementById('Forbidden').close()">✕</button>
        </form>
        <h3 class="flex gap-2 text-lg font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            Akses Ditolak
        </h3>
        <p class="py-4">Anda tidak memiliki hak akses ke halaman ini.</p>
        <div class="modal-action justify-end">
            <button type="button" class="btn btn-primary btn-md"
                onclick="document.getElementById('Forbidden').close()">OK</button>
        </div>
    </div>
</dialog>
