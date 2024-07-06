<!-- Filter Section -->
<div class="flex space-x-2 items-center justify-end">
    <x-modal id="filterModal" title="Filter Kunjungan">
        <form action="{{ route('admin') }}" method="GET" class="flex flex-col">
            <input type="hidden" name="filter" value="custom_range" class="input input-bordered w-full">
            <div class="flex justify-between space-x-2">
                <div class="flex flex-col w-full">
                    <label for="start_date" class="label">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                        class="input input-bordered w-full" required>
                </div>
                <div class="flex flex-col w-full">
                    <label for="end_date" class="label">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                        class="input input-bordered w-full" required>
                </div>
            </div>
            <div class="justify-end flex mt-10">
                <button type="submit" class="btn btn-md">Terapkan</button>
            </div>
        </form>
    </x-modal>

    <button onclick="document.getElementById('filterModal').showModal()" class="btn btn-sm"><svg
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
        </svg>
    </button>
    <form action="{{ route('admin') }}" method="GET">
        <details class="dropdown dropdown-left">
            <summary class="btn btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
                <span class="hidden md:inline">Filter by
                    @if ($filter == 'today')
                        Hari Ini
                    @elseif($filter == 'this_week')
                        Minggu Ini
                    @elseif($filter == 'this_month')
                        Bulan Ini
                    @elseif($filter == 'monthly')
                        Bulanan
                    @endif
                </span>
            </summary>
            <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <li><button type="submit" name="filter" value="today"
                        class="dropdown-item {{ $filter == 'today' ? 'active' : '' }}">Hari Ini</button></li>
                <li><button type="submit" name="filter" value="this_week"
                        class="dropdown-item {{ $filter == 'this_week' ? 'active' : '' }}">Minggu Ini</button>
                </li>
                <li><button type="submit" name="filter" value="this_month"
                        class="dropdown-item {{ $filter == 'this_month' ? 'active' : '' }}">Bulan Ini</button>
                </li>
                <li><button type="submit" name="filter" value="monthly"
                        class="dropdown-item {{ $filter == 'monthly' ? 'active' : '' }}">Bulanan</button></li>
            </ul>
        </details>
    </form>
</div>
