<x-dashboard-layout>
    <div class="pt-14">
        <h4 class="text-xl font-bold text-gray-900">
            {{ __('Dashboard Admin') }}
        </h4>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        <div class="stats shadow bg-white p-6 rounded-lg">
            <div class="stat">
                <div class="flex items-center">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>

                    </div>
                    <div class="ml-4">
                        <div class="stat-title">Total Users</div>
                        <div class="stat-value text-primary">{{ $userCount }}</div>
                        <div class="stat-desc">{{ $percentChangeUsers }} more than last month</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats shadow bg-white p-6 rounded-lg">
            <div class="stat">
                <div class="flex items-center">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>

                    </div>
                    <div class="ml-4">
                        <div class="stat-title">Total Categories</div>
                        <div class="stat-value text-secondary">{{ $categoryCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats shadow bg-white p-6 rounded-lg">
            <div class="stat">
                <div class="flex items-center">
                    <div class="stat-figure text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="stat-title">Total Products</div>
                        <div class="stat-value text-secondary">{{ $productCount }}</div>
                        <div class="stat-desc">{{ $percentChangeProducts }} more than last month</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="mt-8 flex space-x-2 items-center justify-end">
        <x-modal id="filterModal" title="Filter Visits">
            <form action="{{ route('admin') }}" method="GET" class="flex flex-col space-y-2">
                <input type="hidden" name="filter" value="custom_range" class="input input-bordered w-full">
                <div class="flex justify-between space-x-2">
                    <div class="flex flex-col w-full">
                        <label for="start_date" class="label">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                            class="input input-bordered w-full" required>
                    </div>
                    <div class="flex flex-col w-full">
                        <label for="end_date" class="label">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="input input-bordered w-full" required>
                    </div>
                </div>
                <div class="justify-end flex">
                    <button type="submit" class="btn btn-md">Apply</button>
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
                <summary class="btn btn-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                    </svg>Filter by
                    {{ $filter }}
                </summary>
                <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li><button type="submit" name="filter" value="today"
                            class="dropdown-item {{ $filter == 'today' ? 'active' : '' }}">Today</button></li>
                    <li><button type="submit" name="filter" value="this_week"
                            class="dropdown-item {{ $filter == 'this_week' ? 'active' : '' }}">This Week</button>
                    </li>
                    <li><button type="submit" name="filter" value="this_month"
                            class="dropdown-item {{ $filter == 'this_month' ? 'active' : '' }}">This Month</button>
                    </li>
                    <li><button type="submit" name="filter" value="monthly"
                            class="dropdown-item {{ $filter == 'monthly' ? 'active' : '' }}">Monthly</button></li>
                </ul>
            </details>
        </form>
    </div>

    <div class="mt-4">
        <canvas id="visitChart"></canvas>
    </div>


    <h3 class="text-xl font-bold mt-8 mb-4">Latest Users</h3>
    <div class="overflow-x-auto">
        <table class="table-auto min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($latestUsers as $user)
                    <tr>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('visitChart').getContext('2d');
        var visitChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($visitLabels),
                datasets: [{
                    label: 'Visits',
                    data: @json($visitData),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Number of Visits'
                        }
                    }
                }
            }
        });
    </script>
</x-dashboard-layout>
