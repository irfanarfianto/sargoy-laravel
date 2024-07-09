<div class="dropdown dropdown-top lg:dropdown-left">
    <div tabindex="0" role="button" class="btn btn-ghost m-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
        </svg>
    </div>
    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'created_at', 'direction' => 'desc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'created_at' && request('direction') == 'desc' ? 'checked' : '' }}>
                Terbaru
            </a>
        </li>
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'created_at', 'direction' => 'asc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'created_at' && request('direction') == 'asc' ? 'checked' : '' }}>
                Terlama
            </a>
        </li>
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'name', 'direction' => 'asc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'name' && request('direction') == 'asc' ? 'checked' : '' }}>
                Nama A-Z
            </a>
        </li>
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'name', 'direction' => 'desc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'name' && request('direction') == 'desc' ? 'checked' : '' }}>
                Nama Z-A
            </a>
        </li>
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'status', 'direction' => 'asc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'status' && request('direction') == 'asc' ? 'checked' : '' }}>
                Belum Diverifikasi
            </a>
        </li>
        <li>
            <a
                href="{{ route('dashboard.product.index', ['sort' => 'status', 'direction' => 'desc', 'search' => $search]) }}">
                <input type="radio" name="sort-direction" class="radio radio-secondary"
                    {{ request('sort') == 'status' && request('direction') == 'desc' ? 'checked' : '' }}>
                Sudah Diverifikasi
            </a>
        </li>
    </ul>
</div>
